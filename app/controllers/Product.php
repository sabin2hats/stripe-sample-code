<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class Product extends Controller
{
    public function __construct()
    {
        $this->CountriesModel = $this->model('CountriesModel');
        $this->ProductsModel = $this->model('ProductsModel');
        $this->UserModel = $this->model('UserModel');
    }

    public function index()
    {

        $data['products'] = $this->ProductsModel->readAll();
        $this->view('products/list.php', $data);
    }
    public function getState()
    {
        $stateList = $this->CountriesModel->getStatesByCountry($_POST['countryCode']);
        echo json_encode($stateList);
    }
    public function checkout()
    {
        $data['all_pdt'] = $this->ProductsModel->readOne($_POST['product_id']);
        $data['countries'] = $this->CountriesModel->getCountries();
        $data['user_det'] = [];
        $data['states'] = [];
        if (isset($_SESSION['user'])) {
            $data['user_det'] = $this->userModel->readOneuser($_SESSION['user']['id']);
            $data['states'] = $this->CountriesModel->getStatesByCountry($data['user_det']->country_code);
        }
        $this->view('checkout/checkout.php', $data);
    }
}
