<?php
session_start();
require_once("../classes/Pagination.php");

// ✅ Database connection
$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// ✅ Initialize Pagination (10 per page)
$pagination = new Pagination($db, "sectors", 10);

// ✅ Fetch Sectors with Pagination
$query = "
SELECT s.*, p.project_name
FROM sectors s
LEFT JOIN projects p ON s.project_id = p.id
ORDER BY s.id DESC
LIMIT {$pagination->perPage} OFFSET {$pagination->offset}";
$result = $db->query($query);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Sectors List</title>
    <link rel="stylesheet" href="../css/adminlte.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
  </head>

  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <?php include("../includes/header.php"); ?>
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="../index.php" class="brand-link">
            <span class="brand-text fw-light">Real Estate E-System</span>
          </a>
        </div>
        <?php include("../includes/sidebar.php"); ?>
      </aside>

      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Sectors List</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Sectors</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header d-flex align-items-center">
                    <h3 class="card-title mb-0">Sectors</h3>
                    <a href="form_sector.php" class="btn btn-success ms-auto">Add Sector</a>
                  </div>

                  <div class="card-body">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Project Name</th>
                          <th>Sector Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                          <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                              <td><?= $row['id'] ?></td>
                              <td><?= htmlspecialchars($row['project_name'] ?? '-') ?></td>
                              <td><?= htmlspecialchars($row['sector_name']) ?></td>
                              <td>
                                <a href="form_sector.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                <button class="btn btn-sm btn-danger" onclick="deleteSector(<?= $row['id'] ?>)"><i class="bi bi-trash-fill"></i></button>
                              </td>
                            </tr>
                          <?php endwhile; ?>
                        <?php else: ?>
                          <tr><td colspan="5" class="text-center text-muted">No sectors found</td></tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>

                  <div class="card-footer clearfix">
                    <?= $pagination->renderLinks('sectors.php'); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

      <?php include("../includes/footer.php"); ?>
    </div>

    <!-- ✅ Delete Script -->
    <script>
      function deleteSector(id) {
        if (!confirm('Are you sure you want to delete this sector?')) return;
        const formData = new FormData();
        formData.append('id', id);
        formData.append('action', 'delete');

        fetch('api_sectors.php', { method: 'POST', body: formData })
          .then(res => res.json())
          .then(result => {
            alert(result.message);
            if (result.success) location.reload();
          })
          .catch(err => alert('Error: ' + err.message));
      }
    </script>
  </body>
</html>
