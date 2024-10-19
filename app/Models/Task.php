<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Note;

class Task extends Model
{
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

}
