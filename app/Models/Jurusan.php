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
    protected $primaryKey= 'id_jurusan';
    protected $keyType= 'char';
    public $incrementing= false;
    protected $guarded = [];
}
