<?php session_start(); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Streets List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Streets List" />
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
            <img
              src="./assets/img/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
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
                <h3 class="mb-0">Streets List</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Streets List</li>
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
                    <h3 class="card-title mb-0">Streets List</h3>
                    <a href="add_street.php" class="btn btn-success ms-auto">Add Street</a>
                  </div>
                  <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                      <div class="col-md-3">
                        <label for="projectSelect" class="form-label">Select Project</label>
                        <select id="projectSelect" class="form-select">
                          <option selected>All Projects</option>
                          <option>Royal Orchard Multan</option>
                          <option>Royal Orchard-II, Multan</option>
                          <option>Royal Orchard Sargodha</option>
                          <option>Royal Orchard Sahiwal</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="blockSelect" class="form-label">Select Block</label>
                        <select id="blockSelect" class="form-select">
                          <option selected>All Blocks</option>
                          <option>General Block</option>
                          <option>Overseas Block</option>
                          <option>Executive Block</option>
                        </select>
                      </div>
                       <div class="col-md-3">
                        <label for="sectorSelect" class="form-label">Select Sector</label>
                        <select id="sectorSelect" class="form-select">
                          <option selected>All Sectors</option>
                          <option>Block-A</option>
                          <option>Block-B</option>
                          <option>Block-C</option>
                        </select>
                      </div>
                      <div class="col-md-3 align-self-end">
                         <button type="button" class="btn btn-primary w-100">Search</button>
                      </div>
                    </div>

                    <!-- Report Table -->
                    <table class="table table-bordered table-striped" role="table">
                      <thead>
                        <tr>
                          <th style="width: 10px" scope="col">Id</th>
                          <th scope="col">Project Name</th>
                          <th scope="col">Block Name</th>
                          <th scope="col">Sector Name</th>
                          <th scope="col">Street Name</th>
                          <th scope="col">Create Date</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="align-middle">
                          <td>320</td>
                          <td>Royal Orchard Sargodha</td>
                          <td>General Block</td>
                          <td>Block-B</td>
                          <td>- - - (To be removed) - - -</td>
                          <td>2022-08-15 00:00:00</td>
 <td>
                            <a href="#" class="btn btn-sm btn-info me-1"><i class="bi bi-info-circle-fill"></i></a>
                            <a href="update_street.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>                        </tr>
                        <tr class="align-middle">
                          <td>114</td>
                          <td>Royal Orchard-II, Multan</td>
                          <td>General Block</td>
                          <td>.... . .</td>
                          <td></td>
                          <td>2016-04-29 00:00:00</td>
 <td>
                            <a href="#" class="btn btn-sm btn-info me-1"><i class="bi bi-info-circle-fill"></i></a>
                            <a href="update_project.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>                        </tr>
                        <tr class="align-middle">
                          <td>290</td>
                          <td>Royal Orchard Multan</td>
                          <td>Overseas Block</td>
                          <td>...</td>
                           <td></td>
                          <td>2022-03-11 00:00:00</td>
 <td>
                            <a href="#" class="btn btn-sm btn-info me-1"><i class="bi bi-info-circle-fill"></i></a>
                            <a href="update_project.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>                        </tr>
                        <tr class="align-middle">
                          <td>1</td>
                          <td>Royal Orchard Multan</td>
                          <td>General Block</td>
                          <td>......</td>
                           <td></td>
                          <td>2014-11-10 11:20:13</td>
 <td>
                            <a href="#" class="btn btn-sm btn-info me-1"><i class="bi bi-info-circle-fill"></i></a>
                            <a href="update_project.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>                        </tr>
                        <tr class="align-middle">
                          <td>289</td>
                          <td>Royal Orchard Multan</td>
                          <td>Overseas Block</td>
                          <td>Block-A01</td>
                          <td></td>
                          <td>2022-03-11 00:00:00</td>
                            <td>
                            <a href="#" class="btn btn-sm btn-info me-1"><i class="bi bi-info-circle-fill"></i></a>
                            <a href="update_project.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>                        </tr>
                        <tr class="align-middle">
                          <td>176</td>
                          <td>Royal Orchard Sahiwal</td>
                          <td>General Block</td>
                          <td>Block-B</td>
                          <td>Access Road - 01</td>
                          <td>2016-11-03 00:00:00</td>
                                <td>
                            <a href="#" class="btn btn-sm btn-info me-1"><i class="bi bi-info-circle-fill"></i></a>
                            <a href="update_project.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>                        </tr>
                         <tr class="align-middle">
                          <td>196</td>
                          <td>Royal Orchard Sargodha</td>
                          <td>General Block</td>
                          <td>Block-A</td>
                          <td>Iqbal Boulevard</td>
                          <td>2016-11-18 00:00:00</td>
 <td>
                            <a href="#" class="btn btn-sm btn-info me-1"><i class="bi bi-info-circle-fill"></i></a>
                            <a href="update_project.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>                        </tr>
                         <tr class="align-middle">
                          <td>21</td>
                          <td>Royal Orchard Multan</td>
                          <td>General Block</td>
                          <td>Block-A</td>
                          <td>Jinnah Boulevard</td>
                          <td>2016-03-15 00:00:00</td>
 <td>
                            <a href="#" class="btn btn-sm btn-info me-1"><i class="bi bi-info-circle-fill"></i></a>
                            <a href="update_project.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>                        </tr>
                         <tr class="align-middle">
                          <td>225</td>
                          <td>Royal Orchard Sargodha</td>
                          <td>General Block</td>
                          <td>Block-C</td>
                          <td>Lane # 01</td>
                          <td>2016-11-18 00:00:00</td>
 <td>
                            <a href="#" class="btn btn-sm btn-info me-1"><i class="bi bi-info-circle-fill"></i></a>
                            <a href="update_project.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>                        </tr>
                        <tr class="align-middle">
                          <td>8</td>
                          <td>Royal Orchard Multan</td>
                          <td>General Block</td>
                          <td>Block-A</td>
                          <td>Lane # 01</td>
                          <td>2016-03-15 00:00:00</td>
                           <td>
                            <a href="#" class="btn btn-sm btn-info me-1"><i class="bi bi-info-circle-fill"></i></a>
                            <a href="update_project.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-end">
                      <li class="page-item"><a class="page-link" href="#">«</a></li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
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