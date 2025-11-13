<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog | Blog Application</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/blog.css">
</head>

<body>
  <?php include 'navbar.php'; ?>
  <!-- Page Header -->
  <section class="page-header bg-info">
    <div class="container">
      <h1>Our Blog</h1>
    </div>
  </section>

  <!-- Blog Content -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4 align-items-start">
        <!-- Blog Posts -->
        <div class="col-lg-8">

          <?php
          // pagination parameters
          $posts_per_page = 5;
          $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
          if ($current_page < 1) {
            $current_page = 1;
          }
          $offset = ($current_page - 1) * $posts_per_page;

          // page search query
          $search_term = isset($_GET['q']) ? trim($_GET['q']) : '';
          $query_params = [];
          $where_clause = '';

          if (!empty($search_term)) {
            $where_clause = " WHERE (title LIKE :search_term OR description LIKE :search_term) AND status = 'publish'";
            $query_params[':search_term'] = '%' . $search_term . '%';
          } else {
            $where_clause = " WHERE status = 'publish'";
          }

          //number of posts for pagination
          $count_sql = "SELECT COUNT(*) FROM blogs" . $where_clause;
          $count_stmt = $conn->prepare($count_sql);
          $count_stmt->execute($query_params);
          $total_posts = $count_stmt->fetchColumn();
          $total_pages = ceil($total_posts / $posts_per_page);

          //Fetch for current page
          $sql = "SELECT *, slug FROM blogs" . $where_clause . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
          $stmt = $conn->prepare($sql);

          // Bind search params
          foreach ($query_params as $key => &$val) {
            $stmt->bindParam($key, $val);
          }

          // Bind pagination params
          $stmt->bindParam(':limit', $posts_per_page, PDO::PARAM_INT);
          $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

          $stmt->execute();
          $blogs = $stmt->fetchAll(PDO::FETCH_OBJ);

          if (!empty($blogs)) {
            foreach ($blogs as $blog) {
              $description = strip_tags($blog->description);
              if (strlen($description) > 100) {
                $description = substr($description, 0, 400) . '...';
              }

          ?>
              <div class="blog-card mb-4">
                <img class="blog-card-img" style="height: 300px; width: 100%; object-fit: cover;" src="./assets/images/blogs/<?php echo htmlspecialchars($blog->image); ?>" alt="<?php echo htmlspecialchars($blog->title); ?>">
                <div class="blog-card-body">
                  <h4><?php echo htmlspecialchars($blog->title); ?></h4>
                  <p class="my-4"><?php echo htmlspecialchars($description); ?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <a href="blog_details.php?slug=<?= urlencode($blog->slug) ?>" class="btn btn-primary">Read More</a>
                    </div>
                    <small class="text-muted">Posted on <?php echo date('F j, Y', strtotime($blog->created_at)); ?></small>
                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            echo '<div class="alert alert-warning">No posts found.</div>';
          }
          ?>

        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
          <div class="sticky-top">
            <!-- Search -->
            <div class="sidebar mb-4 p-4 bg-light rounded">
              <h5 class="mb-3">Search</h5>
              <form action="blog.php" method="GET">
                <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Search posts...">
                  <button class="btn btn-primary" type="submit">Go</button>
                </div>
              </form>
            </div>

            <!-- Recent Posts -->
            <?php
            $recent_sql = "SELECT id, title, slug, image, created_at FROM blogs WHERE status = 'publish' ORDER BY created_at DESC LIMIT 5";
            $recent_result = $conn->query($recent_sql);
            $recent_blogs = $recent_result->fetchAll(PDO::FETCH_OBJ);
            // print_r($recent_blogs);
            if (!$recent_blogs) {
              echo '<div class="alert alert-warning">No recent posts found.</div>';
            }
            
            
            ?>
            <div class="sidebar mb-4 p-4 bg-light rounded">
              <h5 class="mb-3">Recent Posts</h5>
              <ul class="list-unstyled">
                <?php foreach ($recent_blogs as $recent): 
                  $title = strlen($recent->title) > 20 ? substr($recent->title, 0, 50) . '...' : $recent->title;
                  ?>
                  <li class="d-flex mb-3">
                    <img src="./assets/images/blogs/<?php echo htmlspecialchars($recent->image); ?>"
                      alt="" class="me-3 rounded-2" style="width: 100px; height: 65px;">
                    <div>
                      <a href="blog_details.php?slug=<?php echo urlencode($recent->slug); ?>" class="text-decoration-none">
                        <?php echo htmlspecialchars($title); ?>
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
    </div>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <!-- Pagination -->
          <?php if (isset($total_pages) && $total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-5">
              <ul class="pagination justify-content-center">
                <?php
                $query_string = '';
                if (!empty($search_term)) {
                  $query_string .= '&q=' . urlencode($search_term);
                }
                ?>

                <!-- Previous Button -->
                <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                  <a class="page-link" href="?page=<?php echo $current_page - 1; ?><?php echo $query_string; ?>">Previous</a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                  <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?><?php echo $query_string; ?>"><?php echo $i; ?></a>
                  </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                  <a class="page-link" href="?page=<?php echo $current_page + 1; ?><?php echo $query_string; ?>">Next</a>
                </li>
              </ul>
            </nav>
          <?php endif; ?>
        </div>
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