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


    public function paymentSuccess()
    {

        $data['body'] = 'checkout/success.php';
        $this->view('template/main.php', $data);
    }
}
