<?php
require_once 'db_config.php';
require_once 'auth_validate_session.php';

$input = json_decode(file_get_contents('php://input'), true);

$post_id = isset($input['post_id']) ? $input['post_id'] : '';

if ($post_id == '') {
    $error = 'No post_id detected';

    $data = [
        'success' => false,
        'error' => $error,
    ];


    echo json_encode($data);
    die();
}

$stmt = $conn->prepare('INSERT INTO Likes (post_id, user_id) VALUES (?,?)');
$stmt->bind_param('ii', $post_id, $user_id_db);
$stmt->execute();

$data = [
    'success' => true,
];

echo json_encode($data);
die();
