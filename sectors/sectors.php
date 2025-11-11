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
                    <!-- This div will show loading/error messages -->
                    <div id="tableMessage" class="alert alert-info" style="display: none;">Loading sectors...</div>
                    
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Project Name</th>
                          <th>Sector Name</th>
                          <th>Details</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="sectorTableBody">
                        <tr>
                          <td colspan="6" class="text-center">Loading...</td>
                        </tr>
                      </tbody>
                    </table>
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

    <!-- === DELETE CONFIRMATION MODAL === -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this sector? This action cannot be undone.
            <div id="deleteMessage" class="alert mt-3" style="display: none;"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
              Delete Sector
              <span id="deleteSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
            </button>
            <input type="hidden" id="deleteSectorId" value="0">
          </div>
        </div>
      </div>
    </div>
    <!-- === END MODAL === -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../js/adminlte.js"></script>

    <!-- === JAVASCRIPT TO LOAD SECTORS === -->
    <script>
      let deleteModalInstance;

      document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.getElementById('sectorTableBody');
        const tableMessage = document.getElementById('tableMessage');
        deleteModalInstance = new bootstrap.Modal(document.getElementById('deleteModal'));

        // Show loading
        tableMessage.textContent = 'Loading sectors...';
        tableMessage.className = 'alert alert-info';
        tableMessage.style.display = 'block';

        // Fetch all sectors from API
        fetch('api_sectors.php')
          .then(response => response.json())
          .then(result => {
            tableBody.innerHTML = ''; // Clear existing rows

            if (result.success && result.data.length > 0) {
              tableMessage.style.display = 'none';
              result.data.forEach(sector => {
                const row = document.createElement('tr');
                row.id = `sector-row-${sector.id}`;
                row.innerHTML = `
                  <td>${sector.id}</td>
                  <td>${escapeHTML(sector.project_name || 'N/A')}</td>
                  <td>${escapeHTML(sector.sector_name)}</td>
                  <td>${escapeHTML(sector.details || '')}</td>
                  <td>
                    <a href="add_sector.php?id=${sector.id}" class="btn btn-sm btn-warning me-1" title="Edit">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-danger" title="Delete" onclick="deleteSector(${sector.id})">
                      <i class="bi bi-trash-fill"></i>
                    </a>
                  </td>
                `;
                tableBody.appendChild(row);
              });
            } else if (result.success && result.data.length === 0) {
              tableMessage.textContent = 'No sectors found. You can add one using the "Add Sector" button.';
              tableMessage.className = 'alert alert-secondary';
            } else {
              tableMessage.textContent = 'Error: ' + result.message;
              tableMessage.className = 'alert alert-danger';
            }
          })
          .catch(error => {
            tableMessage.textContent = 'An error occurred while fetching sectors. Check console for details.';
            tableMessage.className = 'alert alert-danger';
            console.error('Fetch Error:', error);
          });

        // --- DELETE CONFIRMATION ---
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
          const id = document.getElementById('deleteSectorId').value;
          const deleteMsgDiv = document.getElementById('deleteMessage');
          const deleteSpinner = document.getElementById('deleteSpinner');
          const deleteBtn = this;

          deleteBtn.disabled = true;
          deleteSpinner.style.display = 'inline-block';
          deleteMsgDiv.style.display = 'none';

          const formData = new FormData();
          formData.append('id', id);
          formData.append('action', 'delete');

          fetch('api_sectors.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(result => {
            if (result.success) {
              deleteMsgDiv.className = 'alert alert-success';
              deleteMsgDiv.textContent = result.message;
              deleteMsgDiv.style.display = 'block';
              document.getElementById(`sector-row-${id}`).remove();
              setTimeout(() => {
                deleteModalInstance.hide();
                deleteBtn.disabled = false;
                deleteSpinner.style.display = 'none';
              }, 1500);
            } else {
              deleteMsgDiv.className = 'alert alert-danger';
              deleteMsgDiv.textContent = result.message;
              deleteMsgDiv.style.display = 'block';
              deleteBtn.disabled = false;
              deleteSpinner.style.display = 'none';
            }
          })
          .catch(error => {
            deleteMsgDiv.className = 'alert alert-danger';
            deleteMsgDiv.textContent = 'A network error occurred. Please try again.';
            deleteMsgDiv.style.display = 'block';
            deleteBtn.disabled = false;
            deleteSpinner.style.display = 'none';
            console.error('Delete Fetch Error:', error);
          });
        });
      });

      function deleteSector(id) {
        document.getElementById('deleteSectorId').value = id;
        const deleteMsgDiv = document.getElementById('deleteMessage');
        deleteMsgDiv.style.display = 'none';
        deleteModalInstance.show();
      }

      // Safe HTML escape
      function escapeHTML(str) {
        if (str === null || typeof str === 'undefined') return '';
        return str.toString()
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;')
          .replace(/'/g, '&#39;');
      }
    </script>
  </body>
</html>
