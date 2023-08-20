<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    use HasFactory;

    protected $table = 'docs';

    protected $fillable = [
        'name',
        'path',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
