<?php
header('Content-Type: application/json');
session_start();

require_once("../classes/InstallmentPlan.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    echo json_encode(["success" => false, "message" => "DB connection failed: " . $db->connect_error]);
    exit;
}

$plan = new InstallmentPlan($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

function esc($db, $value) {
    return "'" . $db->real_escape_string($value ?? '') . "'";
}

if ($action === 'add' || $action === 'update') {
    $id          = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $project_id  = (int)($_POST['project_id'] ?? 0);
    $size_cat_id = (int)($_POST['size_cat_id'] ?? 0);
    $p_type      = $_POST['p_type'] ?? '';
    $description = $_POST['description'] ?? '';
    $tno         = $_POST['tno'] ?? '';
    $tamount     = $_POST['tamount'] ?? '';

    // Build columns/values
    $sets   = [];
    $cols   = [];
    $values = [];

    // Common fields
    if ($action === 'add') {
        $cols  [] = "project_id";
        $values[] = $project_id;
        $cols  [] = "size_cat_id";
        $values[] = $size_cat_id;
        $cols  [] = "p_type";
        $values[] = esc($db, $p_type);
        $cols  [] = "description";
        $values[] = esc($db, $description);
        $cols  [] = "tno";
        $values[] = esc($db, $tno);
        $cols  [] = "tamount";
        $values[] = esc($db, $tamount);
    } else {
        $sets[] = "project_id = {$project_id}";
        $sets[] = "size_cat_id = {$size_cat_id}";
        $sets[] = "p_type = " . esc($db, $p_type);
        $sets[] = "description = " . esc($db, $description);
        $sets[] = "tno = " . esc($db, $tno);
        $sets[] = "tamount = " . esc($db, $tamount);
    }

    // Installment amounts (columns `1` .. `62`)
    for ($i = 1; $i <= 62; $i++) {
        $amountKey = 'amount' . $i;
        $amountVal = $_POST[$amountKey] ?? '';

        if ($action === 'add') {
            $cols[]   = "`{$i}`";
            $values[] = esc($db, $amountVal);
        } else {
            $sets[] = "`{$i}` = " . esc($db, $amountVal);
        }
    }

    // Labels lab1..lab62
    for ($i = 1; $i <= 62; $i++) {
        $labKey = 'lab' . $i;
        $labVal = $_POST[$labKey] ?? '';

        if ($action === 'add') {
            $cols[]   = "lab{$i}";
            $values[] = esc($db, $labVal);
        } else {
            $sets[] = "lab{$i} = " . esc($db, $labVal);
        }
    }

    if ($action === 'add') {
        $sql = "INSERT INTO installment_plan (" . implode(',', $cols) . ") VALUES (" . implode(',', $values) . ")";
        if ($db->query($sql)) {
            echo json_encode(["success" => true, "message" => "Installment plan added successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Add failed: " . $db->error]);
        }
        exit;
    } else {
        if (!$id) {
            echo json_encode(["success" => false, "message" => "Missing plan ID for update"]);
            exit;
        }
        $sql = "UPDATE installment_plan SET " . implode(', ', $sets) . " WHERE id = {$id} LIMIT 1";
        if ($db->query($sql)) {
            echo json_encode(["success" => true, "message" => "Installment plan updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Update failed: " . $db->error]);
        }
        exit;
    }
}

if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    if (!$id) {
        echo json_encode(["success" => false, "message" => "Invalid ID"]);
        exit;
    }
    echo json_encode($plan->delete($id));
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid action"]);
