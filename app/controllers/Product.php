<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class Product extends Controller
{
    public function __construct()
    {
        $this->countriesModel = $this->model('CountriesModel');
        $this->productsModel = $this->model('ProductsModel');
        $this->userModel = $this->model('UserModel');
    }

    public function index()
    {

        $data['products'] = $this->productsModel->readAll();
        $data['body'] = 'products/list.php';
        $this->view('template/main.php', $data);
    }
    public function getState()
    {
        $stateList = $this->countriesModel->getStatesByCountry($_POST['countryCode']);
        echo json_encode($stateList);
    }
}
