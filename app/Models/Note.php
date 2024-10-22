<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Note;

class Note extends Model
{

    protected $fillable = [
        'subject',      
        'note',          
        'task_id',     
        'attachments',    
    ];


    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
