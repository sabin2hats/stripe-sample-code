<?php
interface PaymentsInterface
{
    public function calculateOrderAmount($price, $quantity);
    public function createIntent($price);
    public function paymentDetails($paymentIntent);
}
