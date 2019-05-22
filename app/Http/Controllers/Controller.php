<?php

    namespace App\Http\Controllers;

    use App\Mingle\Core\Http\Response;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller as BaseController;

    class Controller extends BaseController
    {
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        # define response and request obects
        protected $response, $request;

        # initialize the response and request objects
        public function __construct(Response $response, Request $request)
        {
            $this->response = $response;
            $this->request = $request;
        }
    }
