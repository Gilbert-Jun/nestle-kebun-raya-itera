<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TurbiditySensor;
use Carbon\Carbon;

class TurbiditySensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sensorNames = ['Sensor Turbiditas 1'];
        
        foreach ($sensorNames as $sensorName) {
            // Generate 24 hours of data (one reading per hour)
            for ($i = 23; $i >= 0; $i--) {
                $timestamp = Carbon::now()->subHours($i);
                
                // Generate realistic turbidity values (0-4000 NTU)
                $baseValue = rand(10, 100); // Base turbidity level
                $variation = rand(-20, 20); // Add some variation
                $value = max(0, $baseValue + $variation); // Ensure value is not negative
                
                TurbiditySensor::create([
                    'name' => $sensorName,
                    'value' => $value,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ]);
            }
        }
    }
} 