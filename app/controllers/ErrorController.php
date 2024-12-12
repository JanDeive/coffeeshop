<?php
namespace App\Controllers;

class ErrorController extends Controller
{
    public function __construct()
    {
        $this->layout = "simple"; // Set default layout for all actions
        $this->pageTitle = "Error";
    }

    public function notFound()
    {
        // Set the HTTP response code to 404
        http_response_code(404);

        // Render the 404 error view
        $this->view('error/404');
    }

    public function forbidden()
    {
        http_response_code(400);

        $this->view('error/400');
    }

    public function internalServerError()
    {
        http_response_code(500);

        $this->view('error/500');
    }
}
