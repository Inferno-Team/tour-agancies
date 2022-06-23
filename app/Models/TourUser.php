<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tour_id',
        'payment_code',
        'payment_method',
        'approved',
        'seat_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tour()
    {
        return $this->belongsTo(TourDetails::class, 'tour_id');
    }
    public function format(){
       return [
           'id' => $this->id,
           'user_id' => $this->user_id,
           'tour_id' => $this->tour_id,
           'payment_code' => $this->payment_code,
           'payment_method' => $this->payment_method,
           'approved' => $this->approved,
           'seat_number' => $this->seat_number,
           'updated_at' => $this->updated_at->diffForHumans(),
           'user'=> $this->user,
       ];
    }
}
