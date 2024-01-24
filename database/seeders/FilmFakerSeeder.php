<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FilmFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Insert 10 films using Faker
        for ($i = 0; $i < 10; $i++) {
            DB::table('films')->insert([
                'name' => $faker->name,
                'year' => $faker->year,
                'genre' => $faker->randomElement(["Accion","Drama","Comedia"]),
                'country' => $faker->country,
                'duration' => $faker->randomFloat(2, 60, 180),
                'img_url' => $faker->imageUrl(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
?>