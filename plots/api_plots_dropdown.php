<?php
header('Content-Type: application/json');

$db = new mysqli("localhost","root","","rdlpk_db1");
if($db->connect_error){
    echo json_encode(['success'=>false]);
    exit;
}

$pid = $_GET['project_id'];
$sid = $_GET['sector_id'];
$stid= $_GET['street_id'];

$sql = "SELECT id, plot_detail_address, plot_size 
        FROM plots 
        WHERE project_id='$pid'
        AND sector_id='$sid'
        AND street_id='$stid'
        AND (status='' OR status IS NULL)";

$res = $db->query($sql);

$data=[];
while($r=$res->fetch_assoc()) $data[]=$r;

echo json_encode(["success"=>true,"data"=>$data]);
