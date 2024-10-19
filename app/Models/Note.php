<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Note;

class Note extends Model
{
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
