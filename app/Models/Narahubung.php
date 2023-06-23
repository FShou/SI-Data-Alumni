<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Narahubung extends Model
{
    public function alumni(): HasMany{

        return $this->hasMany(Alumni::class);
    }
    public function angkatan(): BelongsTo{
        return $this->belongsTo(Angkatan::class,'id_angkatan');
    }

    use HasFactory;
    protected $table = 'narahubung';
    protected $guarded = [];
}
