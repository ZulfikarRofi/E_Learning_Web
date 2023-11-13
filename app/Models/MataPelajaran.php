<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;
    protected $table = 'mapel';
    protected $fillable = [
        'name',
        'jam_pelajaran'
    ];

    protected $hidden = [];
}
