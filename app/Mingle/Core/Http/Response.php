<?php
    /**
     * Created by PhpStorm.
     * User: Optimistic
     * Date: 22/05/2019
     * Time: 5:41 AM
     */

    namespace App\Mingle\Core\Http;

    class Response extends \Illuminate\Http\Response
    {
        // construct the response object
        private function build($code, $content)
        {
            $content = array_merge(['status' => $code], $content);

            return response()->json($content, $code);
        }

        public function ok(String $message, Array $data = [])
        {
            return $this->build(self::HTTP_OK, array_merge([
                    'message' => $message
                ], $data)
            );
        }

        public function success(String $message, Array $data)
        {
            return $this->build(self::HTTP_CREATED, array_merge([
                'message' => $message
            ], $data));
        }

        public function badRequest(String $message, Array $errors = [])
        {
            $databag = ['message' => $message];

            if (sizeof($errors))
                $databag['errors'] = $errors;

            return $this->build(self::HTTP_BAD_REQUEST, $databag);
        }

        public function unauthorized(String $message)
        {
            return $this->build(self::HTTP_UNAUTHORIZED, ['message' => $message]);
        }

        public function accessDenied(String $message)
        {
            return $this->build(self::HTTP_FORBIDDEN, [
                'message' => $message
            ]);
        }

        public function notFound(String $message)
        {
            return $this->build(self::HTTP_NOT_FOUND, [
                'message' => $message
            ]);
        }

        public function forbidden(String $message)
        {
            return $this->build(self::HTTP_FORBIDDEN, [
                'message' => $message
            ]);
        }
    }