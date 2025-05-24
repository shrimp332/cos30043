<?php

require_once 'db_config.php';

$session_cookie_id = isset($_COOKIE['session_id']) ? $_COOKIE['session_id'] : '';

if ($session_cookie_id == '') {
    $error = 'session_id empty';

    $data = [
        'success' => false,
        'error' => $error,
    ];
    $jsonData = json_encode($data);

    echo $jsonData;
    die();
}


$stmt = $conn->prepare('SELECT username FROM Users AS u JOIN UserSessions AS us ON u.user_id = us.user_id WHERE us.session_id = ?');
$stmt->bind_param('s', $session_cookie_id);
$stmt->execute();
$stmt->bind_result($username);

if (!$stmt->fetch()) {
    $error = 'session_id not found';

    $data = [
        'success' => false,
        'error' => $error,
    ];
    $jsonData = json_encode($data);

    echo $jsonData;
    die();
}

$data = [
    'success' => true,
    'username' => $username,
];
$jsonData = json_encode($data);

echo $jsonData;
