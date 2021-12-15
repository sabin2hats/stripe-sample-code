<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
class Orders extends Controller
{
    public function __construct()
    {
        $this->ordersModel = $this->model('OrdersModel');
    }

    public function index()
    {
    }

    public function createOrder()
    {
        $this->ordersModel->createOrder($_POST['formdata']);
    }
}
