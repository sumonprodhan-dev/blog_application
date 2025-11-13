<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home | Blog Application</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/index.css">
</head>

<body>

  <?php include 'navbar.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-7">
          <h1>Welcome to My Web Application</h1>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto voluptatum impedit doloribus harum reiciendis enim, ipsa officiis.</p>
          <a href="login.php" class="hero-btn mt-3">Get Started</a>
        </div>
        <div class="col-md-5 d-flex justify-content-end">
          <img src="./assets/images/img/hero-image.webp" alt="Hero Image" style="width: 400px;" class="img-fluid ">
        </div>
      </div>
    </div>
    </div>
  </section>

  <!-- About Section -->
  <section class="py-5">
    <div class="container">
      <h2 class="section-title">About This Application</h2>
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">
          <p>This web application is built using PHP and MySQL. It includes multiple roles like Admin, User, and Guest — each with their own dashboard and functionalities. Registration and login systems are fully dynamic.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="section-title">Core Features</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature-box">
            <h4>🔐 User Authentication</h4>
            <p>Register and log in securely using PHP and MySQL validation.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <h4>📊 Dashboards</h4>
            <p>Separate dashboards for Admin, User, and Guest roles with role-based access.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <h4>👥 User Management</h4>
            <p>Admin can add, edit, or delete users easily with clean UI.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <h4>📝 Blog Management</h4>
            <p>Admin can add, edit, or delete blog posts easily with clean UI.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Blog Section -->

  <section class="py-5">
    <div class="container">
      <h2 class="section-title">Latest Blog Posts</h2>
      <div class="row g-4">
        <?php
        //  include 'config.php';

        $sql = "SELECT * FROM blogs order by id desc limit 3";
        $result = $conn->query($sql);
        $stmt = $result->fetchAll(PDO::FETCH_OBJ);
        //  print_r($stmt);
        foreach ($stmt as $blog) {
          $title = $blog->title;
          $description = $blog->description;
          if (strlen($title) > 50) {
            $title = substr($title, 0, 50) . '...';
          }
          if (strlen($description) > 100) {
            $description = strip_tags($description);
            $description = substr($description, 0, 100) . '...';
          } ?>
          <div class="col-md-4">
            <div class="card h-100 shadow-sm">
              <img src="./assets/images/blogs/<?php echo $blog->image; ?>" class="card-img-top img-fluid" alt="Blog 1" style="height: 200px; object-fit: cover;">
              <div class="card-body">
                <h5 class="card-title"><?php echo $title; ?></h5>
                <p class="card-text"><?php echo $description; ?></p>
              </div>
              <div class="card-footer bg-white border-0 mb-3">
                <a href="blog_details.php?slug=<?= urlencode($blog->slug) ?>" class="btn btn-primary">Read More</a>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <div class="footer">
    <?php include 'footer.php'; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>