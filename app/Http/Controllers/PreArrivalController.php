<?php

namespace App\Http\Controllers;

use App\Models\PreArrival;
use App\Models\Visitor;
use App\Notifications\PreArrivalSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class PreArrivalController extends Controller
{
    public function index()
    {
        $preArrivals = PreArrival::with('visitor')
            ->latest()
            ->paginate(15);
        return view('dashboard.pre-arrival.index', compact('preArrivals'));
    }

    public function create()
    {
        return view('dashboard.pre-arrival.create');
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

        $preArrival = PreArrival::create([
            ...$validated,
            'token' => PreArrival::generateToken(),
        ]);

        return redirect()->route('dashboard.pre-arrival.index')
            ->with('success', __('Pre-Arrival created successfully'))
            ->with('token', $preArrival->token);
    }

    public function show($token)
    {
        $preArrival = PreArrival::where('token', $token)->firstOrFail();

        if ($preArrival->isUsed()) {
            return view('pre-arrival.used');
        }

        return view('pre-arrival.form', compact('preArrival'));
    }

    public function submit(Request $request, $token)
    {
        $preArrival = PreArrival::where('token', $token)->firstOrFail();

        if ($preArrival->isUsed()) {
            return redirect()->route('pre-arrival.show', $token)
                ->with('error', __('This link has already been used'));
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'nationality' => 'required|string|max:255',
            'passport_number' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'departure_date' => 'required|date|after:arrival_date',
        ]);

        DB::transaction(function () use ($preArrival, $validated) {
            $preArrival->update([
                ...$validated,
                'used_at' => now(),
            ]);

            $visitor = Visitor::create([
                ...$validated,
                'pre_arrival_id' => $preArrival->id,
                'status' => 'pending',
            ]);

            // Send notifications
            $admins = \App\Models\User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['super-admin', 'admin']);
            })->get();

            Notification::send($admins, new PreArrivalSubmitted($visitor));
        });

        return view('pre-arrival.success');
    }

    public function destroy(PreArrival $preArrival)
    {
        $preArrival->delete();
        return redirect()->route('dashboard.pre-arrival.index')
            ->with('success', __('Pre-Arrival deleted successfully'));
    }
}
