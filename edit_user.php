<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}

$user_id_to_edit = $_GET['id'];

// If the user is not an admin, they can only edit their own profile
if ($_SESSION['role'] !== 'admin' && $_SESSION['user_id'] != $user_id_to_edit) {
    header('location: user_dashboard.php');
    exit;
}

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id_to_edit);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_OBJ);
}

if (isset($_POST['update_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if ($_SESSION['role'] === 'admin') {
        $role = $_POST['role'];
        $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, role = :role WHERE id = :id");
        $stmt->bindParam(':role', $role);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
    }

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $user_id_to_edit);

    if ($stmt->execute()) {
        $_SESSION['success'] = "User updated successfully.";
        if ($_SESSION['role'] === 'admin') {
            header('location: manage_users.php');
        } else {
            header('location: user_dashboard.php');
        }
        exit;
    } else {
        $_SESSION['error'] = "Failed to update user.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Profile </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            padding: 15px 30px;
        }

        .navbar-brand {
            font-weight: 700;
            color: #0d6efd !important;
            letter-spacing: 0.5px;
        }

        .btn-back {
            border-radius: 8px;
            background-color: #fff;
            color: #0d6efd;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #0d6efd;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="user_dashboard.php">My Profile</a>
            <a href="user_dashboard.php" class="btn btn-outline-primary btn-back">
                <i class="bi bi-box-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </nav>
    <div class="container my-5">
        <div class="row justify-content-center ">
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Update Profile</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user->name) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user->email) ?>">
                            </div>
                            <?php if ($_SESSION['role'] === 'admin') : ?>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role">
                                        <option value="user" <?= $user->role === 'user' ? 'selected' : '' ?>>User</option>
                                        <option value="author" <?= $user->role === 'author' ? 'selected' : '' ?>>Author</option>
                                        <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                </div>
                            <?php endif; ?>
                            <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                            <a href="<?= $_SESSION['role'] === 'admin' ? 'manage_users.php' : 'user_dashboard.php' ?>" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>