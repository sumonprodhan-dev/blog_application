<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us | Blog Application</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* ===== Global Style ===== */
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8fafc;
    }

    /* ===== Hero Section ===== */
    .hero {
      background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)),
        url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1350&q=80');
      background-size: cover;
      background-position: center;
      color: #fff;
      text-align: center;
      padding: 100px 20px;
    }

    .hero h1 {
      font-weight: 700;
      font-size: 2.8rem;
    }

    .hero p {
      color: #cbd5e1;
      max-width: 700px;
      margin: 15px auto 0;
    }

    /* ===== About Section ===== */
    .about-section {
      padding: 80px 0;
    }

    .about-section img {
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .about-text h2 {
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 20px;
    }

    .about-text p {
      color: #475569;
      line-height: 1.7;
    }
  </style>
</head>

<body>
  <?php include 'navbar.php'; ?>
  <!-- ===== Hero Section ===== -->
  <section class="hero">
    <div class="container">
      <h1>About Our Company</h1>
      <p>We are passionate about building modern web experiences that blend creativity, functionality, and performance.</p>
    </div>
  </section>

  <!-- ===== About Section ===== -->
  <section class="about-section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-md-6">
          <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=800&q=80" alt="About Image">
        </div>
        <div class="col-md-6 about-text">
          <h2>Who We Are</h2>
          <p>
            We are a team of creative developers and designers dedicated to crafting modern, scalable, and user-friendly digital experiences.
            Our mission is to empower businesses with innovative online solutions that make an impact.
          </p>
          <p>
            From small startups to large enterprises, we deliver excellence through dedication, innovation, and teamwork.
          </p>
        </div>
      </div>
    </div>
  </section>

  <div class="footer">
    <?php include 'footer.php'; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>