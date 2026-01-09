<?php

namespace App\Models;

use DateTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Konferencija extends Model
{
    use HasFactory;

    protected $fillable  = [
        'ime',
        'br_mjesta',
        'pocetak',
        'kreator',
        'lokacija',
        'status',
        'link',
        'org_file'
    ];

    protected $casts = [ 
        'pocetak' => 'datetime'
    ];

    public function toPredavaci(): HasMany{
        return $this -> hasMany(Predavaci::class);
    }
    public function toPrijava(): HasMany{
        return $this -> hasMany(Prijava::class, 'konferencija_id');
    }

    public function toKreator(): BelongsTo{
        return $this -> belongsTo(User::class, "kreator");    
    }

    public function toLokacija(): BelongsTo{
        return $this -> belongsTo(Lokacija::class, "lokacija");
    }

    public function scopeCheckForTime(Builder $query, string $time, int $lokacija):Builder{
        $time = Carbon::parse($time, "UTC");
        $time->setTimezone('UTC');

        $start = $time -> copy() -> subHours(2);
        $end = $time -> copy() -> addHours(2);

        return $query -> whereBetween('pocetak', [$start, $end]) -> where('lokacija', '=', $lokacija) -> where('status', '!=', 'odbijeno');
    } 

    public function scopeNotIncluding(Builder $query, int $id):Builder {
        return $query -> where('id', '!=', $id);
    }

    protected $table = 'Konferencija';
}
