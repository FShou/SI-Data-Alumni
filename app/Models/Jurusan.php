<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    // public function prodi(): HasMany
    // {
    //     return $this->hasMany(Prodi::class);
    // }
    use HasFactory;
    protected $table = 'jurusan';
    protected $fillable = [
        'nama_jurusan',
        'kode_jurusan',
    ];
}
