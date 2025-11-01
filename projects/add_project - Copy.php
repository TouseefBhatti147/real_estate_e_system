<?php
// Check if the request method is POST (i.e., the form is being submitted via AJAX)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Database Connection Logic (formerly db_connection.php) ---
    $host = 'localhost';
    $dbname = 'your_database_name'; // <-- UPDATE THIS
    $username = 'your_username';     // <-- UPDATE THIS
    $password = 'your_password';     // <-- UPDATE THIS
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMU_PREPARES   => false,
    ];

    $pdo = null;
    try {
         $pdo = new PDO($dsn, $username, $password, $options);
    } catch (\PDOException $e) {
         // Connection fails, $pdo remains null
    }
    
    // --- Upload Logic (formerly upload_project.php) ---

    // Set the response header to JSON
    header('Content-Type: application/json');

    // Define the target directory
    $targetDir = "images/projects/";

    // Create the directory if it doesn't exist
    if (!file_exists($targetDir)) {
        // 0777 is permissive, you might want to use 0755 in production
        mkdir($targetDir, 0777, true); 
    }

    // Initialize the response array
    $response = [
        'success' => false,
        'message' => ''
    ];

    // Check if $pdo was successfully created
    if (!$pdo) {
        $response['message'] = 'Database connection failed. Please check server configuration.';
        echo json_encode($response);
        exit;
    }

    // --- Basic Validation ---
    if (empty($_POST['projectName']) || empty($_POST['projectUrl']) || empty($_POST['status'])) {
        $response['message'] = 'Project Name, URL, and Status are required.';
        echo json_encode($response);
        exit;
    }

    if (!isset($_FILES['projectMap']) || $_FILES['projectMap']['error'] != 0) {
        $response['message'] = 'Project Map is required and must be uploaded successfully.';
        echo json_encode($response);
        exit;
    }

    if (!isset($_FILES['projectImages']) || empty($_FILES['projectImages']['name'][0])) {
         $response['message'] = 'At least one Project Image is required.';
         echo json_encode($response);
         exit;
    }

    // --- Process Project Map (Single File) ---
    $mapFile = $_FILES['projectMap'];
    // Sanitize filename and make it unique
    $mapExtension = pathinfo($mapFile['name'], PATHINFO_EXTENSION);
    $mapName = 'map_' . time() . '_' . uniqid() . '.' . $mapExtension;
    $mapTarget = $targetDir . $mapName;
    $mapDbPath = $mapTarget; // Path to store in DB

    if (!move_uploaded_file($mapFile['tmp_name'], $mapTarget)) {
        $response['message'] = 'Failed to upload Project Map.';
        echo json_encode($response);
        exit;
    }

    // --- Process Project Images (Multiple Files) ---
    $images = $_FILES['projectImages'];
    $uploadedImagePaths = []; // Array to store DB paths for images

    foreach ($images['name'] as $key => $name) {
        if ($images['error'][$key] == 0) {
            $tmp_name = $images['tmp_name'][$key];
            
            // Sanitize filename and make it unique
            $imageExtension = pathinfo($name, PATHINFO_EXTENSION);
            $imageName = 'img_' . time() . '_' . uniqid() . '_' . $key . '.' . $imageExtension;
            $imageTarget = $targetDir . $imageName;
            
            if (move_uploaded_file($tmp_name, $imageTarget)) {
                $uploadedImagePaths[] = $imageTarget; // Add path to our array
            } else {
                 $response['message'] = "Failed to upload one or more images ($name).";
                 // We'll fail the whole request if one image fails
                 echo json_encode($response);
                 exit;
            }
        }
    }

    if (empty($uploadedImagePaths)) {
         $response['message'] = 'No project images were successfully uploaded.';
         echo json_encode($response);
         exit;
    }

    // --- Get all POST data ---
    $projectName = trim($_POST['projectName']);
    $projectUrl = trim($_POST['projectUrl']);
    $teaser = trim($_POST['teaser']);
    $projectDetail = trim($_POST['projectDetail']);
    $status = trim($_POST['status']);

    // Convert the array of image paths to a JSON string for DB storage
    $imagePathsString = json_encode($uploadedImagePaths);

    // --- Database Insertion ---
    try {
        // The table name is 'projects'
        $sql = "INSERT INTO projects (project_name, project_url, teaser, project_detail, status, project_map, project_images) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $projectName, 
            $projectUrl, 
            $teaser, 
            $projectDetail, 
            $status, 
            $mapDbPath, 
            $imagePathsString // Storing as a JSON string
        ]);

        // If we get here, the DB insert was successful
        $response['success'] = true;
        $response['message'] = 'Project added successfully! All files uploaded.';

    } catch (PDOException $e) {
        // --- THIS IS THE CORRECTED LINE ---
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
    
    // Send the final JSON response and stop script execution
    echo json_encode($response);
    exit;

} // End of POST request check

