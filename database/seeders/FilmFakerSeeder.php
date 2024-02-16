<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class FilmFakerSeeder extends Seeder
{
    public function run()
    {
        $faker = faker::create();
       
        foreach(range(1,10)as  $index){
            DB::table('films')->insert([
                'name' => $faker->name,
                'year' => $faker->year,
                'genre' => $faker->randomElement(["Action", "Drama", "Adventure", "Sport"]),
                'country' => $faker->country,
                'duration' => $faker->numberBetween(60, 240),
                'img_url' => $faker->imageUrl(),
                "created_at" => now()->setTimezone("Europe/Madrid"),

            ]);
        }
    }
}