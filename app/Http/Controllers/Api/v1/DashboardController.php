<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\v1\Channel;
use App\Models\v1\Farmer;
use Illuminate\Http\Request;

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
    // all Co Dashboard info
    // all Distributor Dashboard info
    // all Me Dashboard info

}
