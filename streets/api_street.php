<?php
session_start();
header('Content-Type: application/json');
require_once("../classes/Street.php");

// DB connection
$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if($db->connect_error){
    echo json_encode(['success'=>false,'message'=>"DB Connection Error: ".$db->connect_error]);
    exit;
}

$streetObj = new Street($db);
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch($action){
    case 'getProjects':
        $projects = $streetObj->getProjects();
        echo json_encode(['success'=>true,'projects'=>$projects]);
        break;

    case 'add':
        $data = [
            'project_id' => $_POST['project_id'],
            'sector_id' => $_POST['sector_id'],
            'street' => $_POST['street'],
            'streets_sorting' => $_POST['streets_sorting']
        ];
        $success = $streetObj->add($data);
        echo json_encode(['success'=>$success,'message'=>$success?'Street added successfully':'Failed to add street']);
        break;

    case 'update':
        $id = $_POST['id'];
        $data = [
            'project_id' => $_POST['project_id'],
            'sector_id' => $_POST['sector_id'],
            'street' => $_POST['street'],
            'streets_sorting' => $_POST['streets_sorting']
        ];
        $success = $streetObj->update($id, $data);
        echo json_encode(['success'=>$success,'message'=>$success?'Street updated successfully':'Failed to update street']);
        break;

    default:
        echo json_encode(['success'=>false,'message'=>'Invalid action']);
        break;
}
