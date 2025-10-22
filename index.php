<?php include 'config.php';
session_start();


$data = [];
$error = [];

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Invalid email format";
        } else {
            $data['email'] = $email;
        }
    } else {
        $error['email'] = "Email is required";
    }


    if (!empty($password)) {
        if (strlen($password) < 3) {
            $error['password'] = "Password must be at least 8 characters";
        } else {
            $data['password'] = $password;
        }
    } else {
        $error['password'] = "Password is required";
    }

    if (empty($error)) {

        $admin = [
            'email' => 'me@admin.com',
            'password' => '1234'
        ];
        $user = [
            'email' => 'me@user.com',
            'password' => '4321'
        ];

        if ($data['email'] == $admin['email']) {
            if ($data['password'] == $admin['password']) {
                $_SESSION['admin'] = $admin['email'];
                $_SESSION['password'] = $admin['password'];
                header('location: admin_dashboard.php');
            } else {
                $error['password'] = "Invalid password";
            }
        } else {
            $error['email'] = "Invalid email";
        }


        if ($data['email'] == $user['email']) {
            if ($data['password'] == $user['password']) {
                $_SESSION['user'] = $user['email'];
                $_SESSION['password'] = $user['password'];
                header('location: user_dashboard.php');
            } else {
                $error['password'] = "Invalid password";
            }
        } else {
            $error['email'] = "Invalid email";
        }
    }
}

if (isset($_POST['guest'])) {
    $_SESSION['guest'] = true;
    header("Location: guest_dashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Dashboard Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>

    <main>
        <div class="home_page">
            <!-- Floating Shapes -->
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>

            <div class="container-box text-center">
                <h2 class="fw-bold mb-3">Welcome to our Learning Portal</h2>
                <p class="text-light mb-4">Choose your access type below to continue</p>

                <div class="row g-4 justify-content-center align-items-center">

                    <!-- Guest Access -->
                    <div class="col-md-4">
                        <div class="card-section">
                            <h4 class="mb-2">👤 Guest Access</h4>
                            <p class="small">Explore as a guest without login.</p>
                            <form method="POST">
                                <button name="guest" class="btn btn-success home_page_btn w-100">Enter as Guest</button>
                            </form>
                        </div>
                    </div>

                    <!-- Login Access -->
                    <div class="col-md-6">
                        <div class="card-section">
                            <h4 class="mb-3">🔐 Login (User/Admin)</h4>
                            <!-- <div class="alert alert-warning py-2 text-white"></div> -->

                            <form method="POST">
                                <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                                <div class="position-relative">
                                    <input type="password" name="password" id="login-password" class="form-control mb-3" placeholder="Password" required>
                                    <div class="register-overlay" id="loginEye">
                                        <i class="bi bi-eye-slash"></i>
                                    </div>
                                </div>

                                <button name="login" class="btn btn-primary home_page_btn w-100">Login</button>
                            </form>
                            <p class="mt-3 small text-light">
                                Demo: me@admin.com - 1234 <br> me@user.com - 4321
                            </p>
                            <p class="mt-3 mb-0 small text-light dont-have-account">
                                Don’t have an account?
                                <a href="registration.php" class="fw-bold text-primary">Create one</a>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="footer">
                    <hr class="text-white">
                    <small>© <?= date("Y"); ?> Developed by <a class="text-white" target="_blank" href="https://sumonprodev.wixsite.com/sumonprodhan">Sumon Prodhan</a></small>
                </div>
            </div>
        </div>
    </main>
    <script>
        const loginPasswordInput = document.getElementById('login-password');
        const loginEye = document.getElementById('loginEye');

        loginEye.addEventListener('click', function() {
            if (loginPasswordInput.type === 'password') {
                loginPasswordInput.type = 'text';
                this.innerHTML = '<i class="bi bi-eye"></i>';
            } else {
                loginPasswordInput.type = 'password';
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            }
        });
    </script>
</body>

</html>