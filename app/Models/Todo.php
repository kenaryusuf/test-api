<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    public $table = 'todo';

    public $fillable = [
        'user_id',
        'title',
        'description',
        'email',
        'date',
        'status',
    ];
}
