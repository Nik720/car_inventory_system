<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Manufacturer;
use App\Model_image;
class Car_model extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'manufacturer_id', 'color', 'mf_year', 'registration_no', 'note'
    ];

    public function manufacturer() {
        return $this->belongsTo(Manufacturer::class);
    }

    public function model_images() {
        return $this->hasMany(Model_image::class, 'car_model_id');
    }
}
