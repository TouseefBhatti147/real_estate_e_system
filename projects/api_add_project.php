<?php
// Set header to JSON *before* any output
header('Content-Type: application/json');
// Include (require) our new classes
// Make sure these paths are correct for your file structure
require_once '../includes/db_connection.php'; 
require_once '../classes/project.php'; 
// Corrected from 'ProjectService.php'
// If your path is different, use that, e.g.:
// require_once '../classess/project.php'; 

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
        
        // 2. Instantiate the service class, passing in the connection
        // Your class is named 'Project', not 'ProjectService'
        $projectService = new Project($pdo); // Corrected from new ProjectService($pdo)

        // 3. Call the one method to do all the work.
        // It will return the success/error $response array.
        $response = $projectService->createProject($_POST, $_FILES);

    } catch (\PDOException $e) {
        // Catch database *connection* errors from Database::getConnection()
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
