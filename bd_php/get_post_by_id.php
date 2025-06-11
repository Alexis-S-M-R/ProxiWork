<?php 
include "db_connect.php";

function getPostData($conn, $postId) {
    $stmt = $conn->prepare("SELECT * FROM post WHERE id = ?");
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $stmt->close();
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $postId = $_GET["postId"];

    echo json_encode(getPostData($conn, $postId));
}