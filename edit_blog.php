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

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$blog = $stmt->fetch(PDO::FETCH_OBJ);

// Fetch all categories
$stmtCategories = $conn->prepare("SELECT id, name FROM categories ORDER BY name ASC");
$stmtCategories->execute();
$allCategories = $stmtCategories->fetchAll(PDO::FETCH_OBJ);

// print_r($blog);


$data = [];
$error = [];

if (isset($_POST['updateBlog'])) {
    $data = [
        'title' => $_POST['title'] ?? '',
        'content' => $_POST['content'] ?? '',
        'status' => $_POST['status'] ?? '',
        'category_id' => $_POST['category'] ?? '',
        'id' => $id,
    ];
    $oldImage = $blog->image;
    $data['image'] = $oldImage; // Default to old image

    // Image upload handling
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExt = ["jpg", "jpeg", "png", "webp"];

        if (in_array($fileExt, $allowedExt)) {
            if ($fileSize < 5000000) { // 5MB
                $newFileName = uniqid('', true) . "." . date('ymd') . "." . $fileExt;
                $fileDestination = 'assets/images/blogs/' . $newFileName;

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $data['image'] = $newFileName;
                    // Delete old image new image successfully uploaded
                    if ($oldImage && file_exists('assets/images/blogs/' . $oldImage)) {
                        unlink('assets/images/blogs/' . $oldImage);
                    }
                } else {
                    $error['image'] = "Failed to move uploaded file.";
                }
            } else {
                $error['image'] = "File size is too large (max 5MB).";
            }
        } else {
            $error['image'] = "Unsupported file type.";
        }
    }

    if (empty($error)) {
        try {
            $slug = create_slug($data['title']);
            $sql = "UPDATE blogs SET title = :title, slug = :slug, description = :content, image = :image, status = :status, category_id = :category_id WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':content', $data['content']);
            $stmt->bindParam(':image', $data['image']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':category_id', $data['category_id']);
            $stmt->bindParam(':id', $data['id']);
            
            if ($stmt->execute()) {
                header('Location: blog.php?status=updated');
                exit();
            } else {
                $error['database'] = "Failed to update blog.";
            }
        } catch (PDOException $e) {
            $error['database'] = "Database error: " . $e->getMessage();
        }
    }
}



?>
<!DOCTYPE html>
<html>

<head>
  <title>Create Blog | Blog Application</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <!-- include summernote css/js -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
  <link rel="stylesheet" href="./assets/css/create_blog.css">

</head>

<body class=" bg-light">
  <div class="header">
    <?php include 'navbar.php'; ?>
  </div>
  <section class="create-blog-header ">
    <div class="container">
      <h2 class="text-center fs-1">Update Blog</h2>
    </div>
  </section>
  <div class="container mt-5 pt-4 mb-5 shadow-lg p-4 rounded">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="POST" enctype="multipart/form-data">
      <div class="row">
        <!-- Left Side: Title & Description -->
        <div class="col-md-8">
          <div class="mb-3">
            <label for="title" class="form-label fw-bold fs-4">Blog Title</label>
            <input type="text" class="form-control py-3" id="title" name="title" value="<?php echo $blog->title; ?>" placeholder="Enter blog title" required>
            <span class="text-danger"><?= $error['title'] ?? ''; ?></span>
          </div>
          <div class="mb-3">
            <label class="form-label fs-4 fw-bold">Content</label>
            <textarea name="content" class="form-control" id="blog-description" rows="6" required><?php echo $blog->description; ?></textarea>
            <span class="text-danger"><?= $error['content'] ?? ''; ?></span>
          </div>
          <button name="updateBlog" class="btn btn-primary w-100">Update Now</button>
        </div>

        <!-- Right Side: Image Upload & Status -->
        <div class="col-md-4">
          <div class="mb-3">
            <label for="image" class="form-label fw-bold fs-4">Blog Image</label>
            <input class="form-control py-3" type="file" id="image" name="image" accept="image/*">
          </div>
          <img id="preview" class="image-preview rounded-0" src="./assets/images/blogs/<?php echo $blog->image; ?>" alt="Image Preview">
          <span class="text-danger"><?= $error['image'] ?? ''; ?></span>

          <div>
            <label for="category" class="form-label fw-bold fs-4">Category</label>
            <select name="category" id="category" class="form-control py-2" required>

              <!-- Default Option (Outside Loop) -->
              <option value="" disabled>Select Category</option>

              <?php
              foreach ($allCategories as $cat): ?>
                <option value="<?php echo $cat->id; ?>" <?php echo ($cat->id == $blog->category_id) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($cat->name); ?>
                </option>
              <?php endforeach;
              ?>
              
            </select>
          </div>

          <div class="radio-group mt-3">
            <label class="form-label fw-bold d-block">Status:</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="status" id="publish" value="publish">
              <?= $blog->status == 'publish' ? '<input class="form-check-input" type="radio" name="status" id="publish" value="publish" checked>' : ''; ?>
              <label class="form-check-label" for="publish">Publish</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="status" id="draft" value="draft">
              <?= $blog->status == 'draft' ? '<input class="form-check-input" type="radio" name="status" id="draft" value="draft" checked>' : ''; ?>
              <label class="form-check-label" for="draft">Draft</label>
            </div>
            <span class="text-danger"><?= $error['status'] ?? ''; ?></span>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="footer">
    <?php include 'footer.php'; ?>
  </div>

  <script>
    $('#blog-description').summernote({
      placeholder: 'Write blog content here...',
      height: 300,
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