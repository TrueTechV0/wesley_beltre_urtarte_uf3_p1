<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actor;
use Illuminate\Support\Facades\DB;
class ActorController extends Controller
{

    public static function readActors(){
        $actors=Actor::select('name', 'surname', 'birthdate', 'country', 'img_url')->get();
        $actorsArray = json_decode(json_encode($actors),true);
        return $actorsArray;
    }

    public function listActors()
    {
        // Retrieve actor data from the database
        $actors = ActorController::readActors();
        // Pass $actors to the view
          return view('actors.list', ["actors" => $actors]);
    }

    public function listActorsByDecade()
    {

        $selectedDecade = $_GET['decade'];

        $startyear = $selectedDecade;
        $endyear = $startyear + 10;

        $actorsList = ActorController::readActors();

        $actors = array();

        foreach ($actorsList as $actor) {
            $añoNacimiento = $actor['birthdate'];
            if ($añoNacimiento >= $startyear && $añoNacimiento <= $endyear) {
                $actors[] = $actor;
            }
        }
        $endyear = $startyear + 9;
        $title = "Listado de Actores por Década ($startyear - $endyear)";
        return view('actors.list', ['actors' => $actors, 'title' => $title]);
    }
    public function countActors()
    {
        // Obtener el conteo de actores utilizando el Query Builder
        $actors = ActorController::readActors();
        $count = count($actors); 

        // Pasar el conteo a la vista count.blade.php
        return view('actors.count', ["count" => $count]);
        
    }

public function deleteActors($id){
    $actorToDelete = Actor::find($id);
    if($actorToDelete){
        $actorToDelete->delete(); 
        return response()->json(['action' => $actorToDelete, 'status' => 'True']);
    }else{
        return response()->json(['action' => $actorToDelete, 'status' => 'False']);
    }
}

}