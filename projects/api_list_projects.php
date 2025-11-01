<?php
// Set header to JSON *before* any output
header('Content-Type: application/json');

// Include (require) our classes

require_once '../includes/db_connection.php'; 
require_once '../classes/project.php'; 

// Initialize a default response
$response = [
    'success' => false,
    'message' => 'An error occurred.',
    'data' => []
];

try {
    // 1. Get database connection
    $pdo = Database::getConnection();
    
    // 2. Instantiate the service class
    $projectService = new Project($pdo);

    // 3. Call the method to get all projects
    $response = $projectService->getAllProjects(); // This will return ['success' => true, 'data' => [...]]

} catch (\PDOException $e) {
    // Catch database *connection* errors
    $response['message'] = 'Database connection failed: ' . $e->getMessage();
} catch (\Exception $e) {
    // Catch any other unexpected errors
    $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
}

// 4. Send the final JSON response
echo json_encode($response);
exit;
?>
