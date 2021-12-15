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
    }

    public function index()
    {

        $data['all_pdt'] = $this->productsModel->getOne($_POST['product_id']);
        $data['countries'] = $this->countriesModel->getCountries();
        $data['user_det'] = [];
        $data['states'] = [];
        if (isset($_SESSION['user'])) {
            // echo $_SESSION['user']['id'];
            $user_det = $this->userModel->getSingle($_SESSION['user']['id']);
            $data['user_det'] = (object) $user_det;
            $data['states'] = $this->countriesModel->getStatesByCountry($data['user_det']->country_code);
        }
        $data['body'] = 'checkout/checkout.php';
        $this->view('template/main.php', $data);
    }
    public function calculateOrderAmount($price, $quantity = 1): int
    {
        return $price * $quantity * 100;
    }

    public function createIntent()
    {
        header('Content-Type: application/json');

        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);
            $allPdt = $this->productsModel->getOne($jsonObj->items->pdtId);
            // print_r($all_pdt);
            // die;

            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $this->calculateOrderAmount($allPdt['price'], 1),
                'currency' => 'inr',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],

            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
                'id' => $paymentIntent->id
            ];

            echo json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function paymentSuccess()
    {

        $stripe = new \Stripe\StripeClient(STRIPE_API_KEY);
        $paymentDetails = $stripe->paymentIntents->retrieve(
            $_GET['payment_intent'],
            []
        );
        $orderArray = array();
        if (!empty($paymentDetails)) {
            // echo '<pre>';
            // print_r($paymentDetails);
            $orderArray['orderAmount'] = ($paymentDetails->amount) / 100;
            $orderArray['orderStatus'] = ($_GET['redirect_status'] == "succeeded") ? 'Success' : 'Failed';
            $orderArray['clientSecret'] = $paymentDetails->client_secret;
            $orderArray['id'] = $paymentDetails->id;
            $this->ordersModel->updateOrder($orderArray);
        }
        $data['body'] = 'checkout/success.php';
        $this->view('template/main.php', $data);
    }
}
