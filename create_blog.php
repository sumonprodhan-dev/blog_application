<!DOCTYPE html>
<html>
<?php
include_once 'config.php';
if (!function_exists('create_slug')) {
    function create_slug($string)
    {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9_\s-]/', '', $string);
        $string = preg_replace('/[\s-]+/', '-', $string);
        $string = trim($string, '-');
        return $string;
    }
}

$data = [];
$error = [];

if (isset($_POST['createBlog'])) {
    if (isset($_POST['title'])) {
        $data['title'] = $_POST['title'];
    } else {
        $error['title'] = "Title is required";
    }


    if (isset($_POST['content'])) {
        $data['content'] = $_POST['content'];
    } else {
        $error['content'] = "Content is required";
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
                    $fileDestination = 'assets/images/blogs/' . $newFileName;
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

    if (isset($_POST['status'])) {
        $allow = ["publish", "draft"];
        if (in_array($_POST['status'], $allow)) {
            $data['status'] = $_POST['status'];
        } else {
            $error['status'] = "Invalid status";
        }
    } else {
        $error['status'] = "Status is required";
    }

    if (isset($_POST['category'])) {
        $data['category'] = $_POST['category'];
    } else {
        $error['category'] = "Category is required";
    }

    // print_r($data);

    if (empty($error)) {
        try {
            $slug = create_slug($data['title']);
            $sql = "INSERT INTO blogs (user_id, title, slug, description, image, status, category_id) VALUES (:user_id, :title, :slug, :content, :image, :status, :category_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':content', $data['content']);
            $stmt->bindParam(':image', $data['image']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':category_id', $data['category']);
            $stmt->execute();

            move_uploaded_file($fileTmpName, $fileDestination);
            $success = "Blog added successfully";
            unset($data);
            header('location: blog.php');
            exit();
        } catch (PDOException $e) {
            $error['database'] = $e->getMessage();
        }
    }
    // print_r($error);
}
?>

<head>
    <title>Home | Blog Application</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <link rel="stylesheet" href="./assets/css/create_blog.css">

</head>

<body class=" bg-light">
    <?php include 'navbar.php'; ?>
    <section class="create-blog-header ">
        <div class="container">
            <h2 class="text-center fs-1">Create New Blog</h2>
        </div>
    </section>

    <div class="container mt-5 pt-4 mb-5 shadow-lg p-4 rounded">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <!-- Left Side: Title & Description -->
                <div class="col-md-8">
                    <span class="text-danger"><?= $error['database'] ?? ''; ?></span>
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold fs-4">Blog Title</label>
                        <input type="text" class="form-control py-3" id="title" name="title" placeholder="Enter blog title" required>
                        <span class="text-danger"><?= $error['title'] ?? ''; ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-4 fw-bold">Content</label>
                        <textarea name="content" class="form-control" id="blog-description" rows="6" required></textarea>
                        <span class="text-danger"><?= $error['content'] ?? ''; ?></span>
                    </div>
                </div>

                <!-- Right Side: Image Upload & Status -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold fs-4">Blog Image</label>
                        <input class="form-control py-3" type="file" id="image" name="image" accept="image/*" required>
                    </div>
                    <img id="preview" class="image-preview rounded-0" src="./assets/images/preview/blog-image-preview.png" alt="Image Preview">
                    <span class="text-danger"><?= $error['image'] ?? ''; ?></span>

                    <!-- Category Select -->
                    <div>
                        <label for="category" class="form-label fw-bold fs-4">Category</label>
                        <select name="category" id="category" class="form-control py-2" required>

                            <!-- Default Option (Outside Loop) -->
                            <option value="" selected disabled>Select Category</option>

                            <?php
                            $sql = "SELECT * FROM categories";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $categories = $stmt->fetchAll(PDO::FETCH_OBJ);

                            // print_r($categories);
                            foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>">
                                    <?php echo htmlspecialchars($category->name); ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="radio-group mt-3">
                        <label class="form-label fw-bold fs-4 d-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="publish" value="publish">
                            <label class="form-check-label" for="publish">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="draft" value="draft" checked>
                            <label class="form-check-label" for="draft">Draft</label>
                        </div>
                        <span class="text-danger"><?= $error['status'] ?? ''; ?></span>
                    </div>

                    <button name="createBlog" class="btn btn-primary w-100 mt-5">Publish Now</button>
                </div>
            </div>
        </form>
    </div>

    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>

    <script>
        $('#blog-description').summernote({
            placeholder: 'Enter blog content...',
            height: 425,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
        });

        // Live Image Preview
        const imageInput = document.getElementById('image');
        const preview = document.getElementById('preview');
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>