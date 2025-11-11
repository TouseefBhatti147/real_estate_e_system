<?php
header('Content-Type: application/json');
session_start();

// ✅ Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rdlpk_db1";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "DB Connection failed: " . $conn->connect_error]);
    exit;
}

require_once("../classes/Sector.php");
$sector = new Sector($conn);

// ✅ Handle GET (fetch all sectors)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $sector->getAll();
    $data = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => true, 'data' => []]);
    }
    exit;
}

// ✅ Handle POST (add / update / delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $data = [
        'id'          => isset($_POST['id']) ? intval($_POST['id']) : null,
        'sector_name' => trim($_POST['sector_name'] ?? ''),
        'project_id'  => isset($_POST['project_id']) ? intval($_POST['project_id']) : 0,
        'details'     => trim($_POST['details'] ?? ''),
    ];

    if ($action === 'add') {
        $success = $sector->add($data);
        echo json_encode([
            'success' => $success,
            'message' => $success ? '✅ Sector added successfully.' : '❌ Failed to add sector. ' . $conn->error
        ]);
        exit;
    }

    if ($action === 'update') {
        $success = $sector->update($data);
        echo json_encode([
            'success' => $success,
            'message' => $success ? '✅ Sector updated successfully.' : '❌ Failed to update sector. ' . $conn->error
        ]);
        exit;
    }

    if ($action === 'delete' && !empty($data['id'])) {
        $success = $sector->delete($data['id']);
        echo json_encode([
            'success' => $success,
            'message' => $success ? '✅ Sector deleted successfully.' : '❌ Failed to delete sector. ' . $conn->error
        ]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => '❌ Invalid action or missing data.']);
    exit;
}

// ❌ Invalid method fallback
echo json_encode(['success' => false, 'message' => '❌ Invalid request method.']);
?>
