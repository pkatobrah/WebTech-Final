<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book exchange";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to verify user credentials
function doSignInWithEmailAndPassword($email, $password, $conn) {
    // Prepare and bind parameters
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            return true; // Password correct
        } else {
            return false; // Password incorrect
        }
    } else {
        return false; // User not found
    }

    // Close statement
    $stmt->close();
}

// Handle sign-in form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Verify user credentials
    if (doSignInWithEmailAndPassword($email, $password, $conn)) {
        echo "Sign-in successful!";
        // Redirect or do something else after successful sign-in
    } else {
        echo "Invalid email or password!";
    }
}

// Close connection
$conn->close();
?>
