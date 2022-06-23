<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost',
        'seat_count',
        'agancy_id',
        'city_id',
        'start_at',
        'end_at',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function agancy()
    {
        return $this->belongsTo(Agancy::class, 'agancy_id');
    }
    public function users()
    {
        return $this->hasManyThrough(User::class, TourUser::class, 'tour_id', 'user_id');
    }
    public function tourPlaceTime()
    {
        return $this->hasMany(TourTimePlaceModel::class, 'tour_id');
    }
    public function times()
    {
        return $this->hasManyThrough(
            TimeStep::class,
            TourTimePlaceModel::class,
            'tour_id',
            'id'
        );
    }
    public function places()
    {
        return  $this->hasManyThrough(
            Place::class,
            TourTimePlaceModel::class,
            'place_id',
            'id',
        );
    }
    public function format()
    {
        return [
            'id' => $this->id,
            'cost' => $this->cost,
            'seat_count' => $this->seat_count,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'created_at' => $this->created_at->diffForHumans(),
            'city' => $this->city,
            
        ];
    }
}
