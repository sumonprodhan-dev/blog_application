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
        if (strlen($password) < 3) {
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
        }else{
            $data['confirm_password'] = $confirm_password;
        }
    }else{
        $error['confirm_password'] = "Confirm Password is required";
    }

    if (!empty($phone)) {
        if (preg_match("/^[0-9]*$/", $phone)) {
            if (strlen($phone) == 11) {
                $data['phone'] = $phone;
            } else {
                $error['phone'] = "Phone number must be 11 digits";
            }
        } else {
            $error['phone'] = "Phone number must be numeric";
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

    



}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
                <form action="register_process.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?= $data['name'] ?? " ";?>" required />
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email Address" value="<?= $data['email'] ?? " ";?>" required />
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required />
                    </div>
                    <div class="mb-3">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required />
                    </div>
                    <div class="mb-3">
                        <input type="tel" name="phone" class="form-control" placeholder="Phone Number" value="<?= $data['phone'] ?? " ";?>" required />
                    </div>
                    <div class="mb-3">
                        <select name="gender" class="form-control custom-select" value="<?= $data['gender'] ?? " ";?>" required>
                            <option value="" selected disabled>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="profile_image" class="form-control" required />
                    </div>
                    <button type="submit" name="register" class="btn btn-primary home_page_btn w-100">Register</button>
                </form>
                <div class="text-center mt-3">
                    <p>Already have an account? <a href="index.php" class="text-primary reg-login-here">Login here</a></p>
                </div>
            </div>
        </div>
    </main>

</body>

</html>