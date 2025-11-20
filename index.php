<?php session_start(); ?>
<!doctype html>
<html lang="en">

<head>
  <style>
    .a {
      text-decoration: none;
    }
  </style>
  <meta charset="utf-8" />
  <title>Real Estate E-system</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
  <meta name="color-scheme" content="light dark" />
  <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
  <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
  <meta name="title" content="Admin | Dashboard" />
  <meta name="author" content="ColorlibHQ" />
  <meta name="description" content="Admin Dashboard..." />
  <meta name="keywords" content="bootstrap 5, admin dashboard, accessible, WCAG" />
  <meta name="supported-color-schemes" content="light dark" />

  <link rel="preload" href="./css/adminlte.css" as="style" />
  <link rel="stylesheet" href="./css/font-family.css" crossorigin="anonymous" media="print" onload="this.media='all'" />
  <link rel="stylesheet" href="./css/overlayscrollbars.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="./css/bootstrap-icons.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="./css/adminlte.css" />
  <link rel="stylesheet" href="./css/apexcharts.css" crossorigin="anonymous" />
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

          <?php include("client-dashboard.php"); ?>

          <!-- ?php include("admin-dashboard.php"); ?> -->

        </div>
      </div>
      <!--end::App Content-->

    </main>


    <!-- Footer -->
    <?php include("includes/footer.php"); ?>
  </div>

  <!-- Scripts -->
  <script src="./js/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
  <script src="./js/popper.min.js" crossorigin="anonymous"></script>
  <script src="./js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="./js/adminlte.js"></script>

  <!-- ApexCharts -->
  <script src="./js/apexcharts.min.js" crossorigin="anonymous"></script>
  <!-- <script>
      const sales_chart_options = {
        series: [
          { name: 'Digital Goods', data: [28, 48, 40, 19, 86, 27, 90] },
          { name: 'Electronics', data: [65, 59, 80, 81, 56, 55, 40] }
        ],
        chart: {
          height: 280,
          type: 'area',
          toolbar: { show: false }
        },
        colors: ['#0d6efd', '#20c997'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: {
          type: 'datetime',
          categories: [
            '2023-01-01', '2023-02-01', '2023-03-01',
            '2023-04-01', '2023-05-01', '2023-06-01',
            '2023-07-01'
          ]
        },
        tooltip: {
          x: { format: 'MMMM yyyy' }
        }
      };

      const sales_chart = new ApexCharts(document.querySelector('#sales-chart'), sales_chart_options);
      sales_chart.render();
    </script> -->
</body>

</html>