<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prime extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'abrv',
        'groupe_id',
        'min_cat',
        'max_cat'
    ];
    
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
    public function employees()
    {
        return $this->belongsToMany(Employee::class)
                    ->using(EmployeePrime::class)
                    ->withPivot('type', 'valeur');
    }
    
    
    // Accessor for category range display
    public function getCategoryRangeAttribute()
    {
        if ($this->min_cat && $this->max_cat) {
            return "Cat {$this->min_cat} - {$this->max_cat}";
        } elseif ($this->min_cat) {
            return "From Cat {$this->min_cat}";
        } elseif ($this->max_cat) {
            return "Up to Cat {$this->max_cat}";
        }
        return "All Categories";
    }
}