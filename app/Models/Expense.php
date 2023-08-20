<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';

    protected $fillable = [
        'montant',
        'date',
        'type_id',
        'raison_id',
        'raison_text',
        'observation',
    ];

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'type_id');
    }

    public function raison()
    {
        return $this->belongsTo(Raison::class);
    }
}
