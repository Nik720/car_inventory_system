<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manufacturer;
use App\Car_model;
use App\Model_image;
use Validator;
use App\Services\ImageService;

class CarModelController extends Controller
{
    protected $imageService;

    public function __construct()
    {
        $this->imageService = new ImageService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'modelName' => 'bail|required|max:100',
            'note' => 'bail|required',
            'manufacturer' => 'bail|required|numeric',
            'color' => 'bail|required',
            'manuf_year' => 'bail|required|numeric',
            'reg_number' => 'bail|required',
        ];
        $validatedData =  Validator::make($request->all(), $rules);
        if ($validatedData->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validatedData->messages()
            ]);
        }

        try {
            $model = Car_model::create([
                'name' => $request->modelName,
                'note' => $request->note,
                'manufacturer_id' => $request->manufacturer,
                'color' => $request->color,
                'mf_year' => $request->manuf_year,
                'registration_no' => $request->reg_number
            ]);

            if($request->attachments) {
                $this->imageService->uploadImages($request, $model);
            }

            return response()->json([
                'status' => (bool) $model,
                'data'   => $model,
                'message' => $model ? 'Car Model Created!' : 'Error Creating Model'
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getCarModelList(Request $request) {
        $carModels = Manufacturer::with('car_models')
            ->with('car_models.model_images')->paginate(5);
        return response()->json($carModels);
    }

    public function destroy(Car_model $carModel) {
        try {
            $status = $carModel->delete();
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Model Deleted!' : 'Error Deleting Model'
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
