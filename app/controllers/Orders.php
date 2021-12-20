<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class Orders extends Controller
{
    public function __construct()
    {
        $this->ordersModel = $this->model('OrdersModel');
        $this->settingsModel = $this->model('SettingsModel');
        $this->productsModel = $this->model('ProductsModel');
        $this->countriesModel = $this->model('CountriesModel');
        $this->orderRiskService = $this->service('orders/EmailRisk');
        $this->addressService = $this->service('orders/AddressService');
    }

    public function index()
    {
        $allOrders = $this->ordersModel->getAll();
        $redListedemails = $this->settingsModel->getredListedmails();
        $apiKey = $this->settingsModel->getApikey();
        $redListedemailsArray = explode(',', $redListedemails[0]['emails']);
        // echo '<pre>';
        // print_r($allOrders);
        // die;
        // $data['body'] = 'orders/list.php';
        // $this->view('template/main.php', $data);
        // foreach ($allOrders as $key => $value) {
        //     $allOrders[$key]['orderRisk'] = $this->orderRisk($value, $redListedemailsArray, $apiKey[0]['apikey']);
        // }

        $data['allOrders'] = (object)$allOrders;
        $data['body'] = 'orders/list.php';
        $this->view('template/main.php', $data);
    }
    public function orderRisk($order = null, $redListedemails = null, $apiKey = null)
    {
        // echo $order['email'];
        $apiKey = $this->settingsModel->getApikey();
        $redListedemails = $this->settingsModel->getredListedmails();
        $redListedemailsArray = explode(',', $redListedemails[0]['emails']);
        $r = 0;
        $orderRisk = [];
        $orderRisk['emailStructure'] = 'Valid';
        $orderRisk['emailDomain'] = 'Valid';
        $orderRisk['emailRedlisted'] = 'No';
        $orderRisk['validShippingAddress'] = 'Yes';
        if (!$this->orderRiskService->validEmail($order['email'])) {
            $orderRisk['emailStructure'] = 'Invalid';
            $r++;
        }
        if (!$this->orderRiskService->validateDomain($order['email'])) {
            $orderRisk['emailDomain'] = 'Invalid';
            $r++;
        }
        if (in_array($order['email'], $redListedemailsArray)) {
            $orderRisk['emailRedlisted'] = 'Yes';
            $r++;
        }
        if (!$this->addressService->validateAddress($order, $apiKey[0]['apikey'])) {
            $orderRisk['validShippingAddress'] = 'No';
            $r++;
        }
        $orderRisk['riskStatus'] = $r ? (($r / 4 * 100)) : '';
        return $orderRisk;
    }

    public function createOrder()
    {

        $orderData = json_decode($_POST['formdata']);

        $order = array(
            'email' => $orderData->email,
            'shipLine1' => $orderData->shipLine1,
            'shipLine2' => $orderData->shipLine2,
            'shipCountry' => $orderData->shipCountry,
            'shipState' => $orderData->shipState,
            'shipCity' => $orderData->shipCity,
            'shipZip' => $orderData->shipZip
        );
        $orderRisk = $this->orderRisk($order);
        $this->ordersModel->createOrder($_POST['formdata'], $orderRisk);
        // print_r($orderRisk);
        // die;
    }
    public function editOrder()
    {
        $allOrders = $this->ordersModel->getOne($_POST['orderID']);
        $data['order'] = (object)$allOrders;
        $data['allPdt'] = $this->productsModel->getOne($data['order']->product_id);
        $data['countries'] = $this->countriesModel->getCountries();
        $data['shipStates'] = $this->countriesModel->getStatesByCountry($data['order']->ship_country);
        $data['billStates'] = $this->countriesModel->getStatesByCountry($data['order']->bill_country);
        // print_r($data['order']);
        $data['body'] = 'orders/edit.php';
        $this->view('template/main.php', $data);
    }
    public function updateOrder()
    {
        // print_r($_POST);
        $order = array(
            'email' => $_POST['email'],
            'shipLine1' => $_POST['shipLine1'],
            'shipLine2' => $_POST['shipLine2'],
            'shipCountry' => $_POST['shipCountry'],
            'shipState' => $_POST['shipState'],
            'shipCity' => $_POST['shipCity'],
            'shipZip' => $_POST['shipZip']
        );
        $orderRisk = $this->orderRisk($order);
        $status = "Failed to Update";
        if ($this->ordersModel->updateOrder($_POST, $orderRisk)) {
            $status = "Success";
        }
        $this->redirect('orders?status=' . $status);
    }
}
