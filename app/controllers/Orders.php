<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class Orders extends Controller
{
    public function __construct()
    {
        $this->ordersModel = $this->model('OrdersModel');
        $this->settingsModel = $this->model('SettingsModel');
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
        foreach ($allOrders as $key => $value) {
            $allOrders[$key]['orderRisk'] = $this->orderRisk($value, $redListedemailsArray, $apiKey[0]['apikey']);
        }

        $data['allOrders'] = (object)$allOrders;
        $data['body'] = 'orders/list.php';
        $this->view('template/main.php', $data);
    }
    public function orderRisk($order = null, $redListedemails = null, $apiKey)
    {
        // echo $order['email'];
        $r = 0;
        $orderRisk = [];
        $orderRisk['validEmail'] = '';
        $orderRisk['validateDomain'] = '';
        $orderRisk['redListedEmail'] = '';
        $orderRisk['validAddress'] = '';
        if (!$this->orderRiskService->validEmail($order['email'])) {
            $orderRisk['validEmail'] = 'Invalid Email';
            $r++;
        }
        if (!$this->orderRiskService->validateDomain($order['email'])) {
            $orderRisk['validateDomain'] = 'Invalid Email Domain';
            $r++;
        }
        if (in_array($order['email'], $redListedemails)) {
            $orderRisk['redListedEmail'] = 'Red Listed Email';
            $r++;
        }
        if (!$this->addressService->validateAddress($order, $apiKey)) {
            $orderRisk['validAddress'] = 'Invalid Shipping Address';
            $r++;
        }
        $orderRisk['riskStatus'] = $r ? (($r / 4 * 100) . '%') : '';
        return $orderRisk;
    }

    public function createOrder()
    {
        $this->ordersModel->createOrder($_POST['formdata']);
    }
}
