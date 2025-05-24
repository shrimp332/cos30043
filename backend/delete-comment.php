<?php
require_once 'db_config.php';
require_once 'auth_validate_session.php';

$input = json_decode(file_get_contents('php://input'), true);

$comment_id = isset($input['comment_id']) ? $input['comment_id'] : '';

if ($comment_id == '') {
    $error = 'No post_id detected';

    $data = [
        'success' => false,
        'error' => $error,
    ];


    echo json_encode($data);
    die();
}

$stmt = $conn->prepare('DELETE FROM Comments WHERE comment_id = ? AND owner_id = ?');
$stmt->bind_param('ii', $comment_id, $user_id_db);
$stmt->execute();

$data = [
    'success' => true,
];

echo json_encode($data);
die();
