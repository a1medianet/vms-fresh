<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\PreArrival;
use App\Models\Building;
use App\Models\Room;
use App\Imports\VisitorsImport;
use App\Imports\BuildingsImport;
use App\Exports\VisitorsExport;
use App\Exports\PreArrivalsExport;
use App\Exports\ReportsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    public function index()
    {
        return view('dashboard.import-export.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'type' => 'required|in:visitors,buildings',
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            if ($request->type === 'visitors') {
                Excel::import(new VisitorsImport, $request->file('file'));
                $message = __('Visitors imported successfully');
            } else {
                Excel::import(new BuildingsImport, $request->file('file'));
                $message = __('Buildings imported successfully');
            }

            return redirect()->route('dashboard.import-export.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('dashboard.import-export.index')
                ->with('error', __('Import failed: :message', ['message' => $e->getMessage()]));
        }
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'visitors');

        switch ($type) {
            case 'visitors':
                return Excel::download(new VisitorsExport, 'visitors-' . now()->format('Y-m-d') . '.xlsx');

            case 'pre-arrivals':
                return Excel::download(new PreArrivalsExport, 'pre-arrivals-' . now()->format('Y-m-d') . '.xlsx');

            case 'daily_report':
                $date = $request->get('date', now()->toDateString());
                $visitors = Visitor::whereDate('arrival_date', $date)
                    ->orWhereDate('departure_date', $date)
                    ->get();
                return Excel::download(new ReportsExport($visitors, 'daily', $date), "daily-report-{$date}.xlsx");

            case 'weekly_report':
                $weekStart = $request->get('week_start', now()->startOfWeek()->toDateString());
                $weekEnd = now()->parse($weekStart)->endOfWeek()->toDateString();
                $visitors = Visitor::whereBetween('arrival_date', [$weekStart, $weekEnd])
                    ->orWhereBetween('departure_date', [$weekStart, $weekEnd])
                    ->get();
                return Excel::download(new ReportsExport($visitors, 'weekly', $weekStart, $weekEnd), "weekly-report-{$weekStart}.xlsx");

            case 'monthly_report':
                $month = $request->get('month', now()->month);
                $year = $request->get('year', now()->year);
                $visitors = Visitor::whereYear('arrival_date', $year)
                    ->whereMonth('arrival_date', $month)
                    ->orWhere(function ($query) use ($year, $month) {
                        $query->whereYear('departure_date', $year)
                              ->whereMonth('departure_date', $month);
                    })
                    ->get();
                return Excel::download(new ReportsExport($visitors, 'monthly', $month, $year), "monthly-report-{$year}-{$month}.xlsx");

            case 'yearly_report':
                $year = $request->get('year', now()->year);
                $visitors = Visitor::whereYear('arrival_date', $year)
                    ->orWhereYear('departure_date', $year)
                    ->get();
                return Excel::download(new ReportsExport($visitors, 'yearly', $year), "yearly-report-{$year}.xlsx");

            default:
                return redirect()->back()->with('error', __('Invalid export type'));
        }
    }
}
