<?php
session_start();
require_once '../settings/core.php';
require_once '../settings/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $condition = $_POST['book_condition'];
    $description = $_POST['description'];

    $sql = "INSERT INTO books (title, author, genre, `book_condition`, description) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $title, $author, $genre, $condition, $description);

    if ($stmt->execute()) {
        // Book added successfully
        echo json_encode(["success" => true, "message" => "Book added successfully"]);
    } else {
        // Error occurred
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }
    

    $stmt->close();
    $conn->close();
}
?>
