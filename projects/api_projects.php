<?php
header('Content-Type: application/json');
session_start();
require_once("../classes/Project.php");

// --- Database connection ---
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rdlpk_db1"; // <-- change this
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "DB Connection failed: ".$conn->connect_error]);
    exit;
}

// --- Initialize Project class ---
$project = new Project($conn);

// --- Handle GET request (for listing projects) ---
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $project->listProjects();
    echo json_encode($result);
    exit;
}

// --- Handle POST request (for add/update actions) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // --- Sanitize input ---
    $data = [
        'id' => isset($_POST['id']) ? intval($_POST['id']) : null,
        'project_name'   => trim($_POST['projectName'] ?? ''),
        'project_url'    => trim($_POST['project_url'] ?? $_POST['url'] ?? ''),
        'teaser'         => trim($_POST['teaser'] ?? ''),
        'project_details'=> trim($_POST['project_details'] ?? ''),
        'status'         => trim($_POST['status'] ?? '')
    ];

   // --- Upload Images ---
$imagePaths = [];
$targetDir = "../assets/img/projects/"; // ✅ trailing slash

if (isset($_FILES['projectImages']) && !empty($_FILES['projectImages']['name'][0])) {
    $totalImages = count($_FILES['projectImages']['name']);
    for ($i = 0; $i < $totalImages; $i++) {
        $tmpName = $_FILES['projectImages']['tmp_name'][$i];
        $name = basename($_FILES['projectImages']['name'][$i]);
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $newName = 'project_img_' . time() . '_' . $i . '.' . $ext;

        if (move_uploaded_file($tmpName, $targetDir . $newName)) {
            $imagePaths[] = "assets/img/projects/" . $newName; // relative path for DB
        }
    }

    if (!empty($imagePaths)) {
        $data['project_images'] = json_encode($imagePaths);
    }
}

// --- Upload Map ---
if (isset($_FILES['projectMap']) && !empty($_FILES['projectMap']['name'])) {
    $tmpName = $_FILES['projectMap']['tmp_name'];
    $name = basename($_FILES['projectMap']['name']);
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    $newName = 'project_map_' . time() . '.' . $ext;

    if (move_uploaded_file($tmpName, $targetDir . $newName)) {
        $data['project_map'] = "assets/img/projects/" . $newName; // relative path for DB
    }
}

    // --- Call Project methods ---
    if ($action === 'add') {
        $result = $project->addProject($data);
        echo json_encode($result);
        exit;
    } elseif ($action === 'update') {
        if (empty($data['id'])) {
            echo json_encode(['success'=>false, 'message'=>'Project ID is missing for update']);
            exit;
        }

        // --- Handle existing images/map ---
        if(!isset($data['project_image'])) unset($data['project_image']); // keep old images if no new upload
        if(!isset($data['project_map'])) unset($data['project_map']); // keep old map if no new upload

        $result = $project->updateProject($data);
        echo json_encode($result);
        exit;
    } else {
        echo json_encode(['success'=>false, 'message'=>'Invalid action']);
        exit;
    }
} else {
    // This case is unlikely now since GET is handled above, but kept as a fallback
    echo json_encode(['success'=>false, 'message'=>'Invalid request method']);
    exit;
}
?>