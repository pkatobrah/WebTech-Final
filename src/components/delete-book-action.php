<?php
session_start();
require_once '../settings/core.php';
require_once '../settings/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookId = $_POST['book_id']; // Assuming you have a hidden input field with name 'book_id' in your form

    $sql = "DELETE FROM books WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);

    if ($stmt->execute()) {
        // Book deleted successfully
        echo json_encode(["success" => true, "message" => "Book deleted successfully"]);
    } else {
        // Error occurred
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
