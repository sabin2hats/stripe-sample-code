<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class User extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
        $this->CountriesModel = $this->model('CountriesModel');
    }

    public function index()
    {
        $data = [
            'title' => 'Home page'
        ];

        $this->view('index.php', $data);
    }
    public function login()
    {

        $this->view('user/login.php');
    }
    public function loginUser()
    {


        $user = $this->userModel->getCurrentUser($_POST['email'], $_POST['psw']);
        // print_r($user);
        // die;
        if (!empty($user)) {
            @session_start();
            $_SESSION['user'] = $user;
            header('Location: ' . URLROOT . 'product');
        }
    }
    public function register()
    {

        $data['countries'] = $this->CountriesModel->getCountries();
        $this->view('user/register.php', $data);
    }
    public function createNewUser()
    {
        $this->userModel->createNewUser($_POST);
        $this->view('user/login.php');
    }

    public function logout()
    {
        if (isset($_SESSION['user'])) {
            session_destroy();
            header("Location: " . URLROOT . "user/login");
            exit();
        } else {
            session_destroy();
            header("Location: " . URLROOT . "user/login");
            exit();
        }
    }
}
