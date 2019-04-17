<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = [
        'name'
    ];

    public function car_model() {
        return $this->hasMany('App/Car_model','manufacturer_id');
    }

}
