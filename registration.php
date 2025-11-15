<?php include 'config.php';
include './helpers/helper.php';
$data = [];
$error = [];

if (isset($_POST['register'])) {
    $name = validation($_POST['name']);
    $email = validation($_POST['email']);
    $phone = validation($_POST['phone']);
    $gender = validation($_POST['gender']);
    $password = validation($_POST['password']);
    $confirm_password = validation($_POST['confirm_password']);


    if (!empty($name)) {
        if (!preg_match("/^[a-zA-Z . ]*$/", $name)) {
            $error['name'] = "Only letters and white space allowed";
        } else {
            $data['name'] = $name;
        }
    } else {
        $error['name'] = "Name is required";
    }

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
            $hashpass = password_hash($password, PASSWORD_DEFAULT);
            $data['password'] = $hashpass;
        }
    } else {
        $error['password'] = "Password is required";
    }
    if (!empty($confirm_password)) {
        if ($password != $confirm_password) {
            $error['confirm_password'] = "Password does not match";
        } else {
            $data['confirm_password'] = $confirm_password;
        }
    } else {
        $error['confirm_password'] = "Confirm Password is required";
    }

    if (!empty($phone)) {
        if (preg_match('/^\+?\d{7,15}$/', $phone)) {
            $data['phone'] = $phone;
        } else {
            $error['phone'] = "Invalid phone number";
        }
    } else {
        $error['phone'] = "Phone number is required";
    }



    if (!empty($gender)) {
        $allowed_genders = ["Male", "Female", "Other"];
        if (!in_array($gender, $allowed_genders)) {
            $error['gender'] = "Invalid gender";
        } else {
            $data['gender'] = $gender;
        }
    } else {
        $error['gender'] = "Gender is required";
    }

    if (isset($_FILES['image'])) {
        $fileName = $_FILES['image']['name'];
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];
        $fileError = $_FILES['image']['error'];
        $fileType = $_FILES['image']['type'];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExt = ["jpg", "jpeg", "png", "webp"];

        if (in_array($fileExt, $allowedExt)) {
            if ($fileError === 0) {
                if ($fileSize < 5000000) {
                    $newFileName = uniqid('', true) . "." . date('ymd') . "." . $fileExt;
                    $fileDestination = 'assets/images/users/' . $newFileName;
                    $data['image'] = $newFileName;
                } else {
                    $error['image'] = "File size is too large (5MB)";
                }
            } else {
                $error['image'] = "There was an error uploading your file";
            }
        } else {
            $error['image'] = "Unsupported file type";
        }
    }

    if (empty($error)) {
        // print_r($data);
        try {
            $sql = "INSERT INTO users (name, email, password, phone, gender, image) VALUES (:name, :email, :password, :phone, :gender, :image)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':gender', $data['gender']);
            $stmt->bindParam(':image', $data['image']);
            $stmt->execute();
            
            move_uploaded_file($fileTmpName, $fileDestination);
            $_SESSION['success_message'] = "Your account created successfully";
            header('location: login.php');
            unset($data);
        } catch (PDOException $e) {
            $error['database'] = $e->getMessage();
        }

    }
}


?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>
    <section style="background-color: #0f172a; color: aliceblue;">
        <div class="container py-2">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <span class=" me-4">📞 +8801402-042826</span>
                    <span >📧 sumonpro.dev@gmail.com</span>
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
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>

            <div class="register-card">
                <h3>Create Account</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?= $data['name'] ?? ''; ?>" required />
                        <span class="text-danger"><?= $error['name'] ?? ''; ?></span>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email Address" value="<?= $data['email'] ?? ''; ?>" required />
                        <span class="text-danger"><?= $error['email'] ?? ''; ?></span>
                        <span class="text-danger"><?= $error['database'] ?? ''; ?></span>
                    </div>
                    <div class="mb-3 position-relative">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                        <span class="text-danger"><?= $error['password'] ?? ''; ?></span>
                        <div class="register-overlay" id="eye1">
                            <i class="bi bi-eye-slash"></i>
                        </div>
                    </div>
                    <div class="mb-3 position-relative">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required />
                        <span class="text-danger"><?= $error['confirm_password'] ?? ''; ?></span>
                        <div class="register-overlay" id="eye2">
                            <i class="bi bi-eye-slash"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="tel" name="phone" class="form-control" placeholder="Phone Number" value="<?= $data['phone'] ?? ''; ?>" required />
                        <span class="text-danger"><?= $error['phone'] ?? ''; ?></span>
                    </div>
                    <div class="mb-3">
                        <select name="gender" class="form-control custom-select" required>
                            <option value="" selected disabled>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="image" class="form-control" required />
                        <span class="text-danger"><?= $error['image'] ?? ''; ?></span>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary home_page_btn w-100">Register</button>
                    <span class="text-success"><?= $success ?? ''; ?></span>
                </form>
                <div class="text-center mt-3">
                    <p>Already have an account? <a href="login.php" class="text-primary reg-login-here">Login here</a></p>
                </div>
            </div>
        </div>
    </main>
   
    <div class="main-footeer">
        <?php include 'footer.php'; ?>
    </div>

    <script src="./assets/main.js"></script>
    <script>
        const passwordInput = document.getElementById('password');
        const eye1 = document.getElementById('eye1');

        eye1.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.innerHTML = '<i class="bi bi-eye"></i>';
            } else {
                passwordInput.type = 'password';
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            }
        });

        const confirmPasswordInput = document.getElementById('confirm_password');
        const eye2 = document.getElementById('eye2');

        eye2.addEventListener('click', function() {
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                this.innerHTML = '<i class="bi bi-eye"></i>';
            } else {
                confirmPasswordInput.type = 'password';
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            }
        });
    </script>
</body>
