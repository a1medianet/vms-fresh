<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Assignment;
use App\Models\Visitor;
use Illuminate\Http\Request;

class HousingController extends Controller
{
    // Buildings
    public function buildings()
    {
        $buildings = Building::with('floors.rooms')->paginate(15);
        return view('dashboard.housing.buildings', compact('buildings'));
    }

    public function storeBuilding(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Building::create($validated);
        return redirect()->route('dashboard.housing.buildings')
            ->with('success', __('Building created successfully'));
    }

    public function updateBuilding(Request $request, Building $building)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $building->update($validated);
        return redirect()->route('dashboard.housing.buildings')
            ->with('success', __('Building updated successfully'));
    }

    public function destroyBuilding(Building $building)
    {
        $building->delete();
        return redirect()->route('dashboard.housing.buildings')
            ->with('success', __('Building deleted successfully'));
    }

    // Floors
    public function storeFloor(Request $request)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name' => 'required|string|max:255',
            'floor_number' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        Floor::create($validated);
        return redirect()->back()
            ->with('success', __('Floor created successfully'));
    }

    public function updateFloor(Request $request, Floor $floor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'floor_number' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $floor->update($validated);
        return redirect()->back()
            ->with('success', __('Floor updated successfully'));
    }

    public function destroyFloor(Floor $floor)
    {
        $floor->delete();
        return redirect()->back()
            ->with('success', __('Floor deleted successfully'));
    }

    // Rooms
    public function rooms()
    {
        $rooms = Room::with('floor.building', 'currentAssignments.visitor')
            ->paginate(15);
        return view('dashboard.housing.rooms', compact('rooms'));
    }

    public function storeRoom(Request $request)
    {
        $validated = $request->validate([
            'floor_id' => 'required|exists:floors,id',
            'number' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Room::create($validated);
        return redirect()->route('dashboard.housing.rooms')
            ->with('success', __('Room created successfully'));
    }

    public function updateRoom(Request $request, Room $room)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $room->update($validated);
        return redirect()->route('dashboard.housing.rooms')
            ->with('success', __('Room updated successfully'));
    }

    public function destroyRoom(Room $room)
    {
        $room->delete();
        return redirect()->route('dashboard.housing.rooms')
            ->with('success', __('Room deleted successfully'));
    }

    // Assignments
    public function assignments()
    {
        $assignments = Assignment::with('visitor', 'room.floor.building')
            ->latest()
            ->paginate(15);
        return view('dashboard.housing.assignments', compact('assignments'));
    }

    public function createAssignment()
    {
        $visitors = Visitor::where('status', 'pending')
            ->orWhere('status', 'checked-in')
            ->get();
        $rooms = Room::where('is_active', true)->with('floor.building')->get();
        return view('dashboard.housing.create-assignment', compact('visitors', 'rooms'));
    }

    public function storeAssignment(Request $request)
    {
        $validated = $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        if ($room->isOccupied()) {
            return redirect()->back()
                ->with('error', __('Room is already at full capacity'));
        }

        $assignment = Assignment::create([
            ...$validated,
            'check_in_at' => $validated['check_in_at'] ?? now(),
        ]);

        $visitor = $assignment->visitor;
        if ($visitor->status === 'pending') {
            $visitor->update(['status' => 'checked-in']);
        }

        return redirect()->route('dashboard.housing.assignments')
            ->with('success', __('Assignment created successfully'));
    }

    public function checkOutAssignment(Assignment $assignment)
    {
        $assignment->update(['check_out_at' => now()]);
        return redirect()->back()
            ->with('success', __('Assignment checked out successfully'));
    }
}
