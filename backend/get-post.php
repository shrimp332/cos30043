<?php
require_once 'db_config.php';

$post_id = $_GET['post_id'];

$stmt = $conn->prepare('SELECT title, content, created_at, u.username, COUNT(l.user_id) AS like_count FROM Posts AS p JOIN Users AS u ON p.owner_id = u.user_id LEFT JOIN Likes AS l ON p.post_id = l.post_id WHERE p.post_id = ? GROUP BY p.post_id');
$stmt->bind_param("i", $post_id);
$stmt->execute();
$stmt->bind_result($title_db, $content_db, $created_at_db, $username_db, $likes_quant_db);

if (!$stmt->fetch()) {
    $error = 'Unable to find post';

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
    'id' => $post_id,
    'title' => $title_db,
    'content' => $content_db,
    'timestamp' => $created_at_db,
    'owner' => $username_db,
    'likes' => $likes_quant_db
];

$jsonData = json_encode($data);
echo $jsonData;
