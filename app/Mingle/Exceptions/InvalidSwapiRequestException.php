<?php
    /**
     * Created by PhpStorm.
     * User: Optimistic
     * Date: 22/05/2019
     * Time: 6:23 AM
     */

    namespace App\Mingle\Exceptions;


    use Throwable;

    class InvalidSwapiRequestException extends \Exception
    {
        public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }
    }