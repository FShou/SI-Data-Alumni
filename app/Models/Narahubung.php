<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Narahubung extends Model
{
    public function alumni(): HasMany{

        return $this->hasMany(Alumni::class);
    }

    use HasFactory;
    protected $table = 'narahubung';
    protected $fillable= [
        'nama_narahubung',
        'email_narahubung'
    ];
}
