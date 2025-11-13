<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
  header('location: login.php');
  exit();
}

$sql = "SELECT * FROM users WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_OBJ);


$sql = "SELECT * FROM blogs WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$blog = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/user_dashboard.css">
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center my-3">My User Panel</h4>
    <a href="#" class="active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
    <a href="create_blog.php"><i class="bi bi-plus-circle me-2"></i> Create Post</a>
    <a href="#"><i class="bi bi-journal-text me-2"></i> My Posts</a>
    <a href="#"><i class="bi bi-person-lines-fill me-2"></i> Edit Profile</a>
    <a href="index.php" class="text-info"><i class="bi bi-box-arrow-left me-2 text-info"></i> Back to Website</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="d-flex justify-content-between align-items-center">
      <h3 class="mb-4">Welcome, <?= htmlspecialchars($user->name) ?> 👋</h3>
    </div>

    <!-- Profile Card -->
    <div class="profile-card mb-4">
      <div class="row align-items-center">
        <div class="col-md-2 text-center">
          <img src="./assets/images/users/<?= $user->image ?>" alt="Profile Picture">
        </div>
        <div class="col-md-8">
          <h5><?= htmlspecialchars($user->name) ?></h5>
          <p class="text-muted mb-1"><?= htmlspecialchars($user->email) ?></p>
          <p><strong>Total Blogs:</strong></p>
        </div>
        <div class="col-md-2 text-end">
          <a href="#" class="btn btn-custom"><i class="bi bi-pencil-square me-1"></i> Edit Profile</a>
        </div>
      </div>
    </div>

    <!-- Create Post Button -->
    <div class="mb-4">
      <a href="create_blog.php" class="btn btn-custom"><i class="bi bi-plus-circle me-1"></i> Create New Post</a>
    </div>

    <!-- Recent Posts Table -->
    <?php
    if(count($blog) > 0) {?>
      <div class="card shadow-sm border-0">
      <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold">My Recent Posts</h5>
      </div>
      <div class="card-body">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th>Title</th>
              <th>Status</th>
              <th>Date</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($blog as $post) : ?>
              <tr>
                <td><?= htmlspecialchars($post->title) ?></td>
                <td>
                  <span class="badge bg-success">
                    <?= htmlspecialchars($post->status) ?>
                  </span>
                </td>
                <td><?= htmlspecialchars($post->created_at) ?></td>
                <td class="text-center">
                  <a href="edit_blog.php?id=<?= $post->id ?>" class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-pencil-square"></i></a>
                  <a href="delete_blog.php?id=<?= $post->id ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    
    <?php }else{ ?>
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold">My Recent Posts</h5>
      </div>
      <div class="card-body">
        <p class="text-muted">No blog posts found.</p>
      </div>
    </div>
    <?php }
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
