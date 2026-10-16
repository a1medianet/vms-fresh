<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        $building = Building::create([
            'name' => 'Main Building',
            'address' => '123 Main Street',
            'description' => 'Main accommodation building',
        ]);

        // Create 3 floors
        for ($i = 1; $i <= 3; $i++) {
            $floor = Floor::create([
                'building_id' => $building->id,
                'name' => "Floor {$i}",
                'floor_number' => $i,
            ]);

            // Create 10 rooms per floor
            for ($j = 1; $j <= 10; $j++) {
                Room::create([
                    'floor_id' => $floor->id,
                    'number' => "{$i}0{$j}",
                    'type' => $j <= 5 ? 'Single' : 'Double',
                    'capacity' => $j <= 5 ? 1 : 2,
                    'description' => "Room {$i}0{$j}",
                    'is_active' => true,
                ]);
            }
        }
    }
}
