<?php
function generate_crypt_salt($cost = 10)
{
    $string = base64_encode(openssl_random_pseudo_bytes(16));

    $string = strtr($string, '+', '.');
    $string = strtr($string, '/', '.');
    $safe_string = strtr($string, '=', '.');

    $salt = substr($safe_string, 0, 22);

    return sprintf('$2y$%02d$%s$', $cost, $salt);
}

// because of the decision to use php 5.4 on mercury (9 years EOL btw) I have to make my own implementation of hash_equals, please get the admins to update mercury. or make a new server. I've had to make a lot of concessions for this project because of out of date software.
function hash_eq($str1, $str2)
{
    if (strlen($str1) !== strlen($str2)) {
        return false;
    }
    $result = 0;
    for ($i = 0; $i < strlen($str1); $i++) {
        $result |= ord($str1[$i]) ^ ord($str2[$i]);
    }
    return $result === 0;
}

function verify_password($hashed_password, $password)
{
    return hash_eq($hashed_password, crypt($password, $hashed_password));
}

function generate_session_id()
{
    return bin2hex(openssl_random_pseudo_bytes(16));
}
