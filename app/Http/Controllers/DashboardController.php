<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\PreArrival;
use App\Models\Assignment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_visitors' => Visitor::count(),
            'pending_visitors' => Visitor::where('status', 'pending')->count(),
            'checked_in' => Visitor::where('status', 'checked-in')->count(),
            'checked_out' => Visitor::where('status', 'checked-out')->count(),
            'active_pre_arrivals' => PreArrival::whereNull('used_at')->count(),
            'total_rooms' => Room::where('is_active', true)->count(),
            'occupied_rooms' => Room::where('is_active', true)
                ->whereHas('currentAssignments')
                ->count(),
            'available_rooms' => Room::where('is_active', true)
                ->whereDoesntHave('currentAssignments')
                ->count(),
        ];

        $recentVisitors = Visitor::with('preArrival')
            ->latest()
            ->limit(10)
            ->get();

        $recentPreArrivals = PreArrival::whereNull('used_at')
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.index', compact('stats', 'recentVisitors', 'recentPreArrivals'));
    }
}
