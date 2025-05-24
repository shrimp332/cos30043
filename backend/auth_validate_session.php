<?php
require_once 'db_config.php';

$input = json_decode(file_get_contents('php://input'), true);

$session_cookie_id = isset($_COOKIE['session_id']) ? $_COOKIE['session_id'] : '';
$username_form = isset($input['username']) ? $input['username'] : '';

if ($session_cookie_id == '' || $username_form == '') {
    $error = 'session_id or username are empty';

    $data = [
        'success' => false,
        'error' => $error,
        'id' => $session_cookie_id,
        'user' => $username_form,
    ];
    $jsonData = json_encode($data);

    echo $jsonData;
    die();
}

$stmt = $conn->prepare('SELECT u.user_id, username FROM Users AS u JOIN UserSessions AS us ON u.user_id = us.user_id WHERE us.session_id = ?');
$stmt->bind_param('s', $session_cookie_id);
$stmt->execute();
$stmt->bind_result($user_id_db, $username_db);

if (!$stmt->fetch()) {
    $error = 'You are not logged in';

    $data = [
        'success' => false,
        'error' => $error,
    ];
    $jsonData = json_encode($data);

    echo $jsonData;
    die();
}

if ($username_db != $username_form) {
    $error = 'You are not logged in';

    $data = [
        'success' => false,
        'error' => $error,
    ];
    $jsonData = json_encode($data);

    echo $jsonData;
    die();
}

$stmt->close();
