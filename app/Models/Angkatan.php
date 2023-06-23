<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Angkatan extends Model
{
    public function narahubung():HasOne {
        return $this->hasOne(Narahubung::class,'id_narahubung');
    }
    use HasFactory;
    protected $table = 'angkatan';
    protected $guarded = [];
}
