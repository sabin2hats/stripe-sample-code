<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
class AjaxController extends Controller
{
    public function __construct()
    {
        $this->countriesModel = $this->model('CountriesModel');
    }

    public function index()
    {
        $data = [
            'title' => 'Home page'
        ];

        $this->view('index.php', $data);
    }
    public function getState()
    {
        $stateList = $this->countriesModel->getStatesByCountry($_POST['countryCode']);
        echo json_encode($stateList);
    }
}
