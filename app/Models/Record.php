<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'date', 'hour', 'client_id',
        'visit', 'with_procreator', 'friends',
        'schedule_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function getHourAttribute($value)
    {
        return Carbon::parse($value)->format("H:i");
    }
}
