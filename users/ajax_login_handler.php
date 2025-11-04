<?php
// Start output buffering to catch any unintended output from required files (like an accidental 'echo')
ob_start(); 

// Start the session
session_start();

// Include dependencies
require_once '../includes/db_connection.php'; 
require_once '../classes/User.php';

// Prepare a JSON response array, initialized with a generic error
$response = [
    'success' => false,
    'message' => 'An unknown error occurred.'
];

// --- DATABASE CONNECTION FIX ---
// The db_connection.php uses a Database class (Singleton pattern).
// We must call the static method to retrieve the PDO instance and assign it to $pdo.
try {
    $pdo = Database::getConnection();
} catch (\PDOException $e) {
    // If the connection attempt inside Database::getConnection() fails (e.g., wrong credentials), 
    // it throws an exception, which we catch and return as a clean JSON error.
    $response['message'] = 'Database connection failed. Check database credentials or server status.';
    // Clear any output buffer created by the connection process before outputting JSON
    ob_end_clean(); 
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
// -------------------------------

// Process only POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username and password are set
    if (!empty(trim($_POST["username"])) && !empty(trim($_POST["password"]))) {
        
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // Instantiate User class, passing the now-defined $pdo object
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

// Clear any output that occurred before this point (like the echoed SQL query)
$unintended_output = ob_get_clean();

// Check if there was unintended output that needs to be addressed
if (!empty(trim($unintended_output))) {
    // If there was unexpected output, assume the login process was interrupted 
    // or debug code was left behind, and notify the client.
    $response['success'] = false;
    $response['message'] = 'Unexpected server output detected. Debug code may be present.';
    // Note: In a real environment, you might log $unintended_output here for debugging.
}


// Send JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>