
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
  /* ===== HEADER STYLE ===== */
  /* ===== HEADER STYLE ===== */
  .navbar {
    background: #ffffff !important;
    padding: 10px 0;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    position: relative;
    z-index: 1050;
  }

  .navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
    color: #000 !important;
    letter-spacing: 1px;
  }

  .navbar-nav .nav-link {
    color: #333 !important;
    font-weight: 500;
    margin: 0 12px;
    position: relative;
    transition: all 0.3s;
  }

  .navbar-nav .nav-link::after {
    content: "";
    position: absolute;
    width: 0%;
    height: 2px;
    left: 0;
    bottom: 0;
    background-color: #3b82f6;
    transition: width 0.3s;
  }

  .navbar-nav .nav-link:hover::after,
  .navbar-nav .nav-link.active::after {
    width: 100%;
  }

  .navbar-nav .nav-link:hover,
  .navbar-nav .nav-link.active {
    color: #3b82f6 !important;
  }

  .btn-login {
    background: #3b82f6;
    color: #fff;
    border: none;
    border-radius: 30px;
    padding: 8px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-login:hover {
    background: #2563eb;
    transform: translateY(-2px);
  }

  .dropdown-menu {
    z-index: 1070 !important;
  }

  @media (max-width: 991px) {
    .navbar-nav .nav-link {
      margin: 8px 0;
    }
  }
</style>
<?php
include_once 'config.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <i class="bi bi-globe2 text-primary me-2"></i>
      <span class="fw-bold text-uppercase text-primary me-5">SMN</span>
    </a>

    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center me-auto ms-0 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'about.php') ? 'active' : '' ?>" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'blog.php') ? 'active' : '' ?>" href="blog.php">Blogs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'contact.php') ? 'active' : '' ?>" href="contact.php">Contact</a>
        </li>
      </ul>

      <!-- ===== USER SECTION ===== -->
      <?php if (isset($_SESSION['user_id'])) : ?>
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="./assets/images/users/<?php echo htmlspecialchars(trim($_SESSION['user_image'] ?? '')); ?>" alt="Profile" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover; border: 2px solid #3b82f6;" onerror="this.src='./assets/images/users/default.png'">
            <span class="fw-bold text-uppercase text-primary">
              <?php
              $name = $_SESSION['user_name'] ?? '';
              echo htmlspecialchars(strpos($name, ' ') ? substr($name, 0, strpos($name, ' ')) : $name);
              ?>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
            <?php if ($_SESSION['role'] == 'admin') : ?>
              <li><a class="dropdown-item" href="admin_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a></li>
            <?php else : ?>
              <li><a class="dropdown-item" href="user_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
            <?php endif; ?>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </div>
      <?php else : ?>
        <a href="login.php" class="btn-login me-2 text-decoration-none">Login</a>
        <a href="registration.php" class="btn-login text-decoration-none">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>