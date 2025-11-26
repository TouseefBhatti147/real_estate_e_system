<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../classes/MemberPlot.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$mpObj  = new MemberPlot($db);
$id     = $_GET['id'] ?? null;
$record = null;

if ($id) {
    $record = $mpObj->getById((int)$id);
}

// logged-in UID
$loggedUid = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

// Pre-selects if editing
$editProjectId = $record['project_id'] ?? '';
$editSectorId  = $record['sector_id']  ?? '';
$editStreetId  = $record['street_id']  ?? '';
$editPlotId    = $record['plot_id']    ?? '';
$editMemberId  = $record['member_id']  ?? '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= $id ? "Edit Member Plot" : "Assign Plot to Member" ?></title>

    <link rel="stylesheet" href="../css/adminlte.css" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <h3 class="mb-0"><?= $id ? "Edit Member Plot Assignment" : "Assign Plot to Member" ?></h3>
            <a href="memberplot_list.php" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="api_memberplot.php" method="post">
                <input type="hidden" name="action" value="<?= $id ? 'update' : 'add' ?>">
                <input type="hidden" name="id" value="<?= htmlspecialchars($record['id'] ?? '') ?>">

                <!-- UID always from session -->
                <input type="hidden" name="uid" value="<?= $loggedUid ?>">

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <h5>Assign Plot to Member</h5>
                    </div>

                    <!-- PROJECT -->
                    <div class="col-md-3">
                        <label class="form-label">Project</label>
                        <select id="projectSelect" class="form-select">
                            <option value="">Select Project</option>
                        </select>
                    </div>

                    <!-- SECTOR -->
                    <div class="col-md-3">
                        <label class="form-label">Sector</label>
                        <select id="sectorSelect" class="form-select" disabled>
                            <option value="">Select Sector</option>
                        </select>
                    </div>

                    <!-- STREET -->
                    <div class="col-md-3">
                        <label class="form-label">Street</label>
                        <select id="streetSelect" class="form-select" disabled>
                            <option value="">Select Street</option>
                        </select>
                    </div>

                    <!-- PLOT -->
                    <div class="col-md-3">
                        <label class="form-label">Plot</label>
                        <select id="plotSelect" name="plot_id" class="form-select" disabled required>
                            <option value="">Select Plot</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- MEMBER -->
                    <div class="col-md-4">
                        <label class="form-label">Member</label>
                        <select name="member_id" id="memberSelect" class="form-select" required>
                            <option value="">Select Member</option>
                        </select>
                    </div>

                    <!-- CREATE DATE -->
                    <div class="col-md-4">
                        <label class="form-label">Create Date</label>
                        <input type="datetime-local" name="create_date" class="form-control"
                               value="<?php
                                    if (!empty($record['create_date'])) {
                                        echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($record['create_date'])));
                                    }
                               ?>">
                    </div>

                    <!-- NOI -->
                    <div class="col-md-2">
                        <label class="form-label">NOI</label>
                        <input type="text" name="noi" class="form-control"
                               value="<?= htmlspecialchars($record['noi'] ?? '1') ?>">
                    </div>

                    <!-- Installment Plan -->
                    <div class="col-md-2">
                        <label class="form-label">Installment Plan (insplan)</label>
                        <input type="number" name="insplan" class="form-control"
                               value="<?= htmlspecialchars($record['insplan'] ?? '') ?>">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- STATUS -->
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <?php $statusVal = $record['status'] ?? 'Approved'; ?>
                        <select name="status" class="form-select">
                            <option value="Approved" <?= ($statusVal === 'Approved' ? 'selected' : '') ?>>Approved</option>
                            <option value="Pending"  <?= ($statusVal === 'Pending'  ? 'selected' : '') ?>>Pending</option>
                            <option value="Cancelled"<?= ($statusVal === 'Cancelled'? 'selected' : '') ?>>Cancelled</option>
                        </select>
                    </div>

                    <!-- Plot No -->
                    <div class="col-md-3">
                        <label class="form-label">Plot No</label>
                        <input type="text" name="plotno" class="form-control"
                               value="<?= htmlspecialchars($record['plotno'] ?? '') ?>">
                    </div>

                    <!-- MS No -->
                    <div class="col-md-3">
                        <label class="form-label">MS No</label>
                        <input type="text" name="msno" class="form-control"
                               value="<?= htmlspecialchars($record['msno'] ?? '') ?>">
                    </div>

                    <!-- UID (read-only display) -->
                    <div class="col-md-3">
                        <label class="form-label">UID (logged-in user)</label>
                        <input type="text" class="form-control" value="<?= $loggedUid ?>" disabled>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary">
                        <?= $id ? "Update Assignment" : "Save Assignment" ?>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
</main>

<?php include("../includes/footer.php"); ?>
</div>

<script>
// ----------------- LOAD PROJECTS -----------------
function loadProjects(selectedId = '') {
    $.getJSON('../projects/api_projects.php', function(res) {
        const $p = $('#projectSelect');
        $p.empty().append('<option value="">Select Project</option>');
        if (res.success && res.data.length > 0) {
            res.data.forEach(p => {
                const selected = (String(p.id) === String(selectedId)) ? 'selected' : '';
                $p.append(`<option value="${p.id}" ${selected}>${p.project_name}</option>`);
            });
        }
        // If editing and project is set, trigger sectors load
        <?php if ($editProjectId): ?>
        if (selectedId) {
            loadSectors(selectedId, '<?= addslashes($editSectorId) ?>');
        }
        <?php endif; ?>
    });
}

// ----------------- LOAD SECTORS -----------------
function loadSectors(projectId, selectedId = '') {
    if (!projectId) {
        $('#sectorSelect').prop('disabled', true).html('<option value="">Select Sector</option>');
        $('#streetSelect').prop('disabled', true).html('<option value="">Select Street</option>');
        $('#plotSelect').prop('disabled', true).html('<option value="">Select Plot</option>');
        return;
    }

    let url = '../sectors/api_sectors.php?project_id=' + encodeURIComponent(projectId);
    $.getJSON(url, function(res) {
        const $s = $('#sectorSelect');
        $s.prop('disabled', false).empty().append('<option value="">Select Sector</option>');
        if (res.success && res.data.length > 0) {
            res.data.forEach(sec => {
                const selected = (String(sec.sector_id) === String(selectedId)) ? 'selected' : '';
                $s.append(`<option value="${sec.sector_id}" ${selected}>${sec.sector_name}</option>`);
            });
        }
        <?php if ($editSectorId): ?>
        if (selectedId) {
            loadStreets(projectId, selectedId, '<?= addslashes($editStreetId) ?>');
        }
        <?php endif; ?>
    });
}

// ----------------- LOAD STREETS -----------------
function loadStreets(projectId, sectorId, selectedId = '') {
    if (!projectId || !sectorId) {
        $('#streetSelect').prop('disabled', true).html('<option value="">Select Street</option>');
        $('#plotSelect').prop('disabled', true).html('<option value="">Select Plot</option>');
        return;
    }

    let url = '../streets/api_streets.php?project_id=' + encodeURIComponent(projectId)
                                + '&sector_id=' + encodeURIComponent(sectorId);

    $.getJSON(url, function(res) {
        const $st = $('#streetSelect');
        $st.prop('disabled', false).empty().append('<option value="">Select Street</option>');
        if (res.success && res.data.length > 0) {
            res.data.forEach(st => {
                const selected = (String(st.id) === String(selectedId)) ? 'selected' : '';
                $st.append(`<option value="${st.id}" ${selected}>${st.street}</option>`);
            });
        }
        <?php if ($editStreetId): ?>
        if (selectedId) {
            loadPlots(projectId, sectorId, selectedId, '<?= addslashes($editPlotId) ?>');
        }
        <?php endif; ?>
    });
}

// ----------------- LOAD PLOTS -----------------
function loadPlots(projectId, sectorId, streetId, selectedId = '') {
    if (!projectId || !sectorId || !streetId) {
        $('#plotSelect').prop('disabled', true).html('<option value="">Select Plot</option>');
        return;
    }

    let url = '../plots/api_plots_dropdown.php'
            + '?project_id=' + encodeURIComponent(projectId)
            + '&sector_id=' + encodeURIComponent(sectorId)
            + '&street_id=' + encodeURIComponent(streetId);

    $.getJSON(url, function(res) {
        const $pl = $('#plotSelect');
        $pl.prop('disabled', false).empty().append('<option value="">Select Plot</option>');
        if (res.success && res.data.length > 0) {
            res.data.forEach(pl => {
                const selected = (String(pl.id) === String(selectedId)) ? 'selected' : '';
                const label = pl.plot_detail_address + ' (' + pl.plot_size + ')';
                $pl.append(`<option value="${pl.id}" ${selected}>${label}</option>`);
            });
        }
    });
}

// ----------------- LOAD MEMBERS -----------------
function loadMembers(selectedId = '') {
    $.getJSON('../members/api_members_dropdown.php', function(res) {
        const $m = $('#memberSelect');
        $m.empty().append('<option value="">Select Member</option>');
        if (res.success && res.data.length > 0) {
            res.data.forEach(m => {
                const selected = (String(m.id) === String(selectedId)) ? 'selected' : '';
                const label = m.name + (m.username ? ' (' + m.username + ')' : '');
                $m.append(`<option value="${m.id}" ${selected}>${label}</option>`);
            });
        }
    });
}

// ----------------- INIT -----------------
$(document).ready(function() {
    // initial loads
    loadProjects('<?= addslashes($editProjectId) ?>');
    loadMembers('<?= addslashes($editMemberId) ?>');

    $('#projectSelect').on('change', function() {
        const projectId = $(this).val();
        loadSectors(projectId);
        $('#streetSelect').prop('disabled', true).html('<option value="">Select Street</option>');
        $('#plotSelect').prop('disabled', true).html('<option value="">Select Plot</option>');
    });

    $('#sectorSelect').on('change', function() {
        const projectId = $('#projectSelect').val();
        const sectorId  = $(this).val();
        loadStreets(projectId, sectorId);
        $('#plotSelect').prop('disabled', true).html('<option value="">Select Plot</option>');
    });

    $('#streetSelect').on('change', function() {
        const projectId = $('#projectSelect').val();
        const sectorId  = $('#sectorSelect').val();
        const streetId  = $(this).val();
        loadPlots(projectId, sectorId, streetId);
    });
});
</script>

</body>
</html>
