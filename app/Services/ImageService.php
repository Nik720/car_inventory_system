<?php
namespace App\Services;

use App\Repository\ImageRepository;
use Illuminate\Http\Request;

class ImageService extends ImageRepository
{
    protected $imageRepo;
    public function __construct()
    {
        $this->imageRepo = new ImageRepository();
    }

    public function uploadImages($request, $model) {
        return $this->imageRepo->processUploadImages($request, $model);
    }

}