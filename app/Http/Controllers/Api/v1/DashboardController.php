<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\v1\Channel;
use App\Models\v1\District;
use App\Models\v1\Division;
use App\Models\v1\Employee;
use App\Models\v1\Farmer;
use App\Models\v1\FarmerGroup;
use App\Models\v1\Product;
use App\Models\v1\Upazila;
use Illuminate\Http\Request;
use InvalidArgumentException;
use PhpParser\Node\Name\FullyQualified;

class DashboardController extends Controller
{
    // all Hq Dashboard info

    public function all_member()
    {
        $counts = User::selectRaw('COUNT(*) as total, role')
            ->where('role', '<>', 0)
            ->orWhereNull('role')
            ->groupBy('role')
            ->get()
            ->pluck('total', 'role')
            ->toArray();

        return response()->json([
            'total_member' => array_sum($counts) + Farmer::count(),
            'total_co' => $counts[1] ?? 0,
            'total_cp' => $counts[2] ?? 0,
            'total_me' => $counts[3] ?? 0,
            'total_te' => $counts[4] ?? 0,
            'total_farmer' => Farmer::count(),
            'total_channel' => Channel::count(),
        ]);
    }

    public function company_wise_product()
    {
        $collection = collect([]);
        $companies = User::where('role', 1)->get();
        $TActive = 0;
        $TInactive = 0;

        $companies->map(function ($company) use ($collection) {
            $companyName = $company->full_name;
            $active = Product::where('company_id', $company->df_id)->where('status', 'active')->count();
            $inactive = Product::where('company_id', $company->df_id)->where('status', 'inactive')->count();
            $collection->push([
                'company_name' => $companyName,
                'active' => $active,
                'inactive' => $inactive,
            ]);
        });
        return $collection;
    }

    //total farmer_group with member count

    public function total_group()
    {
        $collection = collect([]);
        $groups = FarmerGroup::all();

        $groups->map(function ($group) use ($collection) {

            $groupName = $group->farmer_group_name;
            $memberCount = Farmer::where('group_id', $group->farmer_group_id)->count();
            $collection->push([
                'group_name' => $groupName,
                'farmer_count' => $memberCount,
            ]);
        });

        return  $collection;
    }




    public function farmer_added(Request $request)
    {
        $collection = collect([]);
        $query = Farmer::selectRaw('COUNT(*) as total, onboard_by')
            ->groupBy('onboard_by');

        if ($request->has('date')) {
            $date = $request->input('date');
            $query->whereDate('created_at', $date);
        } elseif ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $farmers = $query->get()->pluck('total', 'onboard_by')->toArray();

        foreach ($farmers as $key => $value) {
            $uName = Employee::where('df_id', $key)->get();

            $collection->push([
                'me_name' => $uName->implode('first_name', ' ') . ' ' . $uName->implode('last_name', ' '),
                'me_id' => $uName->implode('df_id', ' '), //me_id
                'me_phone' => $uName->implode('phone', ' '),
                'me_image' => $uName->implode('photo', ' '),
                'total' => $value,
            ]);
        }

        return $collection;
    }
    public function location_wise_farmer(Request $request)
    {
        $groupBy = $request->input('location');
        $collection = collect([]);
        $query = Farmer::selectRaw('COUNT(*) as total, ' . $groupBy)
            ->groupBy($groupBy);
        if ($request->has('date')) {
            $date = $request->input('date');
            $query->whereDate('created_at', $date);
        } elseif ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        $results =  $query->pluck('total', $groupBy)->toArray();
        foreach ($results as $key => $value) {
            //add union name
            $model = $groupBy == 'district' ? District::class : ($groupBy == 'division' ? Division::class : Upazila::class);

            $uName = $model::where('id', $key)->get();

            $collection->push([
                $groupBy . "_name" => $uName->implode('name', ' '),
                $groupBy . "_bn_name" => $uName->implode('bn_name', ' '),
                'total' => $value,
            ]);
        }
        return $collection;
    }

    public function distributor_wise_farmer()
    {
        $collection = collect([]);
        $distributors = Employee::where('type', 2)->get();

        $distributors->map(function ($distributor) use ($collection) {
            $cpName = $distributor->full_name;
            $cpId = $distributor->df_id;
            $cpPhone = $distributor->phone;
            $cpImage = $distributor->photo;
            $mes = Employee::where('type', 3)->where('under', $distributor->df_id)->get()->map(function ($me) {
                return Farmer::where('onboard_by', $me->df_id)->count();
            })->sum();

            $collection->push([
                'cp_name' => $cpName,
                'cp_id' => $cpId,
                'cp_phone' => $cpPhone,
                'cp_image' => $cpImage,
                'total' => $mes,
            ]);
        });
        return $collection;
    }


    public function test(Request $request)
    {


        $collection = collect([]);

        $distributors = Employee::where('type', 2)->get();

        $distributors->map(function ($distributor) use ($collection) {
            $meCollection = collect([]);
            $cpName = $distributor->full_name;
            $cpId = $distributor->df_id;
            $cpPhone = $distributor->phone;
            $cpImage = $distributor->photo;

            $mes = Employee::where('type', 3)->where('under', $distributor->df_id)->get()->map(function ($me) use ($meCollection) {
                $meName = $me->full_name;
                $meId = $me->df_id;
                $mePhone = $me->phone;
                $meImage = $me->photo;
                $sum = 0;

                $farmerCount = Farmer::where('onboard_by', $me->df_id)
                    ->count();
                $sum += $farmerCount;
                $meCollection->push([
                    'me_name' => $meName,
                    'me_id' => $meId,
                    'me_phone' => $mePhone,
                    'me_image' => $meImage,
                    'me_total_farmer' => $farmerCount,
                ]);
                return $sum;
            });

            $collection->push([
                'cp_name' => $cpName,
                'cp_id' => $cpId,
                'cp_phone' => $cpPhone,
                'cp_image' => $cpImage,
                'cp_total_farmer' => $mes->sum(),
                'me_list' => $meCollection,

            ]);
        });
        return $collection;
    }



    // all Co Dashboard info
    // all Distributor Dashboard info
    // all Me Dashboard info

}
