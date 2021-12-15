<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
class User extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
        $this->countriesModel = $this->model('CountriesModel');
    }

    public function index()
    {
        if (isLoggedIn()) {
            $this->redirect('');
        }
        $data['body'] = 'user/login.php';
        $this->view('template/main.php', $data);
    }

    public function processLoginRequest()
    {
        $user = $this->userModel->getUser($_POST['email'], $_POST['psw']);
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
    public function processRegisterRequest()
    {
        if ($this->userModel->saveNew($_POST)) {
            $status = '?success=1';
        } else {
            $status = '?success=2';
        }
        $this->redirect('user/' . $status);
    }

    public function logout()
    {
        if (logoutUser()) {
            $this->redirect('user/');
        }
    }
}
