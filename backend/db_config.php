<?php

$host = '10.0.0.196';
$user = 'root';
$pass = '1234';
$db   = 'designdb';

try {
    $conn = new mysqli($host, $user, $pass, $db);
} catch (Exception $e) {
    http_response_code(500);
    die("Database Connection Failed");
}

if ($conn->connect_error) {
    http_response_code(500);
    die("Database Connection Failed");
}
?>
