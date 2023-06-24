<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alumni extends Model
{
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class,'id_prodi','id_prodi');
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class,'id_jurusan','id_jurusan');
    }
    public function angkatan(): BelongsTo
    {
        return $this->belongsTo(Angkatan::class,'id_angkatan');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'id_user');
    }
    use HasFactory;

    // database properties
    protected $table = 'alumni';

    protected $guarded=[];
}
