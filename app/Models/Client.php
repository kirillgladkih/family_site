<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'procreator_id', 'age', 'type_id',
        'payed', 'pass', 'visit', 'fio', 'status_id',
        'group_id', 'coins'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $group = Group::where('age_before', '<=', $model->age)
                ->where('age_after', '>=', $model->age)
                ->first();

            $model->group_id =  $group->id;
        });
    }

    protected $attributes = [
        'payed' => 0,
        'pass' => 0,
        'visit' => 0,
    ];

    public function procreator()
    {
        return $this->belongsTo(Procreator::class, 'procreator_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
