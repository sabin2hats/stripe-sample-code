<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
class EmailRisk
{
    public function validEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    public function validateDomain($email)
    {
        $domain = explode("@", $email);
        $domain = array_pop($domain);
        if (checkdnsrr($domain, "MX")) {
            return true;
        } else {
            return false;
        }
    }
}
