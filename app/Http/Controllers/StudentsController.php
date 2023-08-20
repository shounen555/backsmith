<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use App\Models\SchoolYear;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentsController extends Controller
{

    private function calculateTotalHoursByMonth($absences)
    {
        $months = array_fill(0, 10, 0); // Initialize the array with 10 elements (September to June)

        foreach ($absences as $absence) {
            $monthIndex = (int) date('m', strtotime($absence->date)) - 9; // Get the month index (0 to 9 for September to June)

            if ($monthIndex < 0) {
                $monthIndex += 12; // Wrap around to treat February as 11th month, June as 5th, etc.
            }

            $hours               = $this->calculateHours($absence->from, $absence->to);
            $months[$monthIndex] += $hours;
        }

        return $months;
    }

    // Helper function to calculate the number of hours between two time values
    private function calculateHours($from, $to)
    {
        $fromTime = strtotime($from);
        $toTime   = strtotime($to);
        $hours    = round(($toTime - $fromTime) / 3600, 2);
        return $hours;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch the students from the database
        $students = Student::orderByDesc('created_at')->where('isStudent', true)
            ->get();

        // Attach the full image URL or path to each student
        foreach ($students as $student) {
            if ($student->pic != null) {
                $student->pic = asset('storage/adam_pics/' . $student->pic); // Assuming your images are stored in the 'storage/app' directory
                // $student->pic = Storage::url($student->pic);
            }
        }

        // Modify the students data to include group and class names
        $students = $students->map(function ($student) {
            return [
                'id'             => $student->id,
                'first_name_fr'  => $student->first_name_fr,
                'last_name_fr'   => $student->last_name_fr,
                'matricule'      => $student->matricule,
                'cin'            => $student->cin,
                'cen'            => $student->cen,
                'gender'         => $student->gender,
                'birth_date'     => $student->birth_date,
                'isStudent'      => $student->isStudent,
                'pic'            => $student->pic,
                'class'          => $student->classe->name,
                'group'          => $student->group ? $student->group->name : null,
                'school_year'    => $student->schoolYear->name,
                'class_id'       => $student->class_id,
                'group_id'       => $student->group_id ? $student->group_id : null,
                'school_year_id' => $student->school_year_id,
            ];
        });

        // Return the students as a JSON response
        return response()->json($students);
    }
public function getOldStudentsindex(){
        // Fetch the students from the database
        $students = Student::orderByDesc('created_at')->where('isStudent', false)
            ->get();

        // Attach the full image URL or path to each student
        foreach ($students as $student) {
            if ($student->pic != null) {
                $student->pic = asset('storage/adam_pics/' . $student->pic); // Assuming your images are stored in the 'storage/app' directory
                // $student->pic = Storage::url($student->pic);
            }
        }

        // Modify the students data to include group and class names
        $students = $students->map(function ($student) {
            return [
                'id'             => $student->id,
                'first_name_fr'  => $student->first_name_fr,
                'last_name_fr'   => $student->last_name_fr,
                'matricule'      => $student->matricule,
                'cin'            => $student->cin,
                'cen'            => $student->cen,
                'gender'         => $student->gender,
                'birth_date'     => $student->birth_date,
                'isStudent'      => $student->isStudent,
                'pic'            => $student->pic,
                'class'          => $student->classe->name,
                'group'          => $student->group ? $student->group->name : null,
                'school_year'    => $student->schoolYear->name,
                'class_id'       => $student->class_id,
                'group_id'       => $student->group_id ? $student->group_id : null,
                'school_year_id' => $student->school_year_id,
            ];
        });

        // Return the students as a JSON response
        return response()->json($students);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'first_name_fr'             => 'string',
            'last_name_fr'              => 'string',
            'first_name_ar'             => 'string',
            'last_name_ar'              => 'string',
            'matricule'                 => 'nullable|string',
            'cin'                       => 'nullable|string',
            'cen'                       => 'nullable|string',
            'gender'                    => 'nullable|string',
            'birth_date'                => 'nullable|date',
            'birth_place'               => 'nullable|string',
            'nationality'               => 'nullable|string',
            'address'                   => 'nullable|string',
            'tel'                       => 'nullable|string',
            'monthly_payment'           => 'nullable|numeric',
            'annually_payment'          => 'nullable|numeric',
            'health_state'              => 'nullable|string',
            'medicine'                  => 'nullable|string',
            'medicine_tel'              => 'nullable|string',
            'medicine_gsm'              => 'nullable|string',
            'medicine_measures'         => 'nullable|string',
            'previous_establishment'    => 'nullable|string',
            'previous_level'            => 'nullable|string',
            'isStudent'                 => 'nullable',
            'last_year_overall_average' => 'nullable|numeric',
            'school_year_id'            => 'nullable|integer|exists:school_years,id',
            'class_id'                  => 'nullable|integer|exists:classes,id',
            'group_id'                  => 'nullable|integer|exists:groups,id',
        ]);

        // Handle the image file upload

        $path_filename = "";
        if ($request->hasFile('pics')) {
            $files = $request->file('pics');

            // Handle the uploaded files

            foreach ($files as $pic) {
                $extension = $pic->getClientOriginalExtension();


                // Generate a unique file name with the original extension
                $path_filename = uniqid() . '.' . $extension;

                // Store the file with the desired name and extension
                $pic->storeAs('public/adam_pics/', $path_filename);
            }
        }


        // Create a new Student instance with the validated data
        $student = new Student($validatedData);

        $student->pic       = $path_filename;
        $student->isStudent = $request->input('isStudent');
        // Save the student to the database
        $student->save();

        // Return a JSON response indicating success
        return response()->json(['message' => 'Student added successfully'], 201);
    }

    // Helper function to calculate the total hours of absences for each month


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::with([
            'classe',
            'schoolYear',
            'group',
            'tutors',
            'installments' => function ($query) {
                $query->orderByDesc('created_at');
            },
            'inscriptions' => function ($query) {
                $query->orderByDesc('created_at');
            },
            'absences'     => function ($query) {
                $query->orderByDesc('date');
            },
            'retards'      => function ($query) {
                $query->orderByDesc('date');
            },

        ])
            ->where('id', $id)
            ->first();

        if ($student->pic) {
            $student->pic = asset('storage/adam_pics/' . $student->pic);
        }
        // Get the school_year name for each inscription
        $student->inscriptions->transform(function ($inscription) {
            $inscription->school_year = $inscription->schoolYear->name;
            unset($inscription->schoolYear);
            return $inscription;
        });

        return response()->json($student);
    }

    public function storeStudentDocs(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name'       => 'required|string',
            'student_id' => 'required|integer|exists:students,id',
        ]);
        $path_filename = "";
        if ($request->hasFile('docs')) {
            $files = $request->file('docs');

            // Handle the uploaded files

            foreach ($files as $doc) {
                $extension = $doc->getClientOriginalExtension();


                // Generate a unique file name with the original extension
                $path_filename = uniqid() . '.' . $extension;

                // Store the file with the desired name and extension
                $doc->storeAs('public/adam_docs/', $path_filename);
            }
        }

        $doc       = new Doc($validatedData);
        $doc->path = $path_filename;
        $doc->save();
        return response()->json(['message' => 'Document added successfully'], 201);

    }

    public function destroyStudentDocs(string $id)
    {
        $doc = Doc::find($id);

        if (Storage::exists('public/adam_docs/' . $doc->path)) {
            Storage::delete('public/adam_docs/' . $doc->path);
        }
        // Delete the doc
        $doc->delete();

        // Return a response indicating success
        return response()->json(['message' => 'Doc deleted successfully']);

    }


    public function getStudentDocs($studentId)
    {
        // Find the student by ID
        $student = Student::find($studentId);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Retrieve the docs for the student
        $docs = $student->docs;

        if (!$docs->isEmpty()) {
            // Update the path for each doc to include the asset URL
            foreach ($docs as $doc) {
                $doc->path = asset('storage/adam_docs/' . $doc->path);
            }
        }



        return response()->json($docs);
    }


    public function getStudentAbsenceHours($studentId, $school_year_id)
    {
        // Find the student by ID
        $student = Student::find($studentId);

        // Find the school year by ID
        $school_year = SchoolYear::find($school_year_id);

        // Retrieve the "from" and "to" dates of the school year
        $fromDate = $school_year->from;
        $toDate   = $school_year->to;

        // Get the absences where the date is between the "from" and "to" dates of the school year
        $absences = $student->absences()->whereBetween('date', [$fromDate, $toDate])->get();

        // Calculate the total hours of absences for each month
        $totalHoursByMonth = $this->calculateTotalHoursByMonth($absences);

        return response()->json($totalHoursByMonth);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the student by ID
        $student = Student::find($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'first_name_fr'             => 'string',
            'last_name_fr'              => 'string',
            'first_name_ar'             => 'string',
            'last_name_ar'              => 'string',
            'matricule'                 => 'nullable|string',
            'cin'                       => 'nullable|string',
            'cen'                       => 'nullable|string',
            'gender'                    => 'nullable|string',
            'birth_date'                => 'nullable|date',
            'birth_place'               => 'nullable|string',
            'nationality'               => 'nullable|string',
            'address'                   => 'nullable|string',
            'tel'                       => 'nullable|string',
            'monthly_payment'           => 'nullable|numeric',
            'annually_payment'          => 'nullable|numeric',
            'health_state'              => 'nullable|string',
            'medicine'                  => 'nullable|string',
            'medicine_tel'              => 'nullable|string',
            'medicine_gsm'              => 'nullable|string',
            'medicine_measures'         => 'nullable|string',
            'previous_establishment'    => 'nullable|string',
            'previous_level'            => 'nullable|string',
            'last_year_overall_average' => 'nullable|numeric',
            'school_year_id'            => 'nullable|integer|exists:school_years,id',
            'class_id'                  => 'nullable|integer|exists:classes,id',
            'group_id'                  => 'nullable|integer|exists:groups,id',
        ]);

        // Handle the image file upload
        $path_filename = $student->pic; // Retain the current image path if not updated

        if ($request->hasFile('pics')) {
            $files = $request->file('pics');

            // Handle the uploaded files
            foreach ($files as $pic) {
                if (Storage::exists('public/adam_pics/' . $path_filename)) {
                    Storage::delete('public/adam_pics/' . $path_filename);
                }

                $extension = $pic->getClientOriginalExtension();

                // Generate a unique file name with the original extension
                $path_filename = uniqid() . '.' . $extension;

                // Store the file with the desired name and extension
                $pic->storeAs('public/adam_pics/', $path_filename);
            }
        }

        // Update the student model with the validated data
        $student->update($validatedData);
        // Update the pic field with the new image path
        $student->pic = $path_filename;

        // Save the updated student to the database
        $student->save();

        // Return a JSON response indicating success
        return response()->json(['message' => 'Student updated successfully'], 200);
    }

    public function updateDeletedStudents(string $id)
    {
        $student = Student::find($id);

        // Delete the student
        $student->isStudent = 1;
        $student->save();

        // Return a response indicating success
        return response()->json(['message' => 'student restored successfully']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);

        // Delete the student
        $student->isStudent = 0;
        $student->save();

        // Return a response indicating success
        return response()->json(['message' => 'student deleted successfully']);
    }
}