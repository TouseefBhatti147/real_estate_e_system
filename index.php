<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Real Estate E-system</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="preload" href="./css/adminlte.css" as="style" />
    <link rel="stylesheet" href="./css/font-family.css" />
    <link rel="stylesheet" href="./css/overlayscrollbars.min.css" />
    <link rel="stylesheet" href="./css/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="./css/adminlte.css" />
    <link rel="stylesheet" href="./css/apexcharts.css" />
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header -->
        <?php require("includes/header.php"); ?>

        <!-- Sidebar -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="index.php" class="brand-link">
                    <span class="brand-text fw-light">Real Estate E-System</span>
                </a>
            </div>
            <?php include("includes/sidebar.php"); ?>
        </aside>

        <!-- Main Content -->
        <main class="app-main">

            <!-- Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
           
        </main>

        <?php include("includes/footer.php"); ?>
    </div>

    <script src="./js/overlayscrollbars.browser.es6.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/adminlte.js"></script>
    <script src="./js/apexcharts.min.js"></script>

</body>
</html>

  <title>Real Estate E-system</title>
  <meta name="description" content="Admin Dashboard..." />
  <?php include("includes/headerLinks.php"); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">
    <!-- Header -->
    <?php require("includes/header.php"); ?>

    <!-- Sidebar  client = bg-light-subtle, data-bs-theme= light , dark = bg-body-secondary , data-bs-theme= dark -->
    <aside class="app-sidebar  bg-light-subtle shadow" data-bs-theme="light">
      <div class="sidebar-brand">
        <a href="index.php" class="brand-link">
          <span class="brand-text fw-light">Real Estate E-System</span>
        </a>
      </div>
      <?php include("includes/sidebar.php"); ?>
    </aside>

    <!-- Main Content -->
    <main class="app-main">

      <!--begin::App Content Header-->
      <div class="app-content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Dashboard</h3>
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
      <!--end::App Content Header-->

      <!--begin::App Content-->
      <div class="app-content">
        <div class="container-fluid">

          <?php // include("client-dashboard.php"); ?> 
 <?php include("admin-dashboard.php"); ?> 

        </div>
      </div>
      <!--end::App Content-->

    </main>


    <!-- Footer -->
    <?php include("includes/footer.php"); ?>
  </div>

  <?php include("includes/scripts.php"); ?>

</body>

</html>
