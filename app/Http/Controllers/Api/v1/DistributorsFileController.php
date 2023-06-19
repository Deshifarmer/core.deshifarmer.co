<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Distributors_file;
use Faker\Provider\Base;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DistributorsFileController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'df_id' => 'required|string',
            'signature' =>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bio_data'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'trade_license'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'agri_license'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'vat_certificate'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bank_solvency'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nid_font'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nid_back'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'character_certificate'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tax_report'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'owner_prove'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        if(Distributors_file::where('df_id',$request->df_id)->exists()){
            return Response()->json([
                'message' => 'Distributors File Already Exists',
                'status' => 'error',
            ], 400);
        }

        $data = $request->all();

        for($i=0;$i<count($request->file());$i++){
            $name = array_keys($request->file())[$i];
            $file = $request->file()[$name];
            $fileName =$name.'.'.$file->getClientOriginalExtension();
            $file->move(public_path('storage/files/'.$request->df_id), $fileName);
            $data[$name] = '/files/'. $request->df_id . '/' .$fileName;
        }

        $distributors_file = Distributors_file::create($data);

        return Response()->json([
            'message' => 'Distributors File Created Successfully',
            'status' => 'success',
        ], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(Distributors_file $distributors_file)
    {
        return $distributors_file;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Distributors_file $distributors_file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributors_file $distributors_file)
    {
        //
    }
}
