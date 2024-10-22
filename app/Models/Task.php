<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Note;

class Task extends Model
{

    protected $fillable = [
        'subject',    
        'description',   
        'start_date',    
        'due_date',      
        'status',       
        'priority',      
    ];
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

}
