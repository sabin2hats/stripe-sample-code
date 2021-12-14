<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// This is your test secret API key.

\Stripe\Stripe::setApiKey(STRIPE_API_KEY);
class Checkout extends Controller
{
    public function __construct()
    {
        $this->CountriesModel = $this->model('CountriesModel');
        $this->ProductsModel = $this->model('ProductsModel');
        $this->UserModel = $this->model('UserModel');
    }

    public function index()
    {

        $data['all_pdt'] = $this->ProductsModel->readOne($_POST['product_id']);
        $data['countries'] = $this->CountriesModel->getCountries();
        $data['user_det'] = [];
        $data['states'] = [];
        if (isset($_SESSION['user'])) {
            // echo $_SESSION['user']['id'];
            $user_det = $this->UserModel->readOneuser($_SESSION['user']['id']);
            $data['user_det'] = (object) $user_det;
            $data['states'] = $this->CountriesModel->getStatesByCountry($data['user_det']->country_code);
        }
        $this->view('checkout/checkout.php', $data);
    }
    function calculateOrderAmount($price, $quantity = 1): int
    {
        // Replace this constant with a calculation of the order's amount
        // Calculate the order total on the server to prevent
        // people from directly manipulating the amount on the client
        return $price * $quantity * 100;
        // return 1400;
    }

    public function createIntent()
    {
        header('Content-Type: application/json');

        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);
            $all_pdt = $this->ProductsModel->readOne($jsonObj->items->pdtId);
            // print_r($all_pdt);
            // die;

            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $this->calculateOrderAmount($all_pdt['price'], 1),
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
    function createOrder()
    {
        $this->ProductsModel->createOrder($_POST['formdata']);
    }
    function paymentSuccess()
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
            $orderArray['orderAmount'] = $paymentDetails->amount;
            $orderArray['orderStatus'] = ($_GET['redirect_status'] == "succeeded") ? 'Success' : 'Failed';
            $orderArray['clientSecret'] = $paymentDetails->client_secret;
            $orderArray['id'] = $paymentDetails->id;
            $this->ProductsModel->updateOrder($orderArray);
        }


        $this->view('checkout/success.php');
    }
}
