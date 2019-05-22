<?php
    /**
     * Created by PhpStorm.
     * User: Optimistic
     * Date: 22/05/2019
     * Time: 5:58 AM
     */

    namespace App\Mingle\Swapi;


    use GuzzleHttp\Client;

    class Swapi
    {
        protected $client, $base_url;

        public function __construct(Client $client)
        {
            $this->base_url = env('SWAPI_BASE_URL');
            $this->client = $client;
        }

        public function test($url)
        {
            $store = app('cache')->store('database');
            $client = new \Brightfish\CachingGuzzle\Client($store, [
                'cache_ttl' => 12345,
                'cache_log' => app()->environment('local'),
                'base_uri'  => 'https://example.org/api'
            ]);

            return $client->get($url, ['cache_ttl' => 3600]);
        }

        public function parseResponseBody($response)
        {
            return json_decode($response->getBody()->getContents(), true);
        }
    }