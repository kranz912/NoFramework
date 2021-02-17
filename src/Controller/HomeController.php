<?php declare(strict_types=1);

namespace NoFramework\Controller;

use Sabre\HTTP;

class HomeController
{
    private $response;

    public function __construct(HTTP\Response  $response){
        $this->response = $response;
    }

    public function index(){
        $this->response->setBody(
            'Hello World'
        );
    }
}