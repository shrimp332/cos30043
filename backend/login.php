<?php

require_once 'db_config.php';
require_once 'auth_common.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$username = isset($input['username']) ? $input['username'] : '';
$password = isset($input['password']) ? $input['password'] : '';

$stmt = $conn->prepare('SELECT user_id, password_hash from Users WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($user_id, $hash);

if (!$stmt->fetch()) {
    $error = 'Incorrect Username or Password';

    $data = [
        'success' => false,
        'error' => $error,
    ];
    $jsonData = json_encode($data);

    echo $jsonData;
    die();
} else if (!verify_password($hash, $password)) {
    $error = 'Incorrect Username or Password';

    $data = [
        'success' => false,
        'error' => $error,
    ];
    $jsonData = json_encode($data);

    echo $jsonData;
    die();
}

$stmt->close();

$stmt = $conn->prepare('INSERT INTO UserSessions (session_id, user_id) VALUES (?,?)');


// Loop as (very low) chance of duplicate key generated
$session_id = '';
$inserted = false;
while (!$inserted) {
    $session_id = generate_session_id();
    $stmt->bind_param('si', $session_id, $user_id);

    if (!$stmt->execute()) {
        if ($stmt->errno == 1062) {
            continue;
        } else {
            $error = 'Internal Server Error';

            $data = [
                'success' => false,
                'error' => $error,
            ];
            $jsonData = json_encode($data);

            http_response_code(500);
            echo $jsonData;
            die();
        }
    }
    $inserted = true;
}

setcookie(
    "session_id",
    $session_id,
    time() + 604800, // expires 1 week
    "/",
    "",    // domain
    false, // https
    true   // http only
);

$data = [
    'success' => true,
];

$jsonData = json_encode($data);

echo $jsonData;
