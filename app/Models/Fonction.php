<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonction extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'abrv', 'cat', 'groupe_id'];
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
}
