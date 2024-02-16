<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public static function readFilms(): array {
        $films_json = Storage::get('public/films.json');
        $films_bbdd = DB::table("films")->select('name', 'year', 'genre', 'country', 'duration', 'img_url')->get();
        $actorsArray = json_decode(json_encode($films_bbdd), true);
        $films = array_merge(json_decode($films_json, true), $actorsArray);
        return $films;
    }

    public function listOldFilms($selectedYear = null)
    {        
        $oldFilms = [];
        if (is_null($selectedYear))
            $selectedYear = 2000;

        $pageTitle =  "List of Old Movies (Before $selectedYear)";    
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] < $selectedYear)
                $oldFilms[] = $film;
        }
        return view('films.list', ["films" => $oldFilms, "title" => $pageTitle]);
    }


    public function listNewFilms($selectedYear = null)
    {
        $newFilms = [];
        if (is_null($selectedYear))
            $selectedYear = 2000;

        $pageTitle = "List of New Movies (After $selectedYear)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] >= $selectedYear)
                $newFilms[] = $film;
        }
        return view('films.list', ["films" => $newFilms, "title" => $pageTitle]);
    }

    public function listFilms($selectedYear = null, $selectedGenre = null)
    {
        $filteredFilms = [];

        $pageTitle =  "List of all movies";
        $films = FilmController::readFilms();

    
        if (is_null($selectedYear) && is_null($selectedGenre))
            return view('films.list', ["films" => $films, "title" => $pageTitle]);

    
        foreach ($films as $film) {
            if ((!is_null($selectedYear) && is_null($selectedGenre)) && $film['year'] == $selectedYear){
                $pageTitle = "List of all movies filtered by year";
                $filteredFilms[] = $film;
            } else if((is_null($selectedYear) && !is_null($selectedGenre)) && strtolower($film['genre']) == strtolower($selectedGenre)){
                $pageTitle =    "List of all movies filtered by category";
                $filteredFilms[] = $film;
            } else if(!is_null($selectedYear) && !is_null($selectedGenre) && strtolower($film['genre']) == strtolower($selectedGenre) && $film['year'] == $selectedYear){
                $pageTitle = "List of all movies filtered by category and year";
                $filteredFilms[] = $film;
            }
        }
        return view("films.list", ["films" => $filteredFilms, "title" => $pageTitle]);
    }
    
    public function listByYear($selectedYear)
    {
        $filteredFilms = [];
          
        $pageTitle = "List of all movies by year" ;
        $films = FilmController::readFilms();
        
        if (is_null($selectedYear))
            return view('films.list', ["films" => $films, "title" => $pageTitle]);
        
        foreach ($films as $film) {
            if (!is_null($selectedYear) && $film['year'] == $selectedYear) {
                $pageTitle = "List of all movies filtered by year";
                $filteredFilms[] = $film;
            }
        }
        
        return view("films.list", ["films" => $filteredFilms, "title" => $pageTitle]);
    }

    public function listByGenre($selectedGenre = null)
    {
        $filteredFilms = [];
 
        $pageTitle = "List of all movies filtered by genre";
        $films = FilmController::readFilms();
 
        if (is_null($selectedGenre))
            return view('films.list', ["films" => $films, "title" => $pageTitle]);
 
    
        foreach ($films as $film) {
            if ((!is_null($selectedGenre)) && strtolower($film['genre']) == strtolower($selectedGenre)) {
                $pageTitle = "List of all movies filtered by category";
                $filteredFilms[] = $film;
            }
        }
        return view("films.list", ["films" => $filteredFilms, "title" => $pageTitle]);
    }

    public function sortByYear() {
        $pageTitle = "Movies Sorted by Year";
   
        $films = FilmController::readFilms();
 
        usort($films, function ($a, $b) {
            return $b['year'] - $a['year'];
        });
   
        return view('films.list', ["films" => $films, "title" => $pageTitle]);
    }

    public function countFilms() {
     
        $pageTitle = "Number of movies";
        $films = FilmController::readFilms();
        
        $filmsCount = count($films);
       
        return view('films.count', ["films" => $filmsCount, "title" => $pageTitle]);
    }

    public function createFilm(Request $request)
    {
        $title = "Listado de películas";
        $filmName = $request->input('name');

        // Verificar si la película ya existe en la base de datos
        $filmExistInDB = DB::table('films')->where('name', $filmName)->exists();

        // Verificar si la película ya existe en el archivo JSON
        $films = $this->getFilmsFromJson();
        $filmExistInJSON = collect($films)->contains('name', $filmName);

        if ($filmExistInDB || $filmExistInJSON) {
            return view('welcome', ["Error" => "Lo siento, pero esta película ya existe"]);
        } else {
            $newFilm = [
                'name' => $filmName,
                'year' => $request->input('year'),
                'genre' => $request->input('genre'),
                'country' => $request->input('country'),
                'duration' => $request->input('duration'),
                'img_url' => $request->input('url'), // renaming 'url_image' to 'img_url'
            ];

            // Insertar en la base de datos SQL
            DB::table('films')->insert($newFilm);

            // Agregar el nuevo film al arreglo y escribirlo al archivo JSON
            $films[] = $newFilm;
            $this->saveFilmsToJson($films);

            // Obtener las películas actualizadas y mostrar la lista
            $films = $this->getFilmsFromJson(); // O cualquier método correspondiente para obtener datos de SQL
            return view('films.list', ["films" => $films, "title" => $title]);
        }
    }

    public function getFilmsFromJson() {
        $films_json = Storage::get('public/films.json');
        return json_decode($films_json, true);
    }

    public function saveFilmsToJson($films) {
        $jsonFilms = json_encode($films, JSON_PRETTY_PRINT);
        Storage::put('public/films.json', $jsonFilms);
    }

    public function isFilm($filmName = null): bool {
        $films = FilmController::readFilms();
        $filmExists = false;
        foreach ($films as $film) {


            if($film["name"]==$filmName){
                $filmExists = true;
            }  
        }
        return $filmExists;
    }

}
