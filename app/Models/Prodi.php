<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prodi extends Model
{
    use HasFactory;

    // Relasi Prodi
    public function alumni(): HasMany
    {
        return $this->hasMany(Alumni::class);
    }
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Database properties
    protected $table = 'prodi';
    protected $fillable = [
        'nama_prodi',
        'id_jurusan',
        'kode_prodi'
    ];
}
