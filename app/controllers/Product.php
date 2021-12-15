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

        $data['products'] = $this->productsModel->getAll();
        $data['body'] = 'products/list.php';
        $this->view('template/main.php', $data);
    }
}
