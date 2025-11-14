<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../classes/User.php");

// DB connection
$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$userObj = new User($db);

// pagination + search
$search  = $_GET['q'] ?? '';
$page    = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit   = 20;
$offset  = ($page - 1) * $limit;

$list       = $userObj->getAllUsers($search, $limit, $offset);
$totalRows  = $userObj->getTotalUsers($search);
$totalPages = ($totalRows > 0) ? ceil($totalRows / $limit) : 1;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>User List</title>

    <!-- AdminLTE CSS -->
    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
          media="print" onload="this.media='all'" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/adminlte.css" />

    <style>
        .user-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
        .app-content-wrapper { overflow: visible !important; }
        body, html { overflow-y: auto !important; }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <?php include("../includes/header.php"); ?>

    <!-- SIDEBAR -->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <?php include("../includes/sidebar.php"); ?>
    </aside>

    <!-- MAIN -->
    <main class="app-main">
        <div class="app-content">

            <!-- PAGE HEADER -->
            <div class="app-content-header">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Users</h3>
                    <a href="form_user.php" class="btn btn-success">
                        <i class="bi bi-plus-lg"></i> Add User
                    </a>
                </div>
            </div>

            <div class="app-content-wrapper">

                <!-- SEARCH BAR -->
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="get" class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="q" class="form-control"
                                       placeholder="Search name or username"
                                       value="<?= htmlspecialchars($search) ?>">
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="user_list.php" class="btn btn-secondary ms-1">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- USER TABLE -->
                <div class="card mb-4">
                    <div class="card-body p-0">

                        <table class="table table-bordered table-striped mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">ID</th>
                                    <th>Image</th>
                                    <th>First</th>
                                    <th>Middle</th>
                                    <th>Last</th>
                                    <th>Username</th>
                                    <th>Father/Spouse</th>
                                    <th>Status</th>
                                    <th>Create Date</th>
                                    <th width="160">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php if ($list && $list->num_rows > 0): ?>
                                <?php while ($row = $list->fetch_assoc()): ?>
                                <tr id="row-<?= $row['id'] ?>">

                                    <td><?= $row['id'] ?></td>

                                    <td>
                                        <?php if (!empty($row['pic'])): ?>
                                            <img src="../../assets/img/user_images/<?= $row['pic'] ?>" class="user-avatar">
                                        <?php else: ?>
                                            <img src="../../assets/img/user_images/no_image.png" class="user-avatar">
                                        <?php endif; ?>
                                    </td>

                                    <td><?= htmlspecialchars($row['firstname']) ?></td>
                                    <td><?= htmlspecialchars($row['middelname']) ?></td>
                                    <td><?= htmlspecialchars($row['lastname']) ?></td>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td><?= htmlspecialchars($row['sodowo']) ?></td>

                                    <td>
                                        <?php if ($row['status'] == 1): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= date("d-m-Y", strtotime($row['create_date'])) ?></td>

                                    <td>
                                        <a href="user_profile.php?id=<?= $row['id'] ?>"
                                           class="btn btn-info btn-sm me-1">
                                           <i class="bi bi-eye"></i></a>

                                        <a href="form_user.php?id=<?= $row['id'] ?>"
                                           class="btn btn-warning btn-sm me-1">
                                           <i class="bi bi-pencil"></i></a>

                                        <button class="btn btn-danger btn-sm"
                                                onclick="deleteUser(<?= $row['id'] ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-3">
                                        No users found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>

                        </table>

                    </div>

                    <!-- PAGINATION -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-end">

                            <li class="page-item <?= ($page <= 1 ? 'disabled' : '') ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>&q=<?= urlencode($search) ?>">«</a>
                            </li>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($page == $i ? 'active' : '') ?>">
                                    <a class="page-link"
                                       href="?page=<?= $i ?>&q=<?= urlencode($search) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= ($page >= $totalPages ? 'disabled' : '') ?>">
                                <a class="page-link" href="?page=<?= $page + 1 ?>&q=<?= urlencode($search) ?>">»</a>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <?php include("../includes/footer.php"); ?>

</div>

<!-- AdminLTE Required JS -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="../js/adminlte.js"></script>

<script>
// DELETE USER
function deleteUser(id) {
    if (!confirm("Do you want to delete this user?")) return;

    let fd = new FormData();
    fd.append("action", "delete");
    fd.append("id", id);

    fetch("api_users.php", { method: "POST", body: fd })
        .then(r => r.json())
        .then(res => {
            alert(res.message);
            if (res.success) {
                document.getElementById("row-" + id).remove();
            }
        });
}
</script>

</body>
</html>
