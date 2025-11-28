<?php
header('Content-Type: application/json');

$db = new mysqli("localhost","root","","rdlpk_db1");
if($db->connect_error){
    echo json_encode(["success"=>false,"message"=>"DB connection failed"]);
    exit;
}

$id = $_GET['id'] ?? '';
if(!$id){
    echo json_encode(["success"=>false,"message"=>"Missing Plot ID"]);
    exit;
}

$sql = "SELECT id, plot_size, size_cat_id, category_id   /* category_id ADDED */
        FROM plots
        WHERE id = ? LIMIT 1";

$stmt = $db->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows > 0){
    echo json_encode(["success"=>true,"data"=>$res->fetch_assoc()]);
} else {
    echo json_encode(["success"=>false,"message"=>"Plot not found"]);
}
exit;
?>
