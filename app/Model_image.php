<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Model_image extends Model
{
    protected $fillable = [
        'image_name', 'car_model_id'
    ];

    public function car_model() {
        return $this->belongsTo('App/Car_modelController');
    }
}
