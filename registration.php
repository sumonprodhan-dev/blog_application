<?php include 'config.php';

session_start();

function validation($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

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
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
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
            $data['password'] = $password;
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
        if (!preg_match("/^[0-9]*$/", $phone)) {
            if (preg_replace("/[^0-9]/", "", $phone)) {
                $data['phone'] = $phone;
            }
        }
    } else {
        $error['phone'] = "Phone is required";
    }


    if (!empty($gender)) {
        $allowed_genders = ["male", "female", "other"];
        if (!in_array($gender, $allowed_genders)) {
            $error['gender'] = "Invalid gender";
        } else {
            $data['gender'] = $gender;
        }
    } else {
        $error['gender'] = "Gender is required";
    }

    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_type = $file['type'];
        $file_error = $file['error'];

        $allowEex = ["jpg", "jpeg", "png", "webp"];
        $file_Eex = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_Eex, $allowEex)) {
            if ($file_error === 0) {
                if ($file_size <= 5000000) {
                    $new_file_name = uniqid("", true) . "_" . date("Y-m-d") .  "." . $file_Eex;
                    $file_destination = "./images/users/" . $new_file_name;
                    move_uploaded_file($file_tmp, $file_destination);
                    $data['image'] = $file_destination;
                } else {
                    $error['image'] = "File size is too large";
                }
            }
        } else {
            $error['image'] = "File type is not allowed";
        }
    }

    if (empty($error)) {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $phone = $data['phone'];
        $gender = $data['gender'];
        $image = $data['image'];
    }

    echo "<pre>";
    print_r($data);
    print_r($error);
    echo "</pre>";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/style.css" />
</head>

<body>
    <main>
        <div class="home_page">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>

            <div class="register-card">
                <h3>Create Account</h3>
                <form action="registration.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Full Name" required />
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email Address" required />
                    </div>
                    <div class="mb-3 position-relative">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                        <div class="register-overlay" id="eye1">
                            <i class="bi bi-eye-slash"></i>
                        </div>
                    </div>
                    <div class="mb-3 position-relative">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required />
                        <div class="register-overlay" id="eye2">
                            <i class="bi bi-eye-slash"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required />
                    </div>
                    <div class="mb-3">
                        <select name="gender" class="form-control custom-select" required>
                            <option value="" selected disabled>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="image" class="form-control" required />
                    </div>
                    <button type="submit" name="register" class="btn btn-primary home_page_btn w-100">Register</button>
                </form>
                <div class="text-center mt-3">
                    <p>Already have an account? <a href="index.php" class="text-primary reg-login-here">Login here</a></p>
                </div>
            </div>
        </div>
    </main>
    <script src="./assets/main.js"></script>
</body>

</html>