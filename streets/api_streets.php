<?php
header('Content-Type: application/json');
session_start();

// ✅ DB connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rdlpk_db1";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "DB Connection failed: " . $conn->connect_error]);
    exit;
}

require_once("../classes/Street.php");
$street = new Street($conn);

// ✅ GET → Fetch all streets
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $street->getAll();
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

// ✅ POST → Add / Update / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $data = [
        'id'         => isset($_POST['id']) ? intval($_POST['id']) : null,
        'project_id' => isset($_POST['project_id']) ? intval($_POST['project_id']) : 0,
        'sector_id'  => trim($_POST['sector_id'] ?? ''),
        'street'     => trim($_POST['street'] ?? '')
    ];

    if ($action === 'add') {
        $success = $street->add($data);
        echo json_encode([
            'success' => $success,
            'message' => $success ? '✅ Street added successfully.' : '❌ Failed to add street.'
        ]);
        exit;
    }

    if ($action === 'update') {
        $success = $street->update($data);
        echo json_encode([
            'success' => $success,
            'message' => $success ? '✅ Street updated successfully.' : '❌ Failed to update street.'
        ]);
        exit;
    }

    if ($action === 'delete' && !empty($data['id'])) {
        $success = $street->delete($data['id']);
        echo json_encode([
            'success' => $success,
            'message' => $success ? '✅ Street deleted successfully.' : '❌ Failed to delete street.'
        ]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => '❌ Invalid action or missing data.']);
    exit;
}

echo json_encode(['success' => false, 'message' => '❌ Invalid request method.']);
?>
