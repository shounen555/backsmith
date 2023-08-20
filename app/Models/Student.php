<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'first_name_fr', 'last_name_fr', 'first_name_ar', 'last_name_ar', 'matricule',
        'cin', 'cen', 'gender', 'birth_date', 'birth_place', 'nationality',
        'address', 'tel', 'monthly_payment', 'annually_payment', 'operator',
        'health_state', 'medicine', 'medicine_tel', 'medicine_gsm', 'medicine_measures',
        'previous_establishment', 'previous_level', 'last_year_overall_average',
        'status', 'pic', 'school_year_id', 'class_id', 'group_id'
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'class_id'); // Specify the foreign key column 'class_id'
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id'); // Specify the foreign key column 'group_id'
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id'); 
    }

    public function tutors()
    {
        return $this->hasMany(Tutor::class); 
    }

    public function docs()
    {
        return $this->hasMany(Doc::class); 
    }

    public function installments()
    {
        return $this->hasMany(Installment::class); 
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class); 
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function retards()
    {
        return $this->hasMany(Retard::class);
    }
}
