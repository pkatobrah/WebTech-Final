<?php
require_once 'db/config.php';
function cors() {
    
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400'); 
    }
    
    
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
        exit(0);
    }
    
    echo "You have CORS!";
}
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $title = $data['title'];
        $author = $data['author'];
        $genre = $data['genre'];
        $book_condition = $data['book_condition'];
        $description = $data['description'];

    
        
        $stmt = $pdo->prepare('INSERT INTO Books (title, author, genre, book_condition, description) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$title, $author, $genre,$book_condition, $description ]);
        
        echo json_encode(['message' => 'Book added successfully']);
        break;
   }
?>
