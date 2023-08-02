<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\v1\Channel;
use App\Models\v1\Employee;
use App\Models\v1\Farmer;
use App\Models\v1\FarmerGroup;
use App\Models\v1\Product;
use App\Models\v1\Upazila;
use Illuminate\Http\Request;
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

    public function upazila_wise_farmer()
    {
        $collection = collect([]);
        $upazilas = Farmer::selectRaw('COUNT(*) as total, upazila')
            ->groupBy('upazila')
            ->get()
            ->pluck('total', 'upazila')
            ->toArray();

        foreach ($upazilas as $key => $value) {
            $uName = Upazila::where('id', $key)->get();

            $collection->push([
                'upazila' => $uName->implode('name', ' ') . ' ' . $uName->implode('bn_name', ' '),
                'total' => $value,
            ]);
        }

        return $collection;
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


    // all Co Dashboard info
    // all Distributor Dashboard info
    // all Me Dashboard info

}
