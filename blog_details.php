<?php
include_once 'config.php';

$blog_slug = isset($_GET['slug']) ? $_GET['slug'] : null;

if (!$blog_slug) {
    header("Location: blog.php");
    exit;
}

$sql = "SELECT * FROM blogs WHERE slug = :slug";
$stmt = $conn->prepare($sql);
$stmt->execute([':slug' => $blog_slug]);
$blog = $stmt->fetch(PDO::FETCH_OBJ);

if (!$blog) {
    header("Location: blog.php");
    exit;
}

$recent_sql = "SELECT id, title, slug, image, created_at FROM blogs ORDER BY created_at DESC LIMIT 5";
$recent_result = $conn->query($recent_sql);
$recent_blogs = $recent_result->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($blog->title); ?> | Blog Application</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/blog.css">
  <style>
    .blog-detail-img {
      height: 400px;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .blog-meta {
      color: #6c757d;
      font-size: 0.95rem;
    }
    .blog-content {
      line-height: 1.8;
      color: #333;
      font-size: 20px;
    }
    .sidebar h5 {
      font-weight: 600;
      border-bottom: 2px solid #007bff;
      padding-bottom: 8px;
    }
    .recent-post-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }
    .breadcrumb a {
      color: #007bff;
      text-decoration: none;
    }
    .breadcrumb a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <?php include 'navbar.php'; ?>

  <!-- Page Header -->
  <section class="page-header bg-info text-white py-5">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
          <li class="breadcrumb-item"><a href="blog.php" class="text-white">Blog</a></li>
          <li class="breadcrumb-item active text-white" aria-current="page">Post</li>
        </ol>
      </nav>
      <h2 class="mt-5"><?php echo htmlspecialchars($blog->title); ?></h2>
    </div>
  </section>

  <!-- Blog Detail Content -->
  <section class="py-5">
    <div class="container">
      <div class="row g-5">
        <!-- Main Content -->
        <div class="col-lg-8">
          <article class="blog-detail">
            <!-- Blog Image -->
            <img src="./assets/images/blogs/<?php echo htmlspecialchars($blog->image); ?>" 
                 alt="<?php echo htmlspecialchars($blog->title); ?>" 
                 class="img-fluid blog-detail-img w-100 mb-4">

            <!-- Meta Info -->
            <div class="blog-meta mb-4">
              <span><i class="bi bi-calendar"></i> Posted on <?php echo date('F j, Y', strtotime($blog->created_at)); ?></span>
              <?php if (!empty($blog->category)): ?>
                <span class="mx-3">•</span>
                <span><i class="bi bi-tag"></i> <?php echo htmlspecialchars($blog->category); ?></span>
              <?php endif; ?>
            </div>

            <!-- Blog Content -->
            <div class="blog-content">
              <?php echo $blog->content ?? $blog->description; ?>
            </div>

            <!-- Tags (if you have) -->
            <?php if (!empty($blog->tags)): ?>
              <div class="mt-5">
                <strong>Tags:</strong>
                <?php 
                $tags = explode(',', $blog->tags);
                foreach ($tags as $tag): 
                ?>
                  <span class="badge bg-secondary me-1"><?php echo trim(htmlspecialchars($tag)); ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <!-- Share Buttons -->
            <div class="mt-5 pt-4 border-top">
              <strong>Share this post:</strong>
              <div class="mt-2">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
                   target="_blank" class="btn btn-outline-primary btn-sm">
                  <i class="bi bi-facebook"></i> Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($blog->title); ?>" 
                   target="_blank" class="btn btn-outline-info btn-sm">
                  <i class="bi bi-twitter"></i> Twitter
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
                   target="_blank" class="btn btn-outline-linkedin btn-sm">
                  <i class="bi bi-linkedin"></i> LinkedIn
                </a>
              </div>
            </div>
          </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
          <!-- Recent Posts -->
          <div class="sidebar mb-4 p-4 bg-light rounded">
            <h5 class="mb-3">Recent Posts</h5>
            <ul class="list-unstyled">
              <?php foreach ($recent_blogs as $recent): 
              ?>
                <li class="d-flex mb-3">
                  <img src="./assets/images/blogs/<?php echo htmlspecialchars($recent->image); ?>" 
                       alt="" class="recent-post-img me-3">
                  <div>
                    <a href="blog_details.php?slug=<?= urlencode($recent->slug) ?>" class="text-decoration-none">
                      <?php echo htmlspecialchars($recent->title); ?>
                    </a>
                    <small class="d-block text-muted"><?php echo date('M j, Y', strtotime($recent->created_at)); ?></small>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- Categories -->
          <div class="sidebar p-4 bg-light rounded">
            <h5 class="mb-3">Categories</h5>
            <ul class="list-unstyled">
              <?php 
              $category_sql = "SELECT id, name FROM categories";
              $category_result = $conn->query($category_sql);
              $categories = $category_result->fetchAll(PDO::FETCH_OBJ);

              foreach ($categories as $category): ?>
                <li><a href="#" class="text-decoration-none"><?php echo htmlspecialchars($category->name); ?></a></li>
              <?php endforeach;
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <div class="footer">
    <?php include 'footer.php'; ?>
  </div>

  <!-- Bootstrap Icons (for social icons) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>