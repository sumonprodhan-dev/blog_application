<?php
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('location: login.php');
    exit;
}

$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/css/admin_dashboard.css">
</head>

<body class="bg-light">

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="mt-4"><i class="bi bi-gear-fill me-2"></i> Admin Panel</h4>
        <a href="admin_dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="manage_users.php" class="active"><i class="bi bi-people me-2"></i> Manage Users</a>
        <a href="manage_blogs.php"><i class="bi bi-journal-text me-2"></i> Manage Blogs</a>
        <a href="add_user.php"><i class="bi bi-person-plus me-2"></i> Add User</a>
        <a href="#"><i class="bi bi-gear me-2"></i> Settings</a>
        <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="admin_page_topbar shadow-sm mb-5">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-list" id="menuToggle"></i>
                <h5 class="mb-0">Manage Users</h5>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0">All Users</h5>
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
                        <?php foreach ($users as $key => $user) : ?>
                            <?php
                            $post_count_stmt = $conn->prepare("SELECT COUNT(*) FROM blogs WHERE user_id = :user_id");
                            $post_count_stmt->bindParam(':user_id', $user->id);
                            $post_count_stmt->execute();
                            $post_count = $post_count_stmt->fetchColumn();
                            ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($user->name) ?></td>
                                <td><?= htmlspecialchars($user->email) ?></td>
                                <td>
                                    <span class="badge bg-<?= $user->role === 'admin' ? 'success' : 'primary' ?>">
                                        <?= htmlspecialchars(ucfirst($user->role)) ?>
                                    </span>
                                </td>
                                <td><?= $post_count ?></td>
                                <td class="text-center">
                                    <a href="edit_user.php?id=<?= $user->id ?>" class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-pencil-square"></i></a>
                                    <?php if ($user->id !== $_SESSION['user_id']) : ?>
                                        <a href="delete_user.php?id=<?= $user->id ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                                        <?php if ($user->role !== 'admin') : ?>
                                            <a href="change_role.php?id=<?= $user->id ?>&role=<?= $user->role === 'author' ? 'user' : 'author' ?>" class="btn btn-sm btn-custom">
                                                Make <?= $user->role === 'author' ? 'User' : 'Author' ?>
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