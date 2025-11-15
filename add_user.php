<!DOCTYPE html>
<html lang="en">
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
?>
<head>
  <meta charset="UTF-8">
  <title>Add User | Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="./assets/css/add_user.css">
</head>

<body>

  <!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <?php if($user->role === 'admin'){
        echo '<a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>';
      }else{
        echo '<a class="navbar-brand" href="admin_dashboard.php">Author Dashboard</a>';
      }
        ?>
      <a href="admin_dashboard.php" class="btn btn-outline-primary btn-back">
        <i class="bi bi-box-arrow-left me-2"></i>Back to Dashboard
      </a>
    </div>
  </nav>
  <?php
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
  }



  ?>
  <!-- Add User Form -->
  <div class="container flex-grow-1 d-flex justify-content-center align-items-center py-5">
    <div class="col-md-7">
      <div class="card p-4 p-md-5">
        <h2>Add New User</h2>
        <form action="admin_dashboard.php" method="POST" enctype="multipart/form-data">
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
            </div>

            <div class="col-md-6">
              <label>Email</label>
              <input type="email" name="email" class="form-control" placeholder="Enter email address" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>

            <div class="col-md-6">
              <label>Phone</label>
              <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Gender</label>
              <select name="gender" class="form-select">
                <option value="" selected disabled>Select Gender</option>
                <option value="admin">Male</option>
                <option value="user">Female</option>
                <option value="manager">Other</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Role</label>
              <select name="role" class="form-select">
                <option value="" selected disabled>Select Role</option>
                <option value="admin">Admin</option>
                <option value="user">Manager</option>
                <option value="manager">User</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
          </div>

          <div class="d-grid mt-4">
            <button type="submit" name="submit" class="btn btn-success">Save User</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include('footer.php'); ?>

</body>

</html>