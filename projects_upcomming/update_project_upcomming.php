<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Update Upcoming Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Update Upcoming Project" />
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
                <h3 class="mb-0">Update Upcoming Project</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="projects_upcomming.php">Upcoming Project List</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Update Upcoming Project</li>
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
                  <div class="card-header">
                    <h3 class="card-title mb-0">Update Upcoming Project Details</h3>
                  </div>
                  <div class="card-body">
                    <form action="#" method="post" enctype="multipart/form-data">
                      <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="projectName" value="Future Living Towers" required>
                      </div>
                      <div class="mb-3">
                        <label for="projectUrl" class="form-label">Project URL <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="projectUrl" value="http://futureliving.pk" required>
                      </div>
                      <div class="mb-3">
                        <label for="teaser" class="form-label">Teaser <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="teaser" value="Luxury apartments in the sky" required>
                      </div>
                      <div class="mb-3">
                        <label for="projectDetail" class="form-label">Project Detail <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="projectDetail" rows="3" required>A new standard in urban living, coming soon.</textarea>
                      </div>
                      <div class="mb-3">
                        <label for="projectImages" class="form-label">Select Images</label>
                        <input class="form-control" type="file" id="projectImages" multiple>
                        <small class="form-text text-muted">Current images will be retained if no new images are uploaded.</small>
                      </div>
                       <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select id="status" class="form-select" required>
                          <option disabled value="">Select</option>
                          <option selected>Active</option>
                          <option>inActive</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="projectMap" class="form-label">Project Map</label>
                        <input class="form-control" type="file" id="projectMap">
                         <small class="form-text text-muted">Current map will be retained if no new map is uploaded.</small>
                      </div>
                    </form>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Update Upcoming Project</button>
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

