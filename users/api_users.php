<?php
header("Content-Type: text/html; charset=UTF-8");

require_once("../classes/User.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
$userObj = new User($db);

$action = $_POST['action'] ?? "";

$uploadDir = "../../assets/img/user_images/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$picName = "";
if (isset($_FILES['pic']) && !empty($_FILES['pic']['name'])) {
    $ext = pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION);
    $picName = "user_" . time() . "." . $ext;
    move_uploaded_file($_FILES['pic']['tmp_name'], $uploadDir . $picName);
}

switch ($action) {

    // ----------------------- ADD -----------------------
    case "add":
        $data = $_POST;
        $data['pic'] = $picName;
        $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $ok = $userObj->create($data);

        if ($ok) {
            header("Location: user_list.php?msg=added");
        } else {
            header("Location: form_user.php?error=add_failed");
        }
        exit;


    // ----------------------- UPDATE -----------------------
    case "update":
        $data = $_POST;
        $data['pic'] = $picName ?: $_POST['old_pic'];

        $ok = $userObj->update($data);

        if ($ok) {
            header("Location: user_list.php?msg=updated");
        } else {
            header("Location: form_user.php?id=".$_POST['id']."&error=update_failed");
        }
        exit;


    // ----------------------- DELETE (AJAX) -----------------------
    case "delete":
        $ok = $userObj->delete($_POST['id']);

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "User deleted successfully" : "Delete failed"
        ]);
        exit;
}
