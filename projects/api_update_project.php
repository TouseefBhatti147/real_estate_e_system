<?php
// --- ADD THESE TWO LINES FOR DEBUGGING ---
ini_set('display_errors', 1);
error_reporting(E_ALL);
// -------------------------------------------

// Set header to JSON *before* any output
header('Content-Type: application/json');

// Include (require) our classes
// Make sure these paths are correct for your file structure
require_once '../includes/db_connection.php'; 
require_once '../classes/project.php'; 

// Initialize a default response
$response = [
    'success' => false,
    'message' => 'Invalid request method.'
];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // 1. Get database connection
        $pdo = Database::getConnection();
        
        // 2. Instantiate the service class
        $projectService = new Project($pdo); 

        // 3. Call the new UPDATE method.
        // It will handle its own validation, file uploads, and DB update.
        // It expects 'id' to be sent in the $_POST data.
        $response = $projectService->updateProject($_POST, $_FILES);

    } catch (\PDOException $e) {
        // Catch database *connection* errors
        $response['message'] = 'Database connection failed: ' . $e->getMessage();
    } catch (\Exception $e) {
        // Catch any other unexpected errors
        $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
    }
}

// 4. Send the final JSON response
echo json_encode($response);
exit;
?>

