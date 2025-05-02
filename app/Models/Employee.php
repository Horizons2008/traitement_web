<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomAr', 'prenAr', 'nomFr', 'prenFr', 'mobile', 'ddn', 'ldn',
        'sit_famill', 'nbrEnfant', 'Plus10', 'endicape', 'ccp', 'dateRecrut',
        'lastGraduation', 'cat', 'echelon', 'nbrAnneeExperience',
        'fonction_id', 'groupe_id'
    ];

    protected $casts = [
        'ddn' => 'date',
        'ccp' => 'date',
        'dateRecrut' => 'date',
        'lastGraduation' => 'date',
        'endicape' => 'boolean',
    ];

    // Relationship with Prime (many-to-many)
    public function primes()
{
    return $this->belongsToMany(Prime::class)
                ->using(EmployeePrime::class)
                ->withPivot('type', 'valeur');
}

    // Relationship with Fonction (one-to-one)
    public function fonction()
    {
        return $this->belongsTo(Fonction::class);
    }

    // Relationship with Groupe (one-to-one)
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    // Accessor for family situation
    public function getFamilySituationAttribute()
    {
        return match($this->sit_famill) {
            0 => 'Single',
            1 => 'Married with Foyer',
            2 => 'Married without Foyer',
            default => 'Unknown',
        };
    }

    // Accessor for full name
    public function getFullNameAttribute()
    {
        return "{$this->nomFr} {$this->prenFr}";
    }

    // Accessor for Arabic full name
    public function getFullNameArAttribute()
    {
        return "{$this->nomAr} {$this->prenAr}";
    }
}