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

// Function to create user with email and password
function doCreateUserWithEmailAndPassword($email, $password, $conn) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        return true; // User successfully created
    } else {
        return false; // Error creating user
    }

    // Close statement
    $stmt->close();
}

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Validate input
    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
    } else {
        // Check if email already exists
        $checkEmailQuery = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkEmailQuery);

        if ($result->num_rows > 0) {
            echo "Email already exists!";
        } else {
            // Create user
            if (doCreateUserWithEmailAndPassword($email, $password, $conn)) {
                echo "User successfully registered!";
                // Redirect or do something else after successful registration
            } else {
                echo "Error registering user!";
            }
        }
    }
}

// Close connection
$conn->close();
?>
