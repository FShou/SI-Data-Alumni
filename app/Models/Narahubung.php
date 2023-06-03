<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Narahubung extends Model
{
    use HasFactory;
    protected $table = 'narahubung';
    protected $fillable= [
        'nama_narahubung',
        'email_narahubung'
    ];
}
