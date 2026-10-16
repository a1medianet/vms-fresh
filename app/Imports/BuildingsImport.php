<?php

namespace App\Imports;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BuildingsImport implements ToModel, WithHeadingRow, WithValidation
{
    private $buildings = [];
    private $floors = [];

    public function model(array $row)
    {
        $buildingName = $row['building'] ?? $row['building_name'] ?? '';
        $floorName = $row['floor'] ?? $row['floor_name'] ?? '';
        $floorNumber = $row['floor_number'] ?? $row['floor number'] ?? 1;
        $roomNumber = $row['room'] ?? $row['room_number'] ?? $row['room number'] ?? '';

        if (empty($buildingName) || empty($roomNumber)) {
            return null;
        }

        // Get or create building
        if (!isset($this->buildings[$buildingName])) {
            $building = Building::firstOrCreate(['name' => $buildingName]);
            $this->buildings[$buildingName] = $building;
        } else {
            $building = $this->buildings[$buildingName];
        }

        // Get or create floor
        $floorKey = $building->id . '_' . $floorName;
        if (!isset($this->floors[$floorKey])) {
            $floor = Floor::firstOrCreate([
                'building_id' => $building->id,
                'name' => $floorName ?: 'Floor ' . $floorNumber,
                'floor_number' => $floorNumber,
            ]);
            $this->floors[$floorKey] = $floor;
        } else {
            $floor = $this->floors[$floorKey];
        }

        // Create room
        return new Room([
            'floor_id' => $floor->id,
            'number' => $roomNumber,
            'type' => $row['type'] ?? $row['room_type'] ?? null,
            'capacity' => $row['capacity'] ?? 1,
            'description' => $row['description'] ?? null,
            'is_active' => true,
        ]);
    }

    public function rules(): array
    {
        return [
            'building' => 'required',
            'room' => 'required',
        ];
    }
}
