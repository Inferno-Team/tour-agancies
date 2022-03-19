<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function agancies()
    {
        return $this->hasMany(Agancy::class, 'city_id');
    }
}
