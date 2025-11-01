<?php
// Start the session to manage user login state
session_start();

// If the user is already logged in, redirect them to the dashboard
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Include config file (for database connection)
// require_once "config.php"; // Uncomment this when you have your config file

// Define variables and initialize with empty values
$username = $password = "";
$login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $login_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $login_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if (empty($login_err)) {
        
        /*
        // --- PROFESSIONAL DATABASE VALIDATION (template) ---
        // This is the professional structure you should implement.
        // Assumes you have a PDO connection object named $pdo in config.php

        // 1. Prepare SQL statement to prevent SQL injection
        $sql = "SELECT id, username, password_hash FROM users WHERE username = :username";
        
        if ($stmt = $pdo->prepare($sql)) {
            // 2. Bind variables
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);
            
            // 3. Attempt to execute
            if ($stmt->execute()) {
                // 4. Check if username exists
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password_hash"];
                        
                        // 5. Verify password using password_verify()
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct.
                            // Session was already started at the top of the file.
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to dashboard page
                            header("location: index.php");
                        } else {
                            // Password is not valid
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist
                    $login_err = "Invalid username or password.";
                }
            } else {
                $login_err = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
        // Close connection
        unset($pdo);
        */

        // --- TEMPORARY PLACEHOLDER LOGIC (Remove this block when DB is ready) ---
        // Kept for immediate testing (admin/password)
        if ($username == "admin" && $password == "password") {
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = 1; // Example user ID
            $_SESSION["username"] = $username;                            
            
            // Redirect user to dashboard page
            header("location: index.php");
        } else {
            // Password is not valid, display a generic error message
            $login_err = "Invalid username or password.";
        }
        // --- END TEMPORARY LOGIC ---

    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | Real Estate E-system</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Login" />

    <!-- These links are from your index.php to maintain style consistency -->
    <link rel="preload" href="./css/adminlte.css" as="style" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" media="print" onload="this.media='all'" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/adminlte.css" />
</head>

<!-- Add .login-page class to the body -->
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary login-page">

    <div class="login-box">
        <div class="login-logo">
            <!-- Logo added based on user request -->
            <img src="assets/img/logo.jpg" alt="Real Estate E-System Logo" style="width: 150px; height: 150px; margin-bottom: 10px; border-radius: 50%; object-fit: cover;">
            <br>
            <a href="index.php"><b>Real Estate</b> E-System</a>
        </div>
        <!-- /.login-logo -->
        <div class="card shadow rounded">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <?php 
                if(!empty($login_err)){
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>">
                        <div class="input-group-text">
                            <span class="bi bi-person-fill"></span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1 mt-3">
                    <a href="forgot-password.php">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.php" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- Scripts -->
    <!-- Note: Only include scripts needed for the login page, if any.
         Bootstrap JS is good for components, but may not be strictly necessary
         for a simple form. Included for consistency. -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="../js/adminlte.js"></script>

</body>
</html>

