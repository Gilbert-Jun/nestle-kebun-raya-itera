<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $faker = Faker::create();
        // $password = Hash::make('password');

        // for ($i = 0; $i < 10; $i++) {
        //     User::factory()->create([
        //         'name' => $faker->name,
        //         'email' => $faker->unique()->safeEmail,
        //         'password' => $password,
        //     ]);
        // }
        
        // User::factory()->create([
            //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed sensor data
        $this->call([
            TemperatureSensorSeeder::class,
            SoilMoistureSensorSeeder::class,
            LightSensorSeeder::class,
            TurbiditySensorSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
