<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimeConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'prime_id',
        'min_cat',
        'max_cat',
        'valeur'
    ];

    public function prime()
    {
        return $this->belongsTo(Prime::class);
    }

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