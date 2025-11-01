<?php
// Include the database connection
require_once 'db_connection.php';

// Set the response header to JSON
header('Content-Type: application/json');

// Define the target directory
$targetDir = "images/projects/";

// Create the directory if it doesn't exist
if (!file_exists($targetDir)) {
    // 0777 is permissive, you might want to use 0755 in production
    mkdir($targetDir, 0777, true); 
}

// Initialize the response array
$response = [
    'success' => false,
    'message' => ''
];

// Check if $pdo was successfully created in db_connection.php
if (!isset($pdo)) {
    $response['message'] = 'Database connection failed. Please check server configuration.';
    echo json_encode($response);
    exit;
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Basic Validation ---
    if (empty($_POST['projectName']) || empty($_POST['projectUrl']) || empty($_POST['status'])) {
        $response['message'] = 'Project Name, URL, and Status are required.';
        echo json_encode($response);
        exit;
    }

    if (!isset($_FILES['projectMap']) || $_FILES['projectMap']['error'] != 0) {
        $response['message'] = 'Project Map is required and must be uploaded successfully.';
        echo json_encode($response);
        exit;
    }

    if (!isset($_FILES['projectImages']) || empty($_FILES['projectImages']['name'][0])) {
         $response['message'] = 'At least one Project Image is required.';
         echo json_encode($response);
         exit;
    }

    // --- Process Project Map (Single File) ---
    $mapFile = $_FILES['projectMap'];
    // Sanitize filename and make it unique
    $mapExtension = pathinfo($mapFile['name'], PATHINFO_EXTENSION);
    $mapName = 'map_' . time() . '_' . uniqid() . '.' . $mapExtension;
    $mapTarget = $targetDir . $mapName;
    $mapDbPath = $mapTarget; // Path to store in DB

    if (!move_uploaded_file($mapFile['tmp_name'], $mapTarget)) {
        $response['message'] = 'Failed to upload Project Map.';
        echo json_encode($response);
        exit;
    }

    // --- Process Project Images (Multiple Files) ---
    $images = $_FILES['projectImages'];
    $uploadedImagePaths = []; // Array to store DB paths for images

    foreach ($images['name'] as $key => $name) {
        if ($images['error'][$key] == 0) {
            $tmp_name = $images['tmp_name'][$key];
            
            // Sanitize filename and make it unique
            $imageExtension = pathinfo($name, PATHINFO_EXTENSION);
            $imageName = 'img_' . time() . '_' . uniqid() . '_' . $key . '.' . $imageExtension;
            $imageTarget = $targetDir . $imageName;
            
            if (move_uploaded_file($tmp_name, $imageTarget)) {
                $uploadedImagePaths[] = $imageTarget; // Add path to our array
            } else {
                 $response['message'] = "Failed to upload one or more images ($name).";
                 // We'll fail the whole request if one image fails
                 echo json_encode($response);
                 exit;
            }
        }
    }

    if (empty($uploadedImagePaths)) {
         $response['message'] = 'No project images were successfully uploaded.';
         echo json_encode($response);
         exit;
    }

    // --- Get all POST data ---
    $projectName = trim($_POST['projectName']);
    $projectUrl = trim($_POST['projectUrl']);
    $teaser = trim($_POST['teaser']);
    $projectDetail = trim($_POST['projectDetail']);
    $status = trim($_POST['status']);

    // Convert the array of image paths to a comma-separated string (or JSON) for DB storage
    // Using JSON is more robust if filenames ever contain commas
    $imagePathsString = json_encode($uploadedImagePaths);


    // --- Database Insertion ---
    try {
        // The table name is 'projects'
        // Assumes your table columns are named like this:
        // project_name, project_url, teaser, project_detail, status, project_map, project_images
        $sql = "INSERT INTO projects (project_name, project_url, teaser, project_detail, status, project_map, project_images) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $projectName, 
            $projectUrl, 
            $teaser, 
            $projectDetail, 
            $status, 
            $mapDbPath, 
            $imagePathsString // Storing as a JSON string
        ]);

        // If we get here, the DB insert was successful
        $response['success'] = true;
        $response['message'] = 'Project added successfully! All files uploaded.';

    } catch (PDOException $e) {
        $response['message'] = 'Database error: 'g . $e->getMessage();
    }
    

} else {
    $response['message'] = 'Invalid request method.';
}

// Send the final JSON response
echo json_encode($response);
exit;
?>

