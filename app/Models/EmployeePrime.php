<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeePrime extends Pivot
{
    protected $table = 'employee_prime';
    
    protected $fillable = [
        'employee_id',
        'prime_id',
        'type',
        'valeur'
    ];
    
    protected $casts = [
        'type' => 'integer',
        'valeur' => 'integer'
    ];
    
    // If you need to add methods to handle the pivot relationship
    public function getFormattedTypeAttribute()
    {
        return match($this->type) {
            0 => 'pourcentage',
            1 => 'valeur',
            2 => 'points',
            default => 'Unknown',
        };
    }
}