<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourTimePlaceModel extends Model
{
    use HasFactory;
    protected $table = "tour_place_time_models";
    protected $fillable = [
        'tour_id',
        'place_id',
        'time_id',
        'day',

    ];

    public function tour()
    {
        return $this->belongsTo(TourDetails::class, 'tour_id');
    }
    public function timeStep()
    {
        return $this->belongsTo(TimeStep::class, 'time_id');
    }
    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }
}
