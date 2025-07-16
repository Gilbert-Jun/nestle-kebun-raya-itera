<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LightSensor;
use Carbon\Carbon;

class LightSensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sensorNames = ['Sensor Cahaya 1'];
        
        foreach ($sensorNames as $sensorName) {
            // Generate 24 hours of data (one reading per hour)
            for ($i = 23; $i >= 0; $i--) {
                $timestamp = Carbon::now()->subHours($i);
                $hour = $timestamp->hour;
                
                // Generate realistic light intensity values based on time of day
                if ($hour >= 6 && $hour <= 18) {
                    // Daytime: higher light intensity
                    $baseValue = rand(500, 1000); // 500-1000 lux during day
                } else {
                    // Nighttime: very low light intensity
                    $baseValue = rand(0, 50); // 0-50 lux at night
                }
                
                $variation = rand(-50, 50); // Add some variation
                $value = max(0, $baseValue + $variation); // Ensure value is not negative
                
                LightSensor::create([
                    'name' => $sensorName,
                    'value' => $value,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ]);
            }
        }
    }
} 