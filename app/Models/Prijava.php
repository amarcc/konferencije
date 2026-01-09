<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prijava extends Model
{
    /** @use HasFactory<\Database\Factories\PrijavaFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'konferencija_id'];
    
    public function toUser():BelongsTo{
        return $this -> belongsTo(User::class, 'user_id');
    }

    public function toKonferencija():BelongsTo{
        return $this -> belongsTo(Konferencija::class, 'konferencija_id');
    }

    protected $table = 'prijava';
}
