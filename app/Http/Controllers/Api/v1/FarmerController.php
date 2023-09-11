<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\v1\FarmerUpdateRequest;
use App\Http\Resources\v1\FarmerResource;
use App\Http\Resources\v1\PublicFarmerTrace;
use App\Models\v1\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FarmerController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FarmerResource::collection(Farmer::all()->sortByDesc('created_at'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nid' => 'required|string|unique:farmers,nid',
            'phone' => 'required|unique:farmers'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $data = $request->all();
        $data['farmer_id'] = 'far-' . $this->generateUUID();
        $data['onboard_by'] = auth()->user()->df_id;
        $extension = $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/image/farmer', $data['farmer_id'] . '.' . $extension);
        $image_path = '/image/farmer/' . $data['farmer_id'] . '.' . $extension;
        $data['image'] =  $image_path;
        $farmer = Farmer::create($data);
        return new FarmerResource($farmer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Farmer $farmer)
    {
        return new FarmerResource($farmer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Farmer $farmer)
    {


        // $validated = $request->validated();
        $validated = $request->all();

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/image/farmer', $farmer->farmer_id . '.' . $extension);
            $image_path = '/image/farmer/' . $farmer->farmer_id . '.' . $extension;
            $validated['image'] =  $image_path;
        }
        $farmer->update($validated);
        return response()->json([
            'message' => 'Farmer updated successfully',
            'data' => new FarmerResource($farmer)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Farmer $farmer)
    {
        //
    }

    public function myFarmer()
    {
        $farmer = Farmer::where('onboard_by', auth()->user()->df_id)->get()->sortByDesc('created_at');
        return FarmerResource::collection($farmer);
    }
    public function unassignedFarmer()
    {
        $farmer = Farmer::where('onboard_by', auth()->user()->df_id)
            ->where('group_id', null)
            ->get()->sortByDesc('created_at');
        return FarmerResource::collection($farmer);
    }


    public function paginateFarmerWithSearch(Request $request)
    {
        $farmer = Farmer::query()

            ->when($request->search, function ($query) use ($request) {
                $query->WhereRaw("concat(first_name, ' ', last_name) like '%" . $request->search . "%' ")
                    ->orWhere('farmer_id', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('nid', 'LIKE', '%' . $request->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 150))
            ->appends(request()->query());
        return FarmerResource::collection($farmer);
    }


    public function PublicFarmerTrace(Farmer $farmer)
    {

        return new PublicFarmerTrace($farmer);
    }

    public function MepaginateFarmerWithSearch(Request $request)
    {


        $user = auth()->user();
        $search = $request->search;

        $farmers = Farmer::where('onboard_by', $user->df_id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereRaw("concat(first_name, ' ', last_name) like ?", ["%$search%"])
                        ->orWhere('farmer_id', 'LIKE', "%$search%")
                        ->orWhere('phone', 'LIKE', "%$search%")
                        ->orWhere('nid', 'LIKE', "%$search%");
                });
            })

            ->get()->sortByDesc('created_at');

        if ($farmers->isEmpty()) {
            return response()->json([
                'message' => 'No farmer found',
            ]);
        } else {
            return FarmerResource::collection($farmers);
        }
    }
}
