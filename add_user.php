<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add User</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">Add New User</h2>

  <form action="insert_user.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Phone</label>
      <input type="text" name="phone" class="form-control">
    </div>

    <div class="mb-3">
      <label>Image</label>
      <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" name="submit" class="btn btn-success">Save User</button>
  </form>
</div>

</body>
</html>
