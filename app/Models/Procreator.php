<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procreator extends CoreModel
{
    protected $fillable = [
        'fio', 'id', 'phone',
        'viber_id', 'vk_id'
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}