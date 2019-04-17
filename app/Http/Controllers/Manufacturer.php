<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class Manufacturer extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'manufacturerName' => 'required|unique:manufacturers,name|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try {
            $manufacturer = \App\Manufacturer::create([
                'name' => $request->manufacturerName
            ]);

            dd($manufacturer);

            return response()->json([
                'status' => (bool) $manufacturer,
                'data'   => $manufacturer,
                'message' => $manufacturer ? 'Manufacturer Created!' : 'Error Creating manufacturer'
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


}
