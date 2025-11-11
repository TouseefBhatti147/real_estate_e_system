<?php
session_start();
header('Content-Type: application/json');

require_once("../classes/Project.php");

// --- Database connection ---
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rdlpk_db1";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success'=>false,'message'=>'DB Connection failed: '.$conn->connect_error]);
    exit;
}

$projectObj = new Project($conn);

// --- Handle POST actions ---
$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? 0;

// Helper function to upload file and return relative path
function uploadFile($fileInput, $uploadDir='assets/img/projects/') {
    if(!isset($_FILES[$fileInput])) return '';
    $files = $_FILES[$fileInput];

    $uploadedPaths = [];

    // Multiple files
    if(is_array($files['name'])) {
        foreach($files['name'] as $key => $name) {
            if($files['error'][$key] === UPLOAD_ERR_OK) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = 'project_img_'.time().'_'.$key.'.'.$ext;
                $destination = '../'.$uploadDir.$newName;
                if(!is_dir('../'.$uploadDir)) mkdir('../'.$uploadDir,0777,true);
                if(move_uploaded_file($files['tmp_name'][$key], $destination)) {
                    $uploadedPaths[] = $uploadDir.$newName;
                }
            }
        }
    } else { // Single file
        if($files['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($files['name'], PATHINFO_EXTENSION);
            $newName = 'project_map_'.time().'.'.$ext;
            $destination = '../'.$uploadDir.$newName;
            if(!is_dir('../'.$uploadDir)) mkdir('../'.$uploadDir,0777,true);
            if(move_uploaded_file($files['tmp_name'], $destination)) {
                $uploadedPaths[] = $uploadDir.$newName;
            }
        }
    }
    return $uploadedPaths;
}

switch($action) {
    // -------------------
    // Add Project
    // -------------------
    case 'add':
        $project_images = uploadFile('projectImages');
        $project_map    = uploadFile('projectMap');

        $data = [
            'project_name'    => $_POST['projectName'] ?? '',
            'teaser'          => $_POST['teaser'] ?? '',
            'project_url'     => $_POST['project_url'] ?? '',
            'project_details' => $_POST['project_details'] ?? '',
            'status'          => $_POST['status'] ?? 0,
            'project_images'  => json_encode($project_images),
            'project_map'     => $project_map[0] ?? ''
        ];

        $result = $projectObj->addProject($data);
        echo json_encode($result);
        break;

    // -------------------
    // Update Project
    // -------------------
    case 'update':
        $id = intval($id);
        if($id <= 0) {
            echo json_encode(['success'=>false,'message'=>'Invalid Project ID']);
            exit;
        }

        // Get current project data
        $current = $projectObj->getProject($id);
        if(!$current['success']) {
            echo json_encode(['success'=>false,'message'=>'Project not found']);
            exit;
        }

        // Upload new images/maps if provided
        $new_images = uploadFile('projectImages');
        $new_map    = uploadFile('projectMap');

        // If new images uploaded, delete old ones
        if(!empty($new_images)) {
            $oldImages = json_decode($current['data']['project_images'], true);
            if(is_array($oldImages)) {
                foreach($oldImages as $img) {
                    $path = '../'.$img;
                    if(file_exists($path)) unlink($path);
                }
            }
            $project_images = json_encode($new_images);
        } else {
            $project_images = $current['data']['project_images'];
        }

        // If new map uploaded, delete old
        if(!empty($new_map)) {
            $oldMap = $current['data']['project_map'];
            if($oldMap && file_exists('../'.$oldMap)) unlink('../'.$oldMap);
            $project_map = $new_map[0];
        } else {
            $project_map = $current['data']['project_map'];
        }

        $data = [
            'project_name'    => $_POST['projectName'] ?? '',
            'teaser'          => $_POST['teaser'] ?? '',
            'project_url'     => $_POST['project_url'] ?? '',
            'project_details' => $_POST['project_details'] ?? '',
            'status'          => $_POST['status'] ?? 0,
            'project_images'  => $project_images,
            'project_map'     => $project_map
        ];

        $result = $projectObj->updateProject($id, $data);

        // Redirect to projects.php on success
        if($result['success']) {
            echo json_encode(['success'=>true,'message'=>$result['message'],'redirect'=>'projects.php']);
        } else {
            echo json_encode($result);
        }

        break;

    // -------------------
    // Delete Project
    // -------------------
    default:
        // Check if id sent via POST (delete request)
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($id)) {
            $result = $projectObj->deleteProject($id);
            echo json_encode($result);
        } else {
            // Fetch all projects
            $result = $projectObj->getAllProjects();
            echo json_encode($result);
        }
        break;
}
