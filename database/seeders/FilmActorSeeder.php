<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmActorSeeder extends Seeder
{
  
    public function run()
    {
        // Get all film and actor IDs
        $filmIds = DB::table('films')->pluck('id')->toArray();
        $actorIds = DB::table('actors')->pluck('id')->toArray();

        // Insert random relationships between films and actors
        foreach ($filmIds as $filmId) {
            $numberOfActors = rand(1, 3);
            $selectedActorIds = array_rand($actorIds, $numberOfActors);

            foreach ((array)$selectedActorIds as $selectedActorId) {
                DB::table('films_actors')->insert([
                    'film_id' => $filmId,
                    'actor_id' => $actorIds[$selectedActorId],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
