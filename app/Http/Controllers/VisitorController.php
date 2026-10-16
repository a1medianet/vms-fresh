<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\PreArrival;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Visitor::with('preArrival', 'assignments.room');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('passport_number', 'like', "%{$search}%");
            });
        }

        $visitors = $query->latest()->paginate(15);
        return view('dashboard.visitors.index', compact('visitors'));
    }

    public function create()
    {
        return view('dashboard.visitors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'nationality' => 'required|string|max:255',
            'passport_number' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'departure_date' => 'required|date|after:arrival_date',
        ]);

        Visitor::create([
            ...$validated,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard.visitors.index')
            ->with('success', __('Visitor created successfully'));
    }

    public function show(Visitor $visitor)
    {
        $visitor->load('preArrival', 'assignments.room.floor.building');
        return view('dashboard.visitors.show', compact('visitor'));
    }

    public function update(Request $request, Visitor $visitor)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'nationality' => 'required|string|max:255',
            'passport_number' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'departure_date' => 'required|date|after:arrival_date',
            'status' => 'required|in:pending,checked-in,checked-out',
        ]);

        $visitor->update($validated);

        return redirect()->route('dashboard.visitors.show', $visitor)
            ->with('success', __('Visitor updated successfully'));
    }

    public function checkIn(Visitor $visitor)
    {
        $visitor->update(['status' => 'checked-in']);
        return redirect()->back()
            ->with('success', __('Visitor checked in successfully'));
    }

    public function checkOut(Visitor $visitor)
    {
        $visitor->update(['status' => 'checked-out']);

        // Check out all active assignments
        $visitor->assignments()
            ->whereNull('check_out_at')
            ->update(['check_out_at' => now()]);

        return redirect()->back()
            ->with('success', __('Visitor checked out successfully'));
    }

    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('dashboard.visitors.index')
            ->with('success', __('Visitor deleted successfully'));
    }
}
