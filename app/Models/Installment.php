<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $table = 'installments';

    protected $fillable = [
        'month',
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
}
