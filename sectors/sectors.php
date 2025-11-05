<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Sectors List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Sectors List" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="Admin Dashboard..." />
    <meta name="keywords" content="bootstrap 5, admin dashboard, accessible, WCAG" />
    <meta name="supported-color-schemes" content="light dark" />

    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/adminlte.css" />
  </head>

  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <?php require("../includes/header.php");?>

      <!-- Sidebar -->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="..\index.php" class="brand-link">
          
            <span class="brand-text fw-light">Real Estate E-System</span>
          </a>
        </div>
        <?php include("../includes/sidebar.php"); ?>
      </aside>

      <!-- Main Content -->
      <main class="app-main">
        <!-- App Content Header -->
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Sectors List</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Sectors List</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- App Content -->
        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header d-flex align-items-center">
                    <h3 class="card-title mb-0">Sectors</h3>
                    <a href="add_sector.php" class="btn btn-success ms-auto">Add Sector</a>
                  </div>
                  <div class="card-body">
                    <!-- Add filter controls here if needed -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>Id</th>
                            <th>Project Name</th>
                            <th>Block Name</th>
                            <th>Sector Name</th>
                            <th>Details</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Royal Orchard Multan</td>
                                <td>General Block</td>
                                <td>...</td>
                                <td>2014-05-08 08:53:50</td>
                                <td>
                                    <a href="update_sector.php?id=1" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Royal Orchard Multan</td>
                                <td>General Block</td>
                                <td>Block-A</td>
                                <td>2016-03-15 08:53:50</td>
                                <td>
                                    <a href="update_sector.php?id=2" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Royal Orchard Multan</td>
                                <td>General Block</td>
                                <td>Block-B</td>
                                <td>2016-03-15 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=3" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Royal Orchard Multan</td>
                                <td>General Block</td>
                                <td>Block-C</td>
                                <td>2016-03-15 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=4" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Royal Orchard Multan</td>
                                <td>General Block</td>
                                <td>Block-D</td>
                                <td>2016-03-15 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=5" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Royal Orchard Multan</td>
                                <td>General Block</td>
                                <td>Block-E</td>
                                <td>2016-03-15 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=6" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Royal Orchard Multan</td>
                                <td>General Block</td>
                                <td>Block-F</td>
                                <td>2016-03-15 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=7" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Royal Orchard Multan</td>
                                <td>General Block</td>
                                <td>Block-G</td>
                                <td>0000-00-00 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=8" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Royal Orchard Multan</td>
                                <td>General Block</td>
                                <td>Down Town</td>
                                <td>0000-00-00 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=9" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Royal Orchard Multan</td>
                                <td>Overseas Block</td>
                                <td>Overseas Block</td>
                                <td>0000-00-00 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=10" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Royal Orchard Multan</td>
                                <td>Executive Block</td>
                                <td>Executive Block</td>
                                <td>0000-00-00 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=11" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>Royal Orchard-II, Multan</td>
                                <td>General Block</td>
                                <td>...</td>
                                <td>0000-00-00 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=12" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>Royal Orchard-II, Multan</td>
                                <td>General Block</td>
                                <td>Block-A</td>
                                <td>0000-00-00 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=13" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>Royal Orchard Sargodha</td>
                                <td>General Block</td>
                                <td>...</td>
                                <td>0000-00-00 00:00:00</td>
                                <td>
                                    <a href="update_sector.php?id=14" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                                L</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                  </div>
                   <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-end">
                      <li class="page-item"><a class="page-link" href="#">«</a></li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

     <?php include("../includes/footer.php"); ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../js/adminlte.js"></script>
  </body>
</html>
