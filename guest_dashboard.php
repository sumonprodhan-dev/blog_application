<?php
session_start();

if (!isset($_SESSION['guest'])) {
    header('location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="bi bi-speedometer2"></i> Guest Dashboard</a>
        <div class="d-flex align-items-center gap-3">
            <button id="darkModeToggle" class="btn"><i class="bi bi-moon"></i></button>
            <a href="logout.php" class="btn btn-outline-light btn-sm px-3">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container dashboard-header text-center mt-5">
    <h2 class="text-primary">👋 Welcome, Guest!</h2>
    <p class="lead text-muted">You’re currently browsing as a guest. Enjoy exploring PHP learning materials.</p>

    <div class="row justify-content-center mt-5 g-4">
        <div class="col-md-4">
            <div class="card p-4 shadow-sm h-100">
                <div class="text-center mb-3">
                    <i class="bi bi-book-fill display-5 text-primary"></i>
                </div>
                <h5 class="text-center">Learn PHP</h5>
                <p class="text-muted text-center">Explore tutorials and examples to strengthen your basics.</p>
                <div class="text-center">
                    <a href="#" class="btn btn-outline-primary btn-custom">Start Learning</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 shadow-sm h-100">
                <div class="text-center mb-3">
                    <i class="bi bi-laptop display-5 text-primary"></i>
                </div>
                <h5 class="text-center">Practice Projects</h5>
                <p class="text-muted text-center">Build small PHP projects and boost your confidence.</p>
                <div class="text-center">
                    <a href="#" class="btn btn-outline-primary btn-custom">Try Projects</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 shadow-sm h-100">
                <div class="text-center mb-3">
                    <i class="bi bi-envelope-paper-fill display-5 text-primary"></i>
                </div>
                <h5 class="text-center">Contact Us</h5>
                <p class="text-muted text-center">Have any questions? We’d love to hear from you.</p>
                <div class="text-center">
                    <a href="#" class="btn btn-outline-primary btn-custom">Get in Touch</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p class="mb-0">&copy; <?= date("Y"); ?> Developed by <a class="text-white" target="_blank" href="https://sumonprodev.wixsite.com/sumonprodhan">Sumon Prodhan</a></p>
</footer>
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
