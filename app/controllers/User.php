<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class User extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
        $this->countriesModel = $this->model('CountriesModel');
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
        if (isLoggedIn()) {
            $this->redirect('');
        }
        $data['body'] = 'user/login.php';
        $this->view('template/main.php', $data);
    }
    public function loginUser()
    {


        $user = $this->userModel->getCurrentUser($_POST['email'], $_POST['psw']);
        if (loginUser($user)) {
            $this->redirect('');
        }
    }
    public function register()
    {

        $data['countries'] = $this->countriesModel->getCountries();
        $data['body'] = 'user/register.php';
        $this->view('template/main.php', $data);
    }
    public function createNewUser()
    {
        $this->userModel->createNewUser($_POST);
        $this->view('user/login.php');
    }

    public function logout()
    {
        if (logoutUser()) {
            $this->redirect('user/login');
        }
    }
}
