<?php
require_once 'db_config.php';

$post_id = isset($input['post_id']) ? $input['post_id'] : '';

if ( $post_id == '') {
    $error = 'You must ask for a post';

    $data = [
        'success' => false,
        'error' => $error,
    ];
    $jsonData = json_encode($data);

    echo $jsonData;
    die();
}

$stmt = $conn->prepare("SELECT content, created_at, u.username FROM Comments AS c JOIN Users AS u ON c.owner_id = u.user_id WHERE post_id = ? ORDER BY p.created_at DESC");
$stmt->bind_param('i', $post_id);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comments[] = [
            'content'    => $row['content'],
            'created_at' => $row['created_at'],
            'username'   => $row['username'],
        ];
    }
}

echo json_encode($comments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
