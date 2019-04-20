<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Car_model;
use App\Model_image;
class Manufacturer extends Model
{
    protected $fillable = [
        'name'
    ];
    protected $hidden = ["created_at", "updated_at"];

    public function car_models() {
        return $this->hasMany(Car_model::class,'manufacturer_id');
    }

}
