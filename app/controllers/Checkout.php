<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

\Stripe\Stripe::setApiKey(STRIPE_API_KEY);
class Checkout extends Controller
{
    public function __construct()
    {
        $this->countriesModel = $this->model('CountriesModel');
        $this->productsModel = $this->model('ProductsModel');
        $this->userModel = $this->model('UserModel');
        $this->ordersModel = $this->model('OrdersModel');
        $this->paymentService = $this->service(PAYMENT_SERVICE);
    }

    public function index()
    {

        $data['allPdt'] = $this->productsModel->getOne($_POST['product_id']);
        $data['countries'] = $this->countriesModel->getCountries();
        $data['userDetails'] = [];
        $data['states'] = [];
        if (isset($_SESSION['user'])) {
            // echo $_SESSION['user']['id'];
            $user_det = $this->userModel->getSingle($_SESSION['user']['id']);
            $data['userDetails'] = (object) $user_det;
            $data['states'] = $this->countriesModel->getStatesByCountry($data['userDetails']->country_code);
        }
        $data['body'] = 'checkout/checkout.php';
        $this->view('template/main.php', $data);
    }
    public function initializePayment()
    {
        $jsonStr = file_get_contents('php://input');
        $jsonObj = json_decode($jsonStr);
        $allPdt = $this->productsModel->getOne($jsonObj->items->pdtId);
        $this->paymentService->createIntent($allPdt['price']);
    }

    public function paymentSuccess()
    {

        $stripe = new \Stripe\StripeClient(STRIPE_API_KEY);
        $paymentDetails = $stripe->paymentIntents->retrieve(
            $_GET['payment_intent'],
            []
        );
        $paymentDetails = $this->paymentService->paymentDetails($_GET['payment_intent']);
        $orderArray = array();
        if (!empty($paymentDetails)) {
            // echo '<pre>';
            // print_r($paymentDetails);
            $orderArray['orderAmount'] = ($paymentDetails->amount) / 100;
            $orderArray['orderStatus'] = ($_GET['redirect_status'] == "succeeded") ? 'Success' : 'Failed';
            $orderArray['clientSecret'] = $paymentDetails->client_secret;
            $orderArray['id'] = $paymentDetails->id;
            $this->ordersModel->updateOrderStatus($orderArray);
        }

        $data['body'] = 'checkout/success.php';
        $this->view('template/main.php', $data);
    }
}
