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
            CURLOPT_TIMEOUT => 0,
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
        $country = $user['shipCountry'];
        $shipLine1 = ($country != 'GB') ? (explode('-', $user['shipLine1'])[0]) : $user['shipLine1'];
        // $addressStr = 'Jyothirmaya,%20Wing%201,%204th%20floor,%20Infopark%20Phase%202,%20Kakkanad,%20Kochi,%20Kerala';
        $addressStr = $user['shipLine1'] . ',' . $user['shipZip'] . ' ' . $user['shipCity'];
        $addressStr2 = $user['shipLine1'] . ',' . $user['shipZip'] . ' ' . $user['shipCity'];
        $addressStr3 = $user['shipLine1'] . ',' . $user['shipCity'] . ' ' . $user['shipZip'];
        $address = $addressStr . '&components=country:' . $country . '&key=' . $key;
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . str_replace(' ', '%20', $address);
        $status = $this->sendUrl($url);
        $status = json_decode($status);
        if (!empty($status)) {
            if ($status->status == 'OK') {
                $countryName = $this->findCountry($status->results[0]->address_components);
                $countryName2 = $status->results[0]->address_components[5]->long_name;
                $formattedAddress = $status->results[0]->formatted_address;

                if (preg_replace('/\s+|\,/', '', $formattedAddress) == preg_replace('/\s+|\,/', '', $addressStr2 . ',' . $countryName)) {
                    return true;
                } else if (preg_replace('/\s+|\,/', '', $formattedAddress) == preg_replace('/\s+|\,/', '', $addressStr3 . ',' . (($country == 'GB') ? 'UK' : $countryName))) {
                    return true;
                }
                // if (similar_text(preg_replace('/\s+|\,/', '', $formattedAddress), preg_replace('/\s+|\,/', '', $addressStr2 . ',' . $countryName), $percent) > 90) {
                //     return true;
                // } else if (similar_text(preg_replace('/\s+|\,/', '', $formattedAddress), preg_replace('/\s+|\,/', '', $addressStr3 . ',' . (($country == 'GB') ? 'UK' : $countryName)), $percent) > 90) {
                //     return true;
                // }
            }
        }
        return false;
        // echo '<pre>';

        // $countryName = $this->findCountry($status->results[0]->address_components);
        // $formattedAddress = $status->results[0]->formatted_address;
        // // print_r($status->results[0]);
        // // // echo '<pre>';
        // var_dump(preg_replace('/\s+|\,/', '', $formattedAddress));
        // var_dump(preg_replace('/\s+|\,/', '', $addressStr2 . ',' . $countryName));
        // var_dump(preg_replace('/\s+|\,/', '', $addressStr3 . ',' . (($country == 'GB') ? 'UK' : $countryName)));
        // // die;
        // var_dump(similar_text($formattedAddress, ($addressStr2 . ',' . $countryName), $percent));
        // die;
    }
    public function findCountry($data = null)
    {
        foreach ($data as $key) {
            if (in_array('country', $key->types)) {
                return $key->long_name;
            }
        }
    }
}
