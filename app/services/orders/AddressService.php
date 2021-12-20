<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class AddressService
{
    public function validEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    public function sendUrl($url = null)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    public function validateAddress($user = null, $key)
    {
        $country = $user['ship_country'];
        // $addressStr = 'Jyothirmaya,%20Wing%201,%204th%20floor,%20Infopark%20Phase%202,%20Kakkanad,%20Kochi,%20Kerala';
        $addressStr = $user['ship_line1'] . ',' . $user['ship_line2'] . ',' . $user['ship_city'] . ',' . $user['ship_state'];
        $address = $addressStr . '&components=country:' . $country . '&key=' . $key;
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address;
        $status = json_decode($this->sendUrl($url));
        if (!empty($status)) {
            if ($status->status == 'OK') {
                return true;
            }
        }
        return false;
        // print_r($status);
        // die;
    }
}
