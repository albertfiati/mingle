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

    class Characters extends Swapi
    {
        public function get(String $endpoint)
        {
            try {
                $response = $this->client->getAsync($endpoint)->wait(true);

                if ($response->getStatusCode() == 200) {
                    return $this->parseResponseBody($response);
                }

                throw new SwapiBounceException('Swapi request could not be completed');
            } catch (\Exception $exception) {
                throw new InvalidSwapiRequestException('Swapi request is invalid.');
            }
        }
    }