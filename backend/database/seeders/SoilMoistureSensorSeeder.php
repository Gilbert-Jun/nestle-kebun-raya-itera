<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SoilMoistureSensor;
use Carbon\Carbon;

class SoilMoistureSensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sensorNames = ['Sensor Kelembaban Tanah 1'];
        
        foreach ($sensorNames as $sensorName) {
            // Generate 24 hours of data (one reading per hour)
            for ($i = 23; $i >= 0; $i--) {
                $timestamp = Carbon::now()->subHours($i);
                
                // Generate realistic soil moisture values (0-100%)
                $baseValue = rand(30, 70); // Base moisture level
                $variation = rand(-10, 10); // Add some variation
                $value = max(0, min(100, $baseValue + $variation)); // Ensure value is between 0-100
                
                SoilMoistureSensor::create([
                    'name' => $sensorName,
                    'value' => $value,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ]);
            }
        }
    }
} 