<?php
<?php
namespace App\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->layout = "main"; // Set default layout for all actions
    }

    public function index()
    {
        $this->pageTitle = "Home";

        $data = "some data";

        $this->view("home/index", [
            "data" => $data,
        ]);
    }

    // Sample web page to use API request
    public function sampleApiRequest()
    {
        //$this->layout = 'simple';
        $this->pageTitle = "Sample API Request From Web";
        $this->view('home/apiRequestSample');
    }
}
