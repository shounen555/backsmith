<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'class_id'];

    public function class()
    {
        return $this->belongsTo(Classe::class);
    }
}
