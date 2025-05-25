<?php
require_once 'db_config.php';

$page = isset($_GET['page']) ? ((int) $_GET['page'] - 1) * 10 : 0;

$sql = "SELECT title, created_at, content, u.username, p.post_id, COUNT(l.user_id) as likes FROM Posts AS p JOIN Users AS u ON p.owner_id = u.user_id LEFT JOIN Likes AS l ON p.post_id = l.post_id GROUP BY p.post_id ORDER BY p.created_at DESC LIMIT 10 OFFSET $page";
$result = $conn->query($sql);

$posts = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = [
            'id'         => "/post/" . $row['post_id'],
            'title'      => $row['title'],
            'content'    => $row['content'],
            'created_at' => $row['created_at'],
            'username'   => $row['username'],
            'likes'      => $row['likes']
        ];
    }
}

$data = [
    'success' => true,
    'posts' => $posts
];

echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
