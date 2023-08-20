<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;

    protected $table = 'tutors';

    protected $fillable = [
        'full_name',
        'cin',
        'profession',
        'tel_domicile',
        'tel_bureau',
        'gsm',
        'observation',
        'student_id',
    ];

    // Define the relationship between Tutor and Student (assuming One-to-Many)
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
