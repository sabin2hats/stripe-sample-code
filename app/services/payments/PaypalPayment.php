<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// This is your test secret API key.
\Stripe\Stripe::setApiKey(STRIPE_API_KEY);
class PaypalPayment implements PaymentsInterface
{
    function test()
    {
        echo "HAI";
        die;
    }

    public function calculateOrderAmount($price, $quantity = 1): int
    {
        return $price * $quantity * 100;
    }



    public function createIntent($price = null)
    {
        header('Content-Type: application/json');

        try {

            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $this->calculateOrderAmount($price, 1),
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
    public function paymentDetails($paymentIntent = null)
    {
        try {
            $stripe = new \Stripe\StripeClient(STRIPE_API_KEY);
            $paymentDetails = $stripe->paymentIntents->retrieve(
                $paymentIntent,
                []
            );
            return $paymentDetails;
        } catch (Error $e) {
            // http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
