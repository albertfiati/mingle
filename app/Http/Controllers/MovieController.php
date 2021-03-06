<?php

    namespace App\Http\Controllers;

    use App\Mingle\Swapi\Characters;
    use App\Mingle\Swapi\Movies;

    class MovieController extends Controller
    {
        public function index(Movies $swapiMovie)
        {
            // load all movies in the database
            $movies = $swapiMovie->fetch();

            return $this->response->ok('List of all movies', $movies);
        }

        public function characters(Movies $swapiMovie, Characters $swapiCharacter)
        {
            // check if the request contains a movie key in the body
            if ($movie = $this->request->get('movie', null)) {
                // get movie with a specific title
                $_movie = $swapiMovie->get($movie);

                // load the characters of a movie
                $characters = $swapiCharacter->load($movie, $_movie['characters']);

                return $this->response->ok("List of all characters in {$movie}", [
                    'movie'   => $_movie,
                    'results' => $characters
                ]);
            }

            return $this->response->badRequest('Invalid request parameters.', [
                'Movie field is required'
            ]);
        }
    }
