<?php
require_once 'db_config.php';

$page = isset($_GET['offset']) ? (int) $_GET['offset'] : 0 * 10;

$sql = "SELECT title, content, created_at, u.username, p.post_id FROM Posts AS p JOIN Users AS u ON p.owner_id = u.user_id ORDER BY p.created_at DESC LIMIT 10 OFFSET $page";
$result = $conn->query($sql);

$posts = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = [
            'id'      => $row['post_id'],
            'title'      => $row['title'],
            'content'    => $row['content'],
            'created_at' => $row['created_at'],
            'username'   => $row['username'],
        ];
    }
}

echo json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
