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

function verify_password($hashed_password, $password)
{
    return hash_equals($hashed_password, crypt($password, $hashed_password));
}

function generate_session_id()
{
    return bin2hex(openssl_random_pseudo_bytes(16));
}
