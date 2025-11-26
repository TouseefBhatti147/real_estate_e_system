<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../classes/MemberPlot.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$mpObj = new MemberPlot($db);

// search + pagination
$search = $_GET['q'] ?? '';
$page   = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit  = 20;
$offset = ($page - 1) * $limit;

$list       = $mpObj->getAll($search, $limit, $offset);
$totalRows  = $mpObj->getTotal($search);
$totalPages = ($totalRows > 0) ? ceil($totalRows / $limit) : 1;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Member Plot List</title>

    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
          media="print" onload="this.media='all'" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/adminlte.css" />
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <?php include("../includes/header.php"); ?>

    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <?php include("../includes/sidebar.php"); ?>
    </aside>

    <main class="app-main">
        <div class="app-content">

            <div class="app-content-header">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Member Plot Assignments</h3>
                    <a href="form_memberplot.php" class="btn btn-success">
                        <i class="bi bi-plus-lg"></i> Assign Plot
                    </a>
                </div>
            </div>

            <div class="app-content-wrapper">

                <!-- Search -->
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="get" class="row g-2">
                            <div class="col-md-4">
                                <input type="text"
                                       name="q"
                                       class="form-control"
                                       placeholder="Search plotno / msno / status"
                                       value="<?= htmlspecialchars($search) ?>">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="memberplot_list.php" class="btn btn-secondary ms-1">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table -->
                <div class="card mb-4">
                    <div class="card-body p-0">
                        <table class="table table-bordered table-striped mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Plot ID</th>
                                    <th>Member ID</th>
                                    <th>Create Date</th>
                                    <th>NOI</th>
                                    <th>Ins Plan</th>
                                    <th>Status</th>
                                    <th>Plot No</th>
                                    <th>MS No</th>
                                    <th>UID</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if ($list && $list->num_rows > 0): ?>
                                <?php while ($row = $list->fetch_assoc()): ?>
                                    <tr id="row-<?= $row['id'] ?>">
                                        <td><?= $row['id'] ?></td>
                                        <td><?= htmlspecialchars($row['plot_id']) ?></td>
                                        <td><?= htmlspecialchars($row['member_id']) ?></td>
                                        <td><?= htmlspecialchars($row['create_date']) ?></td>
                                        <td><?= htmlspecialchars($row['noi']) ?></td>
                                        <td><?= htmlspecialchars($row['insplan']) ?></td>
                                        <td><?= htmlspecialchars($row['status']) ?></td>
                                        <td><?= htmlspecialchars($row['plotno']) ?></td>
                                        <td><?= htmlspecialchars($row['msno']) ?></td>
                                        <td><?= htmlspecialchars($row['uid']) ?></td>
                                        <td>
                                            <a href="form_memberplot.php?id=<?= $row['id'] ?>"
                                               class="btn btn-warning btn-sm me-1">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm"
                                                    onclick="deleteMemberPlot(<?= $row['id'] ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-3">
                                        No records found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
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

<script>
function deleteMemberPlot(id) {
    if (!confirm("Do you want to delete this record?")) return;

    const fd = new FormData();
    fd.append('action', 'delete');
    fd.append('id', id);

    fetch('api_memberplot.php', {
        method: 'POST',
        body: fd
    })
    .then(r => r.json())
    .then(res => {
        alert(res.message);
        if (res.success) {
            const row = document.getElementById('row-' + id);
            if (row) row.remove();
        }
    });
}
</script>

</body>
</html>
