<?php
session_start();

// Only logged-in MEMBERS can access
if (!isset($_SESSION["member_loggedin"]) || $_SESSION["member_loggedin"] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Client Dashboard | Real Estate E-system</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="admin/css/adminlte.css">
<link rel="stylesheet" href="admin/css/font-family.css">
<link rel="stylesheet" href="admin/css/overlayscrollbars.min.css">
<link rel="stylesheet" href="admin/css/bootstrap-icons.min.css">
<link rel="stylesheet" href="admin/css/apexcharts.css">

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- Header (SAME ADMIN HEADER) -->
    <?php include("./header-client.php"); ?>

    <!-- Sidebar (SAME ADMIN SIDEBAR) -->
    <aside class="app-sidebar bg-light-subtle shadow" data-bs-theme="light">
        <div class="sidebar-brand">
            <a href="client-dashboard.php" class="brand-link">
                <span class="brand-text fw-light">Client Dashboard</span>
            </a>
        </div>

        <?php include("./sidebar-client.php"); ?>
    </aside>

    <!-- Main Content -->
    <main class="app-main">

        <!-- Page Header -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Client Dashboard</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="app-content">
            <div class="container-fluid">

                <!-- INFO BOXES -->
                <div class="row">

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-primary shadow-sm">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Welcome</span>
                                <span class="info-box-number">
                                    <?php echo $_SESSION["username"]; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                   


                </div>

                <!-- TABLE -->
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title">My Property Bookings</h3>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Project Name</th>
                                    <th>Plot No</th>
                                    <th>Status</th>
                                    <th>Booking Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="align-middle">
                                    <td>1</td>
                                    <td>Dream Valley</td>
                                    <td>Plot #123</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>12 Nov 2024</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <!-- Footer -->
    <?php include("admin/includes/footer.php"); ?>

</div>

<!-- JS Files -->
  <?php include("admin/includes/scripts.php"); ?>


</body>
</html>
