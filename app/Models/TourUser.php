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
}
