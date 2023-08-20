<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retard extends Model
{
    use HasFactory;

    protected $table = 'retards';

    protected $fillable = [
        'date',
        'time',
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
