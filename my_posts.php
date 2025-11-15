<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT blogs.*, users.name AS author_name FROM blogs JOIN users ON blogs.user_id = users.id WHERE blogs.user_id = :user_id ORDER BY blogs.created_at DESC");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/css/user_dashboard.css">
</head>

<body class="bg-light">

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center my-3">My User Panel</h4>
        <a href="user_dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="create_blog.php"><i class="bi bi-plus-circle me-2"></i> Create Post</a>
        <a href="my_posts.php" class="active"><i class="bi bi-journal-text me-2"></i> My Posts</a>
        <a href="edit_user.php?id=<?= $_SESSION['user_id'] ?>"><i class="bi bi-person-lines-fill me-2"></i> Edit Profile</a>
        <a href="index.php" class="text-info"><i class="bi bi-box-arrow-left me-2 text-info"></i> Back to Website</a>
        <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h3 class="mb-0">My Posts</h3>
            <a href="create_blog.php" class="btn btn-custom"><i class="bi bi-plus-circle me-1"></i> Create New Post</a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0">All My Blog Posts</h5>
            </div>
            <div class="card-body">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($blogs) > 0) : ?>
                            <?php foreach ($blogs as $key => $blog) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= htmlspecialchars($blog->title) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $blog->status === 'publish' ? 'success' : 'warning' ?>">
                                            <?= htmlspecialchars(ucfirst($blog->status)) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M, Y', strtotime($blog->created_at)) ?></td>
                                    <td class="text-center">
                                        <a href="edit_blog.php?id=<?= $blog->id ?>" class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-pencil-square"></i></a>
                                        <a href="delete_blog.php?id=<?= $blog->id ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">No posts found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>