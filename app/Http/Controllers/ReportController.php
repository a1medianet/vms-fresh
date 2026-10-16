<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\PreArrival;
use App\Models\Assignment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('dashboard.reports.index');
    }

    public function daily(Request $request)
    {
        $date = $request->get('date', now()->toDateString());

        $stats = [
            'date' => $date,
            'visitors_count' => Visitor::whereDate('arrival_date', $date)->count(),
            'arrivals' => Visitor::whereDate('arrival_date', $date)->count(),
            'departures' => Visitor::whereDate('departure_date', $date)->count(),
            'checked_in' => Visitor::where('status', 'checked-in')
                ->whereDate('arrival_date', '<=', $date)
                ->whereDate('departure_date', '>=', $date)
                ->count(),
            'pre_arrivals_used' => PreArrival::whereDate('used_at', $date)->count(),
            'occupancy_rate' => $this->calculateOccupancyRate($date),
        ];

        $visitors = Visitor::whereDate('arrival_date', $date)
            ->orWhereDate('departure_date', $date)
            ->get();

        if ($request->has('export')) {
            return $this->exportDailyReport($stats, $visitors, $date, $request->get('format', 'pdf'));
        }

        return view('dashboard.reports.daily', compact('stats', 'visitors'));
    }

    public function weekly(Request $request)
    {
        $weekStart = $request->get('week_start', now()->startOfWeek()->toDateString());
        $weekEnd = now()->parse($weekStart)->endOfWeek()->toDateString();

        $stats = [
            'week_start' => $weekStart,
            'week_end' => $weekEnd,
            'visitors_count' => Visitor::whereBetween('arrival_date', [$weekStart, $weekEnd])->count(),
            'arrivals' => Visitor::whereBetween('arrival_date', [$weekStart, $weekEnd])->count(),
            'departures' => Visitor::whereBetween('departure_date', [$weekStart, $weekEnd])->count(),
            'pre_arrivals_used' => PreArrival::whereBetween('used_at', [$weekStart, $weekEnd])->count(),
            'average_occupancy' => $this->calculateAverageOccupancy($weekStart, $weekEnd),
        ];

        $visitors = Visitor::whereBetween('arrival_date', [$weekStart, $weekEnd])
            ->orWhereBetween('departure_date', [$weekStart, $weekEnd])
            ->get();

        if ($request->has('export')) {
            return $this->exportWeeklyReport($stats, $visitors, $weekStart, $weekEnd, $request->get('format', 'pdf'));
        }

        return view('dashboard.reports.weekly', compact('stats', 'visitors'));
    }

    public function monthly(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $stats = [
            'month' => $month,
            'year' => $year,
            'visitors_count' => Visitor::whereYear('arrival_date', $year)
                ->whereMonth('arrival_date', $month)
                ->count(),
            'arrivals' => Visitor::whereYear('arrival_date', $year)
                ->whereMonth('arrival_date', $month)
                ->count(),
            'departures' => Visitor::whereYear('departure_date', $year)
                ->whereMonth('departure_date', $month)
                ->count(),
            'pre_arrivals_used' => PreArrival::whereYear('used_at', $year)
                ->whereMonth('used_at', $month)
                ->count(),
            'average_occupancy' => $this->calculateAverageOccupancy(
                now()->year($year)->month($month)->startOfMonth()->toDateString(),
                now()->year($year)->month($month)->endOfMonth()->toDateString()
            ),
        ];

        $visitors = Visitor::whereYear('arrival_date', $year)
            ->whereMonth('arrival_date', $month)
            ->orWhere(function ($query) use ($year, $month) {
                $query->whereYear('departure_date', $year)
                      ->whereMonth('departure_date', $month);
            })
            ->get();

        if ($request->has('export')) {
            return $this->exportMonthlyReport($stats, $visitors, $month, $year, $request->get('format', 'pdf'));
        }

        return view('dashboard.reports.monthly', compact('stats', 'visitors'));
    }

    public function yearly(Request $request)
    {
        $year = $request->get('year', now()->year);

        $stats = [
            'year' => $year,
            'visitors_count' => Visitor::whereYear('arrival_date', $year)->count(),
            'arrivals' => Visitor::whereYear('arrival_date', $year)->count(),
            'departures' => Visitor::whereYear('departure_date', $year)->count(),
            'pre_arrivals_used' => PreArrival::whereYear('used_at', $year)->count(),
            'average_occupancy' => $this->calculateAverageOccupancy(
                now()->year($year)->startOfYear()->toDateString(),
                now()->year($year)->endOfYear()->toDateString()
            ),
        ];

        $visitors = Visitor::whereYear('arrival_date', $year)
            ->orWhereYear('departure_date', $year)
            ->get();

        if ($request->has('export')) {
            return $this->exportYearlyReport($stats, $visitors, $year, $request->get('format', 'pdf'));
        }

        return view('dashboard.reports.yearly', compact('stats', 'visitors'));
    }

    private function calculateOccupancyRate($date)
    {
        $totalRooms = Room::where('is_active', true)->count();
        if ($totalRooms === 0) return 0;

        $occupiedRooms = Assignment::whereDate('check_in_at', '<=', $date)
            ->where(function ($query) use ($date) {
                $query->whereNull('check_out_at')
                      ->orWhereDate('check_out_at', '>', $date);
            })
            ->distinct('room_id')
            ->count('room_id');

        return round(($occupiedRooms / $totalRooms) * 100, 2);
    }

    private function calculateAverageOccupancy($startDate, $endDate)
    {
        $totalRooms = Room::where('is_active', true)->count();
        if ($totalRooms === 0) return 0;

        $days = now()->parse($startDate)->diffInDays(now()->parse($endDate)) + 1;
        $totalOccupiedDays = 0;

        for ($date = $startDate; $date <= $endDate; $date = now()->parse($date)->addDay()->toDateString()) {
            $occupied = Assignment::whereDate('check_in_at', '<=', $date)
                ->where(function ($query) use ($date) {
                    $query->whereNull('check_out_at')
                          ->orWhereDate('check_out_at', '>', $date);
                })
                ->distinct('room_id')
                ->count('room_id');
            $totalOccupiedDays += $occupied;
        }

        return round(($totalOccupiedDays / ($totalRooms * $days)) * 100, 2);
    }

    private function exportDailyReport($stats, $visitors, $date, $format)
    {
        if ($format === 'excel') {
            // Excel export will be handled by ImportExportController
            return redirect()->route('dashboard.import-export.export', [
                'type' => 'daily_report',
                'date' => $date,
            ]);
        }

        $pdf = Pdf::loadView('dashboard.reports.pdf.daily', compact('stats', 'visitors', 'date'));
        return $pdf->download("daily-report-{$date}.pdf");
    }

    private function exportWeeklyReport($stats, $visitors, $weekStart, $weekEnd, $format)
    {
        if ($format === 'excel') {
            return redirect()->route('dashboard.import-export.export', [
                'type' => 'weekly_report',
                'week_start' => $weekStart,
            ]);
        }

        $pdf = Pdf::loadView('dashboard.reports.pdf.weekly', compact('stats', 'visitors', 'weekStart', 'weekEnd'));
        return $pdf->download("weekly-report-{$weekStart}.pdf");
    }

    private function exportMonthlyReport($stats, $visitors, $month, $year, $format)
    {
        if ($format === 'excel') {
            return redirect()->route('dashboard.import-export.export', [
                'type' => 'monthly_report',
                'month' => $month,
                'year' => $year,
            ]);
        }

        $pdf = Pdf::loadView('dashboard.reports.pdf.monthly', compact('stats', 'visitors', 'month', 'year'));
        return $pdf->download("monthly-report-{$year}-{$month}.pdf");
    }

    private function exportYearlyReport($stats, $visitors, $year, $format)
    {
        if ($format === 'excel') {
            return redirect()->route('dashboard.import-export.export', [
                'type' => 'yearly_report',
                'year' => $year,
            ]);
        }

        $pdf = Pdf::loadView('dashboard.reports.pdf.yearly', compact('stats', 'visitors', 'year'));
        return $pdf->download("yearly-report-{$year}.pdf");
    }
}
