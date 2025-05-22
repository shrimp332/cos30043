<?php
$data = [
    'message' => phpversion()
];

$jsonData = json_encode($data);

header('Content-Type: application/json');

echo $jsonData;
?>
