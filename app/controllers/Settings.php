<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class Settings extends Controller
{
    public function __construct()
    {
        $this->settingsModel = $this->model('SettingsModel');
    }

    public function index()
    {
        // $allOrders = $this->ordersModel->getAll();
        // $data['allOrders'] = (object)$allOrders;
        // echo '<pre>';
        // print_r($allOrders);
        // die;
        $data['body'] = 'orders/list.php';
        $this->view('template/main.php', $data);
    }

    public function apiKey()
    {
        $data['apikey'] = $this->settingsModel->getApikey();
        $data['body'] = 'settings/apikey.php';
        $this->view('template/main.php', $data);
    }
    public function saveApikey()
    {

        if ($this->settingsModel->saveApikey($_POST)) {
            $status = "Success";
        } else {
            $status = "Failed";
        }
        $this->redirect('settings/apiKey?status=' . $status);
    }

    public function redlistEmails()
    {
        $data['emails'] = $this->settingsModel->getredListedmails();
        $data['body'] = 'settings/redlistEmail.php';
        $this->view('template/main.php', $data);
    }

    public function saveRedlistedemails()
    {
        if ($this->settingsModel->redListemails($_POST)) {
            $status = "Success";
        } else {
            $status = "Failed";
        }
        $this->redirect('settings/redlistEmails?status=' . $status);
    }
}
