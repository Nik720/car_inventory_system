<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car_model extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'manufacturer_id', 'color', 'mf_year', 'registration_no', 'note'
    ];

    public function manufacturer() {
        return $this->belongsTo('App/Manufacturer');
    }

    public function model_images() {
        return $this->hasMany('App/Model_image', 'car_model_id');
    }
}
