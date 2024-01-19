<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{

    public static function readFilms(): array {
        $filmsJson = Storage::get('public/films.json');
        $films = json_decode($filmsJson, true);

        // Check if decoding was successful
        if (json_last_error() != JSON_ERROR_NONE) {
            // Handle decoding error here if necessary
            throw new \RuntimeException('Error decoding JSON file');
        }

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

    public function createFilm() {
        
        $filmExists = FilmController::isFilm($_POST["name"]);
        if ($filmExists){
            return view('welcome', ["Error" => "Sorry, but this film already exists 😥😥"]);
        } else {
            $films = FilmController::readFilms();
            $newFilm = [
                "name" => $_POST["name"], 
                "country" => $_POST["country"], 
                "duration" => $_POST["duration"], 
                "year" => $_POST["year"], 
                "genre" => $_POST["genre"], 
                "img_url" => $_POST["url"]
            ];
            $films[] = $newFilm; 
            $jsonFilm = json_encode($films, JSON_PRETTY_PRINT);
            Storage::put('public/films.json', $jsonFilm);
            $pageTitle = "List of Movies";
            return view('films.list', ["films" => $films, "title" => $pageTitle]);

        }
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
