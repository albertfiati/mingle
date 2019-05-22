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
    use Illuminate\Support\Facades\Log;

    class Characters extends Swapi
    {
        CONST CACHE_KEY = 'CHARACTERS';

        public function get(String $endpoint)
        {
            // create a unique cache key for the query
            $cacheKey = self::CACHE_KEY . "." . substr($endpoint, -2, -1);

            // return cached data if available else make new query
            return cache()->remember($cacheKey, Carbon::now()->addMinutes(env('CACHE_TTL')), function () use ($endpoint) {
                try {
                    $response = $this->client->get($endpoint);

                    if ($response->getStatusCode() == 200) {
                        return $this->parseResponseBody($response);
                    }

                    throw new SwapiBounceException('Swapi request could not be completed');
                } catch (\Exception $exception) {
                    throw new InvalidSwapiRequestException('Swapi request is invalid.');
                }
            });
        }

        public function load($movie, $characters)
        {
            // create a unique cache key for the query
            $cacheKey = self::CACHE_KEY . "." . strtoupper($movie);

            return cache()->remember($cacheKey, Carbon::now()->addMinutes(env('CACHE_TTL')), function () use ($characters) {
                return array_map(function ($character) {
                    try {
                        return $this->get($character);
                    } catch (\Exception $exception) {
                        Log::debug($exception->getMessage());
                    }
                }, $characters);
            });
        }
    }