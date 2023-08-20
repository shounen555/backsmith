<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $table = 'absences';

    protected $fillable = [
        'date',
        'from',
        'to',
        'is_justified',
        'justification',
        'student_id',
    ];

    // Define the relationship with the Student model
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
