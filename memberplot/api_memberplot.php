<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../classes/MemberPlot.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'DB connection failed']);
        exit;
    }
    die("DB connection failed: " . $db->connect_error);
}

$mpObj          = new MemberPlot($db);
$action         = $_POST['action'] ?? '';
$uidFromSession = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

if ($action === 'add') {

    $createDate = !empty($_POST['create_date'])
        ? date('Y-m-d H:i:s', strtotime($_POST['create_date']))
        : date('Y-m-d H:i:s');

    $data = [
        'plot_id'     => $_POST['plot_id'] ?? 0,
        'member_id'   => $_POST['member_id'] ?? 0,
        'create_date' => $createDate,
        'noi'         => $_POST['noi'] ?? '',
        'insplan'     => $_POST['insplan'] ?? 0,
        'status'      => $_POST['status'] ?? 'Approved',
        'plotno'      => $_POST['plotno'] ?? '',
        'msno'        => $_POST['msno'] ?? '',
        'uid'         => $uidFromSession,
    ];

    if ($mpObj->create($data)) {
        header("Location: memberplot_list.php?msg=Record+added+successfully");
    } else {
        header("Location: form_memberplot.php?error=Add+failed");
    }
    exit;
}

if ($action === 'update') {

    $createDate = !empty($_POST['create_date'])
        ? date('Y-m-d H:i:s', strtotime($_POST['create_date']))
        : date('Y-m-d H:i:s');

    $data = [
        'id'          => $_POST['id'] ?? 0,
        'plot_id'     => $_POST['plot_id'] ?? 0,
        'member_id'   => $_POST['member_id'] ?? 0,
        'create_date' => $createDate,
        'noi'         => $_POST['noi'] ?? '',
        'insplan'     => $_POST['insplan'] ?? 0,
        'status'      => $_POST['status'] ?? 'Approved',
        'plotno'      => $_POST['plotno'] ?? '',
        'msno'        => $_POST['msno'] ?? '',
        'uid'         => $uidFromSession,
    ];

    if ($mpObj->update($data)) {
        header("Location: memberplot_list.php?msg=Record+updated+successfully");
    } else {
        header("Location: form_memberplot.php?id=" . (int)$data['id'] . "&error=Update+failed");
    }
    exit;
}

if ($action === 'delete') {
    header('Content-Type: application/json');

    $id = $_POST['id'] ?? 0;
    if ($mpObj->delete($id)) {
        echo json_encode(['success' => true, 'message' => 'Record deleted']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Delete failed']);
    }
    exit;
}

// fallback
header("Location: memberplot_list.php?error=Invalid+action");
exit;
