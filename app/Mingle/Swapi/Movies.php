<?php
    /**
     * Created by PhpStorm.
     * User: Optimistic
     * Date: 22/05/2019
     * Time: 5:57 AM
     */

    namespace App\Mingle\Swapi;


    use App\Mingle\Exceptions\InvalidSwapiRequestException;
    use App\Mingle\Exceptions\SwapiBounceException;
    use Carbon\Carbon;
    use Illuminate\Support\Str;

    class Movies extends Swapi
    {
        CONST CACHE_KEY = 'MOVIES.ALL';
        private $endpoint = "films";

        public function fetch()
        {
            // return cached data if available else make new query
            return cache()->remember(self::CACHE_KEY, Carbon::now()->addMinutes(env('CACHE_TTL')), function () {
                try {
                    $response = $this->client->get($this->base_url . $this->endpoint);

                    if ($response->getStatusCode() == 200) {
                        $response = $this->parseResponseBody($response);

                        // set slug for each movie and set the year of release
                        $response['results'] = array_map(function ($movie) {
                            $movie['slug'] = Str::slug($movie['title']);
                            $movie['year_of_release'] = substr($movie['release_date'], 0, 4);
                            return $movie;
                        }, $response['results']);

                        return $response;
                    }
                    throw new SwapiBounceException('Swapi request could not be completed');
                } catch (\Exception $exception) {
                    throw new InvalidSwapiRequestException('Swapi request is invalid.');
                }
            });
        }

        public function get($title)
        {
            try {
                $movies = $this->fetch()['results'];

                if (sizeof($movies)) {
                    $title = str_replace("-", " ", $title);

                    foreach ($movies as $key => $movie) {
                        if (strtolower($movie['title']) == strtolower($title)) {
                            return $movie;
                        }
                    }
                }

                throw new SwapiBounceException('Swapi request could not be completed');
            } catch (\Exception $exception) {
                throw new InvalidSwapiRequestException('Swapi request is invalid.');
            }
        }
    }