// If it's a GET request, the script continues and renders the HTML below
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Add Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Add Project" />
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
                <h3 class="mb-0">Add New Project</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="projects.php">Projects</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add Project</li>
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
                <div class="card card-success mb-4">
                  <div class="card-header">
                    <h3 class="card-title mb-0">Enter Project Details</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- Form starts here -->
                  <!-- The form will submit to this same file (add_project.php) -->
                  <form id="addProjectForm" enctype="multipart/form-data" method="POST">
                    <div class="card-body">

                      <!-- Form Message Feedback -->
                      <div id="formMessage" class="alert" style="display: none;"></div>

                      <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="projectName" name="projectName" required>
                      </div>

                      <div class="mb-3">
                        <label for="projectUrl" class="form-label">Project URL <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" id="projectUrl" name="projectUrl" placeholder="https://example.com" required>
                      </div>

                      <div class="mb-3">
                        <label for="teaser" class="form-label">Teaser <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="teaser" name="teaser" rows="2" required></textarea>
                      </div>

                      <div class="mb-3">
                        <label for="projectDetail" class="form-label">Project Detail <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="projectDetail" name="projectDetail" rows="5" required></textarea>
                      </div>

                      <div class="mb-3">
                        <label for="projectImages" class="form-label">Select Images <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="projectImages" name="projectImages[]" multiple required>
                        <small class="form-text text-muted">You can select multiple images.</small>
                      </div>

                       <div class="mb-3">
                        <label for="projectMap" class="form-label">Project Map <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="projectMap" name="projectMap" required>
                      </div>

                      <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                          <option value="" selected disabled>Select Status</option>
                          <option value="Active">Active</option>
                          <option value="inActive">inActive</option>
                        </select>
                      </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-success">Add Project</button>
                      <a href="projects.php" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
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
    <script src="./js/adminlte.js"></script>

    <!-- AJAX Form Submission Script (formerly js/add_project_ajax.js) -->
    <script>
      document.getElementById('addProjectForm').addEventListener('submit', function(event) {
        
        // --- ALERT 1: ON BUTTON CLICK ---
        alert("Add Project button clicked! Submitting data...");
        // -------------------------------

        // Prevent the default form submission
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const messageDiv = document.getElementById('formMessage');

        // Display a loading message
        messageDiv.style.display = 'block';
        messageDiv.className = 'alert alert-info';
        messageDiv.textContent = 'Submitting project... Please wait.';

        // Send the data using Fetch API to this same file
        fetch('add_project.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Show success message
            messageDiv.className = 'alert alert-success';
            messageDiv.textContent = data.message;
            // Reset the form
            form.reset();
          } else {
            // Show error message
            messageDiv.className = 'alert alert-DANGER';
            messageDiv.textContent = data.message;
          }
        })
        .catch(error => {
          // Show network or server error
          messageDiv.className = 'alert alert-danger';
          messageDiv.textContent = 'An error occurred while submitting the form. Check console for details.';
          console.error('AJAX Error:', error);
        });
      });
    </script>

  </body>
</html>

