<?php
// Start the session
session_start();

// Include dependencies
require_once '../config.php';
require_once '../includes/User.php';

// Prepare a JSON response array
$response = [
    'success' => false,
    'message' => 'An unknown error occurred.'
];

// Process only POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username and password are set
    if (!empty(trim($_POST["username"])) && !empty(trim($_POST["password"]))) {
        
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // Instantiate User class
        $user = new User($pdo);

        // Attempt to login
        if ($user->login($username, $password)) {
            // Login successful
            $response['success'] = true;
            $response['message'] = 'Login successful! Redirecting...';
        } else {
            // Invalid credentials
            $response['message'] = 'Invalid username or password.';
        }

    } else {
        // Username or password was empty
        $response['message'] = 'Please enter both username and password.';
    }

    // Close database connection
    unset($pdo);

} else {
    // Not a POST request
    $response['message'] = 'Invalid request method.';
}

// Send JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
