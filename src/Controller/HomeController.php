<?php declare(strict_types=1);

namespace NoFramework\Controller;

use Sabre\HTTP\Request;
use Sabre\HTTP\Response;

class HomeController
{
    private $response;
    private $request;
    public function __construct(Response  $response,Request $request){
        $this->response = $response;
        $this->request = $request;
    }

    public function index(){
        $content = '<h1>Hello</h1>';
        $content .= ''. $this->request->getQueryParameters()['name'];

        $this->response->setBody(
           $content
        );
    }
}