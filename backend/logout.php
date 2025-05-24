<?php

require_once 'db_config.php';
require_once 'auth_validate_session.php';

header('Content-Type: application/json');

$stmt = $conn->prepare('DELETE us FROM UserSessions AS us JOIN Users AS u ON u.user_id = us.user_id WHERE us.session_id = ?');
$stmt->bind_param('s', $session_cookie_id);
$stmt->execute();

$stmt->close();

// delete cookie
setcookie(
    "session_id",
    '',
    -1,    // expires now
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
