<?php
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('location: login.php');
    exit;
}

if (isset($_GET['id']) && isset($_GET['role'])) {
    $user_id = $_GET['id'];
    $role = $_GET['role'];

    // Prevent changing the role of the currently logged-in admin
    if ($user_id == $_SESSION['user_id']) {
        $_SESSION['error'] = "You cannot change your own role.";
        header('location: admin_dashboard.php');
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET role = :role WHERE id = :id");
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id', $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Role changed successfully";
    } else {
        $_SESSION['error'] = "Failed to update user role.";
    }
}

header('location: admin_dashboard.php');
exit;
?>