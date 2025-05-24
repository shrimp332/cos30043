<?php
require_once 'db_config.php';
require_once 'auth_validate_session.php';

$input = json_decode(file_get_contents('php://input'), true);
$post_id = isset($input['post_id']) ? $input['post_id'] : '';
$content_form = isset($input['content']) ? $input['content'] : '';

if ($content_form == '' || $post_id == '') {
    $error = 'You must have content to upload';

    $data = [
        'success' => false,
        'error' => $error,
    ];
    $jsonData = json_encode($data);

    echo $jsonData;
    die();
}

$stmt = $conn->prepare('INSERT INTO Comments (content, owner_id, post_id) VALUES (?,?,?)');
$stmt->bind_param('sii', $content_form, $user_id_db, $post_id);

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
];

$jsonData = json_encode($data);

echo $jsonData;
