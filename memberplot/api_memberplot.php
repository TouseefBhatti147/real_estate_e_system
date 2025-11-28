<?php
header('Content-Type: application/json');
if (session_status() === PHP_SESSION_NONE) { session_start(); }

require_once("../classes/MemberPlot.php");

// DB
$db = new mysqli("localhost","root","","rdlpk_db1");
if($db->connect_error){
    echo json_encode(['success'=>false,'message'=>'DB connection failed']);
    exit;
}

$mpObj  = new MemberPlot($db);
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add' || $action === 'update') {

    $id         = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $plot_id    = (int)($_POST['plot_id'] ?? 0);
    $member_id  = (int)($_POST['member_id'] ?? 0);
    $createDate = $_POST['create_date'] ?? '';
    $noi        = $_POST['noi'] ?? '1';
    $insplan    = (int)($_POST['insplan'] ?? 0);
    $msno       = $_POST['msno'] ?? '';
    $uid        = isset($_POST['uid']) ? (int)$_POST['uid'] : (int)($_SESSION['user_id'] ?? 0);

    if ($plot_id <= 0 || $member_id <= 0) {
        echo json_encode(['success'=>false,'message'=>'Please select plot and member']);
        exit;
    }

    $data = [
        'id'          => $id,
        'plot_id'     => $plot_id,
        'member_id'   => $member_id,
        'create_date' => $createDate,
        'noi'         => $noi,
        'insplan'     => $insplan,
        'status'      => 'Approved',
        'plotno'      => '',     // keep blank for now
        'msno'        => $msno,
        'uid'         => $uid
    ];

    if ($action === 'add') {
        $ok = $mpObj->add($data);
        echo json_encode([
            'success' => $ok,
            'message' => $ok ? 'Assignment saved successfully' : 'Failed to save assignment'
        ]);
    } else {
        if ($id <= 0) {
            echo json_encode(['success'=>false,'message'=>'Missing ID for update']);
            exit;
        }
        $ok = $mpObj->update($data);
        echo json_encode([
            'success' => $ok,
            'message' => $ok ? 'Assignment updated successfully' : 'Failed to update assignment'
        ]);
    }
    exit;
}

if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success'=>false,'message'=>'Invalid ID']);
        exit;
    }
    $ok = $mpObj->delete($id);
    echo json_encode([
        'success' => $ok,
        'message' => $ok ? 'Assignment deleted' : 'Delete failed'
    ]);
    exit;
}

echo json_encode(['success'=>false,'message'=>'Invalid action']);
