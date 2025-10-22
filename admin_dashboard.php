<?php include 'config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('location: index.php');
    exit;
}

$sql = "SELECT id, name, email, phone, gender, joined FROM users";
$result = mysqli_query($conn, $sql);


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
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body class="bg-light">

    <!-- Sidebar -->
    <div class="admin_page_sidebar" id="sidebar">
        <h4><i class="bi bi-gear-fill"></i> Admin Panel</h4>
        <a href="#" class="active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="#"><i class="bi bi-people-fill me-2"></i> Users</a>
        <a href="#"><i class="bi bi-gear-wide-connected me-2"></i> Settings</a>
        <a href="#"><i class="bi bi-bar-chart-line-fill me-2"></i> Reports</a>
        <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Topbar -->
        <div class="admin_page_topbar shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-list" id="menuToggle"></i>
                <h5 class="mb-0">Welcome, Admin</h5>
            </div>
            <div>
                <i class="bi bi-bell-fill me-3 text-secondary fs-5"></i>
                <img src="./assets/images/sumonpro.dev@gmail.com.png" 
                     alt="Admin" width="50" height="50" class="rounded-circle border">
            </div>
        </div>

        <!-- Stats Section -->
        <div class="row mt-4 g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card text-center p-4">
                    <i class="bi bi-people-fill text-primary fs-2 mb-2"></i>
                    <h6>Total Users</h6>
                    <h3>120</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center p-4">
                    <i class="bi bi-person-check-fill text-success fs-2 mb-2"></i>
                    <h6>Active Users</h6>
                    <h3>98</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center p-4">
                    <i class="bi bi-hourglass-split text-warning fs-2 mb-2"></i>
                    <h6>Pending Tasks</h6>
                    <h3>14</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center p-4">
                    <i class="bi bi-file-earmark-bar-graph-fill text-danger fs-2 mb-2"></i>
                    <h6>Reports</h6>
                    <h3>5</h3>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card mt-5 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 text-black fw-bold"><i class="bi bi-people me-2 text-primary"></i> Registered Users</h5>
                <button class="btn btn-sm btn-primary" href="registration.php"><i class="bi bi-plus-circle me-1"></i> Add User</button>
            </div>
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['gender']; ?></td>
                                    <td><?php echo $row['joined']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
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
