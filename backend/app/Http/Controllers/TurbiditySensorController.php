<?php

namespace App\Http\Controllers;

use App\Models\TurbiditySensor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TurbiditySensorController extends Controller
{
    /**
     * Get all turbidity sensors data for dashboard
     */
    public function index(): JsonResponse
    {
        try {
            // Get all unique sensor names
            $sensorNames = TurbiditySensor::getSensorNames();
            
            $sensorsData = [];
            
            foreach ($sensorNames as $sensorName) {
                // Get latest reading for each sensor
                $latestReading = TurbiditySensor::getLatestReading($sensorName);
                
                // Get readings for the last 12 hours for chart
                $readings = TurbiditySensor::getReadingsForSensor($sensorName, 12);
                
                $sensorsData[] = [
                    'name' => $sensorName,
                    'latest_value' => $latestReading ? (float) $latestReading->value : null,
                    'latest_timestamp' => $latestReading ? $latestReading->created_at : null,
                    'chart_data' => $readings->map(function ($reading) {
                        return [
                            'x' => $reading->created_at->format('Y-m-d H:i:s'),
                            'y' => (float) $reading->value
                        ];
                    })
                ];
            }
            
            return response()->json([
                'success' => true,
                'data' => $sensorsData
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch turbidity sensor data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data for a specific sensor
     */
    public function show(string $sensorName): JsonResponse
    {
        try {
            $readings = TurbiditySensor::getReadingsForSensor($sensorName, 12);
            
            $chartData = $readings->map(function ($reading) {
                return [
                    'x' => $reading->created_at->format('Y-m-d H:i:s'),
                    'y' => (float) $reading->value
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'sensor_name' => $sensorName,
                    'readings' => $chartData
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch sensor data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new turbidity reading
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'value' => 'required|numeric|min:0'
            ]);
            
            $sensor = TurbiditySensor::create([
                'name' => $request->name,
                'value' => $request->value
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Turbidity reading stored successfully',
                'data' => $sensor
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store turbidity reading',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get sensor names for dropdown/selection
     */
    public function getSensorNames(): JsonResponse
    {
        try {
            $sensorNames = TurbiditySensor::getSensorNames();
            
            return response()->json([
                'success' => true,
                'data' => $sensorNames
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch sensor names',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 