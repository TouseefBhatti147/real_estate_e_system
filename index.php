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
            <div class="app-content">
                <div class="container-fluid">

                    <!-- Reports -->
                    <div class="section-title">Reports</div>
                    <hr />
                    <div class="row g-3">

                        <div class="col-md-3">
                            <a class="a" href="reports/plots_report.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-tag-fill"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Plots Report</span>
                                        <span class="info-box-number">5,200</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="reports/receipt_report.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-receipt-cutoff"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Receipt Reports</span>
                                        <span class="info-box-number">92,050</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <!-- Add New -->
                    <div class="section-title mt-4">Add New</div>
                    <hr />
                    <div class="row g-3">

                        <div class="col-md-3">
                            <a class="a" href="streets/streets.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-signpost-2-fill"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Streets</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="projects/projects.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-building"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Projects</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="categories/categories.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-list-ul"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Categories</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="charges/charges.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-cash-coin"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Charges</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="plot_sizes/plot_size_list.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-table"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Plot Sizes</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="installment_plan/installment_plan_list.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-calendar2-week"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Installment Plan</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="sectors/sectors.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-diagram-3-fill"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Sectors</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="property_type/property_types.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-house-fill"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Property Types</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <!-- Media -->
                    <div class="section-title mt-4">Media & Website</div>
                    <hr />
                    <div class="row g-3">

                        <div class="col-md-3">
                            <a class="a" href="sliders/slider_list.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-sliders"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Sliders</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="sales_centers/sale_center_list.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-shop"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Sales Centers</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="news/news_list.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-newspaper"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">News</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="countries/country_list.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-globe"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Countries</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="cities/city_list.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-building"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Cities</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <!-- Users -->
                    <div class="section-title mt-4">Users / Members</div>
                    <hr />
                    <div class="row g-3">

                        <div class="col-md-3">
                            <a class="a" href="members/member_list.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-people-fill"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Member Directory</span>
                                        <span class="info-box-number">8,526</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="a" href="users/user_list.php">
                                <div class="info-box">
                                    <span class="info-box-icon"><i class="bi bi-person-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Users</span>
                                        <span class="info-box-number">50</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <!-- Map Management -->
                    <div class="section-title mt-4">Land & Society Map</div>
                    <hr />
                    <div class="row g-3">

                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon"><i class="bi bi-map"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">View Map</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

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
=======

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

          <!--start::Report Section-->
          <div class="col-12">
            <div class="callout callout-info">
              Reports
            </div>
          </div>
          <hr />

          <div class="row">
            <div class="col-md-3">
              <a class="a" href="reports/plots_report.php">
                <div class="info-box mb-3 text-bg-warning">
                  <span class="info-box-icon"><i class="bi bi-tag-fill"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Plots Report</span>
                    <span class="info-box-number">5,200</span>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-3">
              <a class="a" href="reports/receipt_report.php">

                <div class="info-box mb-3 text-bg-success">
                  <span class="info-box-icon"><i class="bi bi-heart-fill"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Receipt Reports</span>
                    <span class="info-box-number">92,050</span>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <!--end::Report Section-->


          <!--start:Add New section-->
          <div class="col-12 mt-4">
            <div class="callout callout-info">
              Add New
            </div>
          </div>
          <hr />

          <div class="row">
            <a href="streets/streets.php">

              <div class="col-md-3">
                <div class="info-box mb-3 text-bg-primary">
                  <span class="info-box-icon"><i class="bi bi-signpost-2-fill"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Streets</span>
                  </div>
                </div>
            </a>
          </div>



          <div class="col-md-3"> <a href="projects/projects.php">
              <div class="info-box mb-3 text-bg-warning">
                <span class="info-box-icon"><i class="bi bi-building"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Projects</span>
                </div>
              </div>
            </a>
          </div>







          <div class="col-md-3">
            <a href="categories/categories.php">
              <div class="info-box mb-3 text-bg-dark">
                <span class="info-box-icon"><i class="bi bi-list-ul"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Categories List</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3">
            <a href="charges/charges.php">
              <div class="info-box mb-3 text-bg-primary">
                <span class="info-box-icon"><i class="bi bi-cash-coin"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Charges List</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3">
            <a href="plot_sizes/plot_size_list.php">
              <div class="info-box mb-3 text-bg-secondary">
                <span class="info-box-icon"><i class="bi bi-layout-text-sidebar-reverse"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Plot Size Categories</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3">
            <a href="installment_plan/installment_plan_list.php">

              <div class="info-box mb-3 text-bg-warning">
                <span class="info-box-icon"><i class="bi bi-calendar2-week"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Installment Plan</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3">
            <a href="sectors/sectors.php">
              <div class="info-box mb-3 text-bg-success">
                <span class="info-box-icon"><i class="bi bi-diagram-3-fill"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Sectors</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3">
            <a href="property_type/property_types.php">
              <div class="info-box mb-3 text-bg-danger">
                <span class="info-box-icon"><i class="bi bi-house-door-fill"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Property Type</span>
                </div>
              </div>
            </a>
          </div>


        </div>
        <!--end:Add New section-->
        <!--start:Media & Website section-->
        <div class="col-12 mt-4">
          <div class="callout callout-info">
            Media & Website
          </div>
        </div>
        <hr />

        <div class="row">


          <div class="col-md-3">
            <a href="sliders/slider_list.php">

              <div class="info-box mb-3 text-bg-warning">
                <span class="info-box-icon"><i class="bi bi-sliders"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Slider</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3">
            <a href="sales_centers/sale_center_list.php">

              <div class="info-box mb-3 text-bg-danger">
                <span class="info-box-icon"><i class="bi bi-shop"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Sales Center</span>
                </div>
              </div>
            </a>
          </div>



          <div class="col-md-3">
            <a href="news/news_list.php">
              <div class="info-box mb-3 text-bg-secondary">
                <span class="info-box-icon"><i class="bi bi-newspaper"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">News</span>
                </div>
              </div>
            </a>
          </div>





          <div class="col-md-3">
            <a href="countries/country_list.php">
              <div class="info-box mb-3 text-bg-danger">
                <span class="info-box-icon"><i class="bi bi-globe-americas"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Manage Country</span>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-3">
            <a href="cities/city_list.php">
              <div class="info-box mb-3 text-bg-danger">
                <span class="info-box-icon"><i class="bi bi-buildings"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Manage City</span>
                </div>
              </div>
            </a>
          </div>

        </div>
        <!--end:Media & Website section-->
        <!--start:Users / Members section-->
        <div class="col-12 mt-4">
          <div class="callout callout-info">Users / Members</div>
        </div>
        <hr />

        <div class="row">

          <div class="col-md-3">
            <a href="members/member_list.php">

              <div class="info-box mb-3 text-bg-success">
                <span class="info-box-icon"><i class="bi bi-people-fill"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Member's Directory</span>
                  <span class="info-box-number">8,526</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3">
            <a href="users/user_list.php">

              <div class="info-box mb-3 text-bg-danger">
                <span class="info-box-icon"><i class="bi bi-person-fill"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">User</span>
                  <span class="info-box-number">50</span>
                </div>
              </div>
            </a>
          </div>


        </div>
        <!--end:Users / Members section-->

        <!--start:Security, Reporting, Balloting, Recovery section-->
        <div class="col-12 mt-4">
          <div class="callout callout-info">Security, Reporting, Balloting, Recovery</div>
        </div>
        <hr />

        <div class="row">






          <div class="col-md-3">
            <div class="info-box mb-3 text-bg-warning">
              <span class="info-box-icon"><i class="bi bi-wallet2"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Finance System</span>
              </div>
            </div>
          </div>


          <!--end:Security, Reporting, Balloting, Recovery section-->

          <!--start:Land and Society Map Management section-->
          <div class="col-12 mt-4">
            <div class="callout callout-info">Land and Society Map Management</div>
          </div>
          <hr />

          <div class="row">
            <div class="col-md-3">
              <div class="info-box mb-3 text-bg-success">
                <span class="info-box-icon"><i class="bi bi-map-fill"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">View Map</span>
                </div>
              </div>
            </div>


            <!--end:Land and Society Map Management section-->

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
  <script>
    const sales_chart_options = {
      series: [{
          name: 'Digital Goods',
          data: [28, 48, 40, 19, 86, 27, 90]
        },
        {
          name: 'Electronics',
          data: [65, 59, 80, 81, 56, 55, 40]
        }
      ],
      chart: {
        height: 280,
        type: 'area',
        toolbar: {
          show: false
        }
      },
      colors: ['#0d6efd', '#20c997'],
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth'
      },
      xaxis: {
        type: 'datetime',
        categories: [
          '2023-01-01', '2023-02-01', '2023-03-01',
          '2023-04-01', '2023-05-01', '2023-06-01',
          '2023-07-01'
        ]
      },
      tooltip: {
        x: {
          format: 'MMMM yyyy'
        }
      }
    };

    const sales_chart = new ApexCharts(document.querySelector('#sales-chart'), sales_chart_options);
    sales_chart.render();
  </script>
</body>

</html>
>>>>>>> beac359d2aa8162e1f3bc98f244754dff212f8fa
