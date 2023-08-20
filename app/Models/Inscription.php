<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $table = 'inscriptions';

    protected $fillable = [
        'school_year_id',
        'payment_date',
        'montant',
        'is_cheque',
        'cheque_is_payed',
        'cheque_number',
        'cheque_societe',
        'student_id',
    ];

    // Define the relationship with the Student model
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id'); // Specify the foreign key column 'school_year_id'
    }
}
