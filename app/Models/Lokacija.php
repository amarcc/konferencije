<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokacija extends Model
{
    use HasFactory;
    protected $fillable = [
        'ime',
        'br_mjesta',
        'adresa'
    ];

    public function scopeId(Builder $query, int $id): Builder{
        return $query -> where('id', '=', $id);
    }
    
    protected $table = 'lokacija';
}
