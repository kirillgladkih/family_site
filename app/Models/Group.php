<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends CoreModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'age_before',
        'age_after',
        'name'
    ];

}
