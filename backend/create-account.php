<?php
require_once 'db_config.php';
require_once 'auth_common.php';

$stmt = $conn->prepare('INSERT INTO Users (username, password_hash) VALUES (?,?)');

$input = json_decode(file_get_contents('php://input'), true);

$username = isset($input['username']) ? $input['username'] : '';
$password = isset($input['password']) ? $input['password'] : '';

if ($username == '' || $password == '') {
    $error = 'Username or password must not be empty';

    $data = [
        'success' => false,
        'error' => $error,
    ];
    $jsonData = json_encode($data);

    http_response_code(400);
    echo $jsonData;
    die();
}

$password_hash = crypt($password, generate_crypt_salt());

$stmt->bind_param("ss", $username, $password_hash);

try {
if (!$stmt->execute()) {
    if ($stmt->errno == 1062) {
        // Username taken
        $error = 'Username Taken';

        $data = [
            'success' => false,
            'error' => $error,
        ];
        $jsonData = json_encode($data);

        http_response_code(400);
        echo $jsonData;
    } else {
        $error = 'Internal Server Error';

        $data = [
            'success' => false,
            'error' => $error,
        ];
        $jsonData = json_encode($data);

        http_response_code(500);
        echo $jsonData;
    }
    die();
}
}
catch (Exception $_) {
        $error = 'Username Taken';

        $data = [
            'success' => false,
            'error' => $error,
        ];
        $jsonData = json_encode($data);

        http_response_code(400);
        echo $jsonData;
    die();
}

$data = [
    'success' => true,
];
$jsonData = json_encode($data);
echo $jsonData;
