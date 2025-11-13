<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_OBJ);

// Fetch total users
$total_users_stmt = $conn->query("SELECT COUNT(*) FROM users");
$total_users = $total_users_stmt->fetchColumn();

// Fetch total blog posts
$total_posts_stmt = $conn->query("SELECT COUNT(*) FROM blogs");
$total_posts = $total_posts_stmt->fetchColumn();

// Fetch total authors
$total_authors_stmt = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'author'");
$total_authors = $total_authors_stmt->fetchColumn();

// Fetch recent users
$recent_users_stmt = $conn->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5");
$recent_users = $recent_users_stmt->fetchAll(PDO::FETCH_OBJ);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/css/admin_dashboard.css">
</head>

<body class="bg-light">

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="mt-4"><i class="bi bi-gear-fill me-2"></i> Admin Panel</h4>
        <a href="admin_dashboard.php" class="active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="manage_users.php"><i class="bi bi-people me-2"></i> Manage Users</a>
        <a href="manage_blogs.php"><i class="bi bi-journal-text me-2"></i> Manage Blogs</a>
        <a href="add_user.php"><i class="bi bi-person-plus me-2"></i> Add User</a>
        <a href="#"><i class="bi bi-gear me-2"></i> Settings</a>
        <a href="index.php" class="text-info"><i class="bi bi-box-arrow-left me-2 text-info"></i> Back to Website</a>
        <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="admin_page_topbar shadow-sm mb-5">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-list" id="menuToggle"></i>
                <h5 class="mb-0">Welcome,</h5>
            </div>
            <div>
                <i class="bi bi-bell-fill me-3 text-secondary fs-5"></i>
                <img src="./assets/images/users/<?php echo $user->image; ?>"
                    alt="Admin" width="50" height="50" class="rounded-circle border">
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card-stats d-flex align-items-center justify-content-between">
                    <div>
                        <h5>Total Users</h5>
                        <h3 class="fw-bold"><?= $total_users ?></h3>
                    </div>
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-stats d-flex align-items-center justify-content-between">
                    <div>
                        <h5>Total Blog Posts</h5>
                        <h3 class="fw-bold"><?= $total_posts ?></h3>
                    </div>
                    <i class="bi bi-journal-text"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-stats d-flex align-items-center justify-content-between">
                    <div>
                        <h5>Total Authors</h5>
                        <h3 class="fw-bold"><?= $total_authors ?></h3>
                    </div>
                    <i class="bi bi-person-check"></i>
                </div>
            </div>
        </div>

        <!-- Recent Users Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0">User Activity Overview</h5>
            </div>
            <div class="card-body">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Posts</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_users as $key => $recent_user) : ?>
                            <?php
                            // Fetch post count for each user
                            $post_count_stmt = $conn->prepare("SELECT COUNT(*) FROM blogs WHERE user_id = :user_id");
                            $post_count_stmt->bindParam(':user_id', $recent_user->id);
                            $post_count_stmt->execute();
                            $post_count = $post_count_stmt->fetchColumn();
                            ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($recent_user->name) ?></td>
                                <td><?= htmlspecialchars($recent_user->email) ?></td>
                                <td>
                                    <span class="badge bg-<?= $recent_user->role === 'admin' ? 'success' : 'primary' ?>">
                                        <?= htmlspecialchars(ucfirst($recent_user->role)) ?>
                                    </span>
                                </td>
                                <td><?= $post_count ?></td>
                                <td class="text-center">
                                    <a href="edit_user.php?id=<?= $recent_user->id ?>" class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-pencil-square"></i></a>
                                    <?php if ($recent_user->id !== $_SESSION['user_id']) : ?>
                                        <a href="delete_user.php?id=<?= $recent_user->id ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                                        <?php if ($recent_user->role !== 'admin') : ?>
                                            <a href="change_role.php?id=<?= $recent_user->id ?>&role=<?= $recent_user->role === 'author' ? 'user' : 'author' ?>" class="btn btn-sm btn-custom">
                                                Make <?= $recent_user->role === 'author' ? 'User' : 'Author' ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar toggle for mobile
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('menuToggle');
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    </script>

</body>

</html>