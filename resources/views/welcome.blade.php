<!DOCTYPE html>
<html lang="es">

@extends('layouts.master')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Películas</title>

    <!-- Add Bootstrap 5 CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #495057;
        }

        h1 {
            color: #343a40;
        }

        .movie-links {
            list-style: none;
            padding: 0;
        }

        .movie-links li {
            margin-bottom: 10px;
        }

        .form-container {
            max-width: 500px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .label-bold {
            font-weight: bold;
        }

        .btn-primary-custom {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary-custom:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .alert-danger-custom {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
        }
    </style>
</head>

<body class="container">
    @section('content')
    <h1 class="mt-4 text-center">Listado de Películas</h1>
    <ul class="movie-links text-center">
    <li><a href="/filmout/oldFilms">Old Movies</a></li>
    <li><a href="/filmout/newFilms">New Movies</a></li>
    <li><a href="/filmout/films">All Movies</a></li>
    <li><a href="/filmout/sortFilms">Movies Sorted by Year</a></li>

    <li><a href="/actorout/actors">List Actors</a></li>
   
    <div>
            <form action="{{ route('listActorsByDecade') }}" method="get">
                <label for="decade">List By Decade:</label>
                <select name="decade" id="decade">
                    <option value="1970">1970s</option>
                    <option value="1980">1980s</option>
                    <option value="1990">1990s</option>
                    <option value="2000">2000s</option>
                    <option value="2010">2010s</option>
                    <option value="2020">2020s</option>
                </select>
                <button type="submit">Filtrar</button>
            </form>
        </div>

    <li><a href="/actorout/countActors">Count Actors</a></li>

</ul>
    <div class="form-container">
        <h1 class="text-center">Add Movies</h1>
        <form action="{{ route('createFilm') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name" class="label-bold">Name:</label>
                <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="country" class="label-bold">Country:</label>
                <input type="text" id="country" name="country" class="form-control">
            </div>
            <div class="form-group">
                <label for="duration" class="label-bold">Duration:</label>
                <input type="number" id="duration" name="duration" class="form-control">
            </div>
            <div class="form-group">
                <label for="year" class="label-bold">Year:</label>
                <input type="number" id="year" name="year" class="form-control">
            </div>
            <div class="form-group">
                <label for="genre" class="label-bold">Genre:</label>
                <input type="text" id="genre" name="genre" class="form-control">
            </div>
            <div class="form-group">
                <label for="url" class="label-bold">URL:</label>
                <input type="text" id="url" name="url" class="form-control">
            </div>
            <button type="submit" name="send" class="btn btn-primary-custom btn-block">Add Movie</button>
        </form>
    </div>

    @if(isset($Error))
    <div class="alert alert-danger-custom mt-4">
        <h2 class="text-center">{{ $Error }}</h2>
    </div>
    @endif

    <!-- Add Bootstrap 5 JS and Popper.js (required for Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
</body>

</html>
