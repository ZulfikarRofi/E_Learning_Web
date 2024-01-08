<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    public function quiz()
    {
        return $this->belongsTo(Kuis::class);
    }

    public function questionOptions()
    {
        return $this->hasMany(Option::class);
    }
}
