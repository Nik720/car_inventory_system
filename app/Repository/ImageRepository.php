<?php


namespace App\Repository;
use App\Model_image;

class ImageRepository
{
    public function __construct()
    {
    }

    public function processUploadImages($request, $model) {
        $images = [];
        foreach ($request->attachments as $photo) {
            $filename = $photo->store('photos');
            $images[] = Model_image::create([
                'car_model_id' => $model->id,
                'image_name' => $filename
            ]);
        }
        return $images;
    }
}