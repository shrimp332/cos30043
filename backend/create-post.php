<?php
require_once 'db_config.php';
require_once 'auth_validate_session.php';

$input = json_decode(file_get_contents('php://input'), true);
$title_form = isset($input['title']) ? $input['title'] : '';
$content_form = isset($input['content']) ? $input['content'] : '';

if ($content_form == '' || $title_form == '') {
    $error = 'You must have content to upload';

    $data = [
        'success' => false,
        'error' => $error,
    ];
    $jsonData = json_encode($data);

    echo $jsonData;
    die();
}

$stmt = $conn->prepare('INSERT INTO Posts (title, content, owner_id) VALUES (?,?,?)');
$stmt->bind_param('ssi', $title_form, $content_form, $user_id_db);

if (!$stmt->execute()) {
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


$data = [
    'success' => true,
    'id' => $conn->insert_id,
];

$jsonData = json_encode($data);

echo $jsonData;
