<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alumni extends Model
{
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class,'id_prodi');
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class,'id_jurusan');
    }
    public function angkatan(): BelongsTo
    {
        return $this->belongsTo(Angkatan::class,'id_angkatan');
    }
    use HasFactory;

    // database properties
    protected $table = 'alumni';
    protected $fillable = [
        'nim',
        'nama_alumni',
        'gender',
        'email_alumni',
        'foto',
        'pekerjaan',
        'id_prodi',
        'id_jurusan',
        'id_angkatan',
        'id_narahubung',
    ];

}
