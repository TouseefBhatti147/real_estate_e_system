<?php session_start(); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Project List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Project List" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="Admin Dashboard..." />
    <meta name="keywords" content="bootstrap 5, admin dashboard, accessible, WCAG" />
    <meta name="supported-color-schemes" content="light dark" />

    <!-- === FIXED CSS PATH === -->
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

            <!-- === ADDED LOGO BACK === -->
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
                <h3 class="mb-0">Project List</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Project List</li>
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
                    <h3 class="card-title mb-0">Projects</h3>
                    <a href="add_project.php" class="btn btn-success ms-auto">Add Project</a>
                  </div>
                  <div class="card-body">
                    <!-- This div will show loading/error messages -->
                    <div id="tableMessage" class="alert alert-info" style="display: none;">Loading projects...</div>
                    
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Project Name</th>
                          <th>Teaser</th>
                          <th>URL</th>
                          <th>Create Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <!-- Add an ID to the tbody so we can target it with JS -->
                      <tbody id="projectTableBody">
                        <!-- Static content will be replaced by JavaScript -->
                        <tr>
                          <td colspan="6" class="text-center">Loading...</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    <!-- Pagination (can be made dynamic later) -->
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
    <!-- /.app-wrapper -->

    <!-- === NEW DELETE CONFIRMATION MODAL === -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this project? This action cannot be undone.
            <!-- Message area for delete feedback -->
            <div id="deleteMessage" class="alert mt-3" style="display: none;"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
              Delete Project
              <span id="deleteSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
            </button>
            <!-- Hidden input to store the ID of the project to be deleted -->
            <input type="hidden" id="deleteProjectId" value="0">
          </div>
        </div>
      </div>
    </div>
    <!-- === END OF MODAL === -->


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../js/adminlte.js"></script>

    <!-- === JAVASCRIPT TO LOAD PROJECTS === -->
    <script>
      let deleteModalInstance; // To control the modal with JS

      // Wait for the DOM to be fully loaded before running the script
      document.addEventListener('DOMContentLoaded', function() {
        
        const tableBody = document.getElementById('projectTableBody');
        const tableMessage = document.getElementById('tableMessage');
        
        // Initialize the Bootstrap modal
        deleteModalInstance = new bootstrap.Modal(document.getElementById('deleteModal'));

        // Show loading message
        tableMessage.textContent = 'Loading projects...';
        tableMessage.className = 'alert alert-info';
        tableMessage.style.display = 'block';

        // Fetch the project list from our new API
        fetch('api_projects.php')
          .then(response => response.json())
          .then(result => {
            // Clear the "Loading..." row
            tableBody.innerHTML = ''; 

            if (result.success && result.data.length > 0) {
              // Hide the message div if data is loaded
              tableMessage.style.display = 'none';

              // Loop through each project in the data array
              result.data.forEach(project => {
                // Create a new table row
                const row = document.createElement('tr');
                
                // === FIXED VARIABLE NAMES ===
                // Added id="project-row-..." for easy removal
                // Changed project.id to project.project_id
                // Changed project.url to project.project_url
                row.id = `project-row-${project.id}`;
                row.innerHTML = `
                  <td>${project.id}</td>
                  <td>${escapeHTML(project.project_name)}</td>
                  <td>${escapeHTML(project.teaser)}</td>
                  <td><a href="${escapeHTML(project.project_url)}" target="_blank">${escapeHTML(project.url)}</a></td>
                  <td>${project.create_date || 'N/A'}</td>
                  <td>
                    <a href="view_project.php?id=${project.id}" class="btn btn-sm btn-info me-1" title="View"><i class="bi bi-info-circle-fill"></i></a>
                    <a href="form_project.php?id=${project.id}" class="btn btn-sm btn-warning me-1" title="Edit"><i class="bi bi-pencil-square"></i></a>                    <a href="#" class="btn btn-sm btn-danger" title="Delete" onclick="deleteProject(${project.id})"><i class="bi bi-trash-fill"></i></a>
                  </td>
                `;
                
                // Add the new row to the table body
                tableBody.appendChild(row);
              });

            } else if (result.success && result.data.length === 0) {
              // Show a "no projects" message
              tableMessage.textContent = 'No projects found. You can add one using the "Add Project" button.';
              tableMessage.className = 'alert alert-secondary';
            } else {
              // Show an error message from the API
              tableMessage.textContent = 'Error: ' + result.message;
              tableMessage.className = 'alert alert-danger';
            }
          })
          .catch(error => {
            // Handle network or other fetch errors
            tableMessage.textContent = 'An error occurred while fetching data. Please check the console.';
            tableMessage.className = 'alert alert-danger';
            console.error('Fetch Error:', error);
          });

        // --- NEW EVENT LISTENER FOR MODAL DELETE BUTTON ---
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
          const id = document.getElementById('deleteProjectId').value;
          const deleteMsgDiv = document.getElementById('deleteMessage');
          const deleteSpinner = document.getElementById('deleteSpinner');
          const deleteBtn = this;

          // Show loading state
          deleteBtn.disabled = true;
          deleteSpinner.style.display = 'inline-block';
          deleteMsgDiv.style.display = 'none';

          // Prepare form data to send the ID
          const formData = new FormData();
          formData.append('id', id);

          // Call the delete API
          fetch('api_projects.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(result => {
            if (result.success) {
              // Show success message
              deleteMsgDiv.className = 'alert alert-success';
              deleteMsgDiv.textContent = result.message;
              deleteMsgDiv.style.display = 'block';

              // Remove the row from the table
              document.getElementById(`project-row-${id}`).remove();

              // Hide the modal after a short delay
              setTimeout(() => {
                deleteModalInstance.hide();
                deleteBtn.disabled = false;
                deleteSpinner.style.display = 'none';
              }, 1500);

            } else {
              // Show error message
              deleteMsgDiv.className = 'alert alert-danger';
              deleteMsgDiv.textContent = result.message;
              deleteMsgDiv.style.display = 'block';
              deleteBtn.disabled = false;
              deleteSpinner.style.display = 'none';
            }
          })
          .catch(error => {
            // Show network/fetch error
            deleteMsgDiv.className = 'alert alert-danger';
            deleteMsgDiv.textContent = 'A network error occurred. Please try again.';
            deleteMsgDiv.style.display = 'block';
            deleteBtn.disabled = false;
            deleteSpinner.style.display = 'none';
            console.error('Delete Fetch Error:', error);
          });
        });

      }); // End of DOMContentLoaded

      // A simple helper function to prevent XSS (Cross-Site Scripting)
      function escapeHTML(str) {
        // Ensure str is not null or undefined before calling toString
        if (str === null || typeof str === 'undefined') {
          return '';
        }
        return str.toString()
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;')
          .replace(/'/g, '&#39;');
      }

      // --- UPDATED DELETE FUNCTION ---
      // This function just opens the modal and sets the ID
      function deleteProject(id) {
        // Set the hidden input value to the ID of the project we want to delete
        document.getElementById('deleteProjectId').value = id;
        
        // Reset any previous delete messages
        const deleteMsgDiv = document.getElementById('deleteMessage');
        deleteMsgDiv.style.display = 'none';
        
        // Show the modal
        deleteModalInstance.show();
      }
    </script>
    <!-- === END OF NEW SCRIPT === -->

  </body>
</html>