<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="bi bi-speedometer2"></i> User Dashboard</a>
        <div class="d-flex align-items-center gap-3">
            <button id="darkModeToggle" class="btn"><i class="bi bi-moon"></i></button>
            <a href="logout.php" class="btn btn-outline-light btn-sm px-3">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    <div class="text-center mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Profile" class="profile-img shadow-sm">
        <h2 class="welcome-text">👋 Welcome, <span id="userName">Sumon Prodhan</span></h2>
        <p class="text-muted">You are successfully logged in!</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-center p-4">
                <i class="bi bi-folder-check fs-1 text-primary mb-2"></i>
                <h5>Total Projects</h5>
                <h2>5</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-4">
                <i class="bi bi-hourglass-split fs-1 text-warning mb-2"></i>
                <h5>Pending Tasks</h5>
                <h2>3</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-4">
                <i class="bi bi-check2-circle fs-1 text-success mb-2"></i>
                <h5>Completed Tasks</h5>
                <h2>12</h2>
            </div>
        </div>
    </div>

    <!-- User Info -->
    <div class="mt-5">
        <div class="card p-4 user-info-card shadow-sm">
            <h5 class="fw-bold mb-3"><i class="bi bi-person-lines-fill text-primary"></i> User Information</h5>
            <table class="table table-striped align-middle">
                <tr>
                    <th><i class="bi bi-person"></i> Name</th>
                    <td id="infoName">Sumon Prodhan</td>
                </tr>
                <tr>
                    <th><i class="bi bi-envelope"></i> Email</th>
                    <td id="infoEmail">sumon@example.com</td>
                </tr>
                <tr>
                    <th><i class="bi bi-telephone"></i> Phone</th>
                    <td id="infoPhone">017xxxxxxxx</td>
                </tr>
                <tr>
                    <th><i class="bi bi-gender-male"></i> Gender</th>
                    <td id="infoGender">Male</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p class="mb-0">&copy; <?= date("Y"); ?> Developed by <a class="text-white" target="_blank" href="https://sumonprodev.wixsite.com/sumonprodhan">Sumon Prodhan</a></p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Dark Mode Script -->
<script>
document.getElementById('darkModeToggle').addEventListener('click', function () {
    document.body.classList.toggle('dark-mode');
    const icon = this.querySelector('i');
    icon.classList.toggle('bi-moon');
    icon.classList.toggle('bi-sun');
});
</script>

</body>
</html>
