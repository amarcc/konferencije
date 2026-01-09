<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Administracija extends Model
{
    use HasFactory;
    protected $fillable = [
        'datum_zaposljenja',
        'user_id'
    ];

    public function toUser(): BelongsTo{
        return $this -> belongsTo(User::class);
    }

    protected $table = 'Administracija';
}
