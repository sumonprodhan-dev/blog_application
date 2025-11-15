<?php include 'config.php';
include './helpers/helper.php';

$data = [];
$error = [];
if (isset($_POST['login'])) {
    $email = validation($_POST['email']);
    $password = validation($_POST['password']);
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
        if (strlen($password) < 8) {
            $error['password'] = "Password must be at least 8 characters";
        } else {
            $data['password'] = $password;
        }
    } else {
        $error['password'] = "Password is required";
    }

// print_r($data);
    if (empty($error)) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $data['email']);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            // print_r($user);
            if ($user) {
                if (password_verify($data['password'], $user->password)) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['user_name'] = $user->name;
                    $_SESSION['user_email'] = $user->email;
                    $_SESSION['user_image'] = $user->image;
                    $_SESSION['role'] = $user->role;
                    print_r($_SESSION);
                    if ($user->role == 'admin') {
                        header('location: admin_dashboard.php');
                    } elseif ($user->role == 'user') {
                        header('location: user_dashboard.php');
                    } elseif ($user->role == 'author') {
                        header('location: admin_dashboard.php');
                    } else {
                        header('location: guest_dashboard.php');
                    }
                } else {
                    $error['password'] = "Invalid password";
                }
            } else {
                $error['database'] = "User not found";
            }
        } catch (PDOException $e) {
            $error['database'] = $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/style.css">
    <style>
        .register-overlay {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
        }

        .register-overlay:hover {
            color: #0d6efd;
        }
    </style>
</head>

<body>
    <section style="background-color: #0f172a; color: aliceblue;">
        <div class="container py-2">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <span class=" me-4">📞 +8801402-042826</span>
                    <span>📧 sumonpro.dev@gmail.com</span>
                </div>
                <div class="col-md-6 text-end">

                    <a href="https://www.facebook.com/sumonprodhan.dev" target="_blank" class="text-white"><i class="bi bi-facebook me-2"></i></a>
                    <a href="https://x.com/sumonpro_dev" class="text-white" target="_blank"><i class="bi bi-twitter me-2"></i></a>
                    <a href="https://www.instagram.com/sumonprodhan.dev/" target="_blank" class="text-white"><i class="bi bi-instagram me-2"></i></a>
                    <a href="https://www.linkedin.com/in/sumonprodhan-dev/" target="_blank" class="text-white"><i class="bi bi-linkedin me-4"></i></a>
                    <div class="d-inline-block">
                        <a href="index.php" class="btn btn-primary d-inline-block py-0"><i class="bi bi-box-arrow-left me-2 text-white"></i>Back</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

                    <!-- Login Access -->
                    <div class="col-md-6">
                        <div class="card-section">
                            <h4 class="mb-3">🔐 Login (User/Admin)</h4>
                            <!-- <div class="alert alert-warning py-2 text-white"></div> -->
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <input type="email" name="email" class="form-control " placeholder="Email" required>
                                <span class="text-danger mb-3 d-block"><?php echo $error['email'] ?? ''; ?></span>
                                <div class="position-relative">
                                    <input type="password" name="password" id="login-password" class="form-control " placeholder="Password" required>
                                    <span class="text-danger mb-3 d-block"><?= $error['password'] ?? ''; ?></span>
                                    <div class="register-overlay" id="loginEye">
                                        <i class="bi bi-eye-slash"></i>
                                    </div>

                                </div>

                                <button name="login" class="btn btn-primary home_page_btn w-100">Login</button>
                                <span class="text-danger mt-3 d-block"><?php echo $error['database'] ?? ''; ?></span>
                            </form>
                            <p class="mt-3 mb-0 small text-light dont-have-account">
                                Don’t have an account?
                                <a href="registration.php" class="fw-bold text-primary">Create one</a>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="login-footer">
                    <hr class="text-white">
                    <small>© <?= date("Y"); ?> Developed by <a class="text-white" target="_blank" href="https://sumonprodev.wixsite.com/sumonprodhan">Sumon Prodhan</a></small>
                </div>
            </div>
        </div>
    </main>

    <div class="">
        <?php include 'footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const loginPasswordInput = document.getElementById('login-password');
        // const loginEye = document.getElementById('loginEye');

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