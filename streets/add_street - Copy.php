<?php session_start(); ?>
<?php
$streetDataJSON = 'null';
$pageError = '';
$streetId = isset($_GET['id']) ? trim($_GET['id']) : null;
$pageTitle = $streetId ? 'Edit Street' : 'Add New Street';
$cardTitle = $streetId ? 'Edit Street Details' : 'New Street Information';
$submitText = $streetId ? 'Update Street' : 'Add Street';
$cardType = $streetId ? 'card-success' : 'card-primary';

// ✅ Database connection
$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    $pageError = "Database connection failed: " . $db->connect_error;
}

// ✅ Fetch all projects
$projects = [];
if (empty($pageError)) {
    $result = $db->query("SELECT id, project_name FROM projects ORDER BY project_name ASC");
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// ✅ Fetch all sectors
$sectors = [];
if (empty($pageError)) {
    $result = $db->query("SELECT id, sector_name FROM sectors ORDER BY sector_name ASC");
    while ($row = $result->fetch_assoc()) {
        $sectors[] = $row;
    }
}

// ✅ Fetch existing street data (edit mode)
if ($streetId && empty($pageError)) {
    $stmt = $db->prepare("SELECT * FROM streets WHERE id = ?");
    $stmt->bind_param("i", $streetId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $street = $result->fetch_assoc();
        $streetDataJSON = json_encode(['success' => true, 'data' => $street]);
    } else {
        $pageError = "⚠️ Street not found for ID: " . htmlspecialchars($streetId);
        $streetDataJSON = json_encode(['success' => false, 'message' => $pageError]);
    }

    $stmt->close();
}
$db->close();

$formDisabled = !empty($pageError);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Street - <?= $pageTitle ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/adminlte.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <div class="app-content-header mb-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3><?= $pageTitle ?></h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $pageTitle ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card <?= $cardType ?> mb-4 shadow-sm">
                        <div class="card-header"><h4><?= $cardTitle ?></h4></div>
                        <form id="streetForm" method="POST">
                            <div class="card-body">
                                <div id="apiResponse" class="alert" style="display:none;"></div>
                                <?php if($pageError): ?>
                                    <div class="alert alert-danger"><?= $pageError ?></div>
                                <?php endif; ?>

                                <input type="hidden" name="id" id="streetId" value="<?= htmlspecialchars($streetId ?? '') ?>">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="project_id" class="form-label">Project <span class="text-danger">*</span></label>
                                        <select class="form-select" id="project_id" name="project_id" required <?= $formDisabled?'disabled':'' ?>>
                                            <option value="">Select Project</option>
                                            <?php foreach ($projects as $p): ?>
                                                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['project_name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sector_id" class="form-label">Sector <span class="text-danger">*</span></label>
                                        <select class="form-select" id="sector_id" name="sector_id" required <?= $formDisabled?'disabled':'' ?>>
                                            <option value="">Select Sector</option>
                                            <?php foreach ($sectors as $s): ?>
                                                <option value="<?= htmlspecialchars($s['id']) ?>"><?= htmlspecialchars($s['sector_name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="street" class="form-label">Street Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="street" name="street" required <?= $formDisabled?'disabled':'' ?>>
                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <button type="submit" id="submitButton" class="btn <?= $streetId?'btn-success':'btn-primary' ?>" <?= $formDisabled?'disabled':'' ?>><?= $submitText ?></button>
                                <a href="streets.php" class="btn btn-secondary ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include("../includes/footer.php"); ?>
</div>

<script>
const preloadedData = <?= $streetDataJSON ?>;
const isUpdateMode = <?= $streetId?'true':'false' ?>;

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('streetForm');
    const apiResponseDiv = document.getElementById('apiResponse');
    const submitButton = document.getElementById('submitButton');

    if (isUpdateMode && preloadedData && preloadedData.success && preloadedData.data) {
        const data = preloadedData.data;
        document.getElementById('project_id').value = data.project_id || '';
        document.getElementById('sector_id').value = data.sector_id || '';
        document.getElementById('street').value = data.street || '';
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitButton.disabled = true;
        submitButton.textContent = isUpdateMode ? 'Updating...' : 'Adding...';

        const formData = new FormData(this);
        formData.set('action', isUpdateMode ? 'update' : 'add');

        fetch('api_streets.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(result => {
                showApiResponse(result.message, result.success);
                if (result.success) {
                    setTimeout(() => window.location.href = 'streets.php', 1000);
                }
            })
            .catch(err => showApiResponse('Error: ' + err.message, false))
            .finally(() => {
                submitButton.disabled = false;
                submitButton.textContent = isUpdateMode ? 'Update Street' : 'Add Street';
            });
    });

    function showApiResponse(message, isSuccess) {
        apiResponseDiv.textContent = message;
        apiResponseDiv.style.display = 'block';
        apiResponseDiv.className = isSuccess ? 'alert alert-success' : 'alert alert-danger';
    }
});
</script>
</body>
</html>
