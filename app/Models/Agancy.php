<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agancy extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'location',
        'img_url',
        'city_id',
        'manager_id',
    ];
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function tours()
    {
        return $this->hasMany(TourDetails::class, 'agancy_id');
    }
}
