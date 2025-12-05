<?php
session_start();
require_once "./admin/includes/db_connection.php"; // your PDO or mysqli connection

// Validate POST
if (!isset($_POST['email'], $_POST['password'])) {
    header("Location: login.php?error=missing");
    exit;
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

try {
    $pdo = Database::getConnection();

    // Fetch member record
    $stmt = $pdo->prepare("SELECT * FROM member WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($member) {

        // If DB password is plain text
        if ($password === $member['password'] || password_verify($password, $member['password'])) {

         $_SESSION["member_loggedin"] = true;
$_SESSION["username"] = $member["username"]; // <-- important



            // Redirect to member dashboard
            header("Location:client-dashboard.php");
            exit;
        }
    }

    // Login failed
    header("Location: login.php?error=invalid");
    exit;

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
