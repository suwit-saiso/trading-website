<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = "Please login";
    header("location: signin.php");
    exit; // Add exit to stop script execution after redirection
}

if (isset($_POST['update'])) {
    $id = $_POST["id"];
    $name = $_POST["product-name"];
    $description = $_POST['description-text'];
    $category = $_POST['category'];
    $start_bid = floatval($_POST['start_bid']);
    $regular_price = floatval($_POST['regular_price']);
    $bid_end_datetime = date_format(date_create($_POST['bid_end_date'] . " " . $_POST['bid_end_time']), "Y-m-d H:i:s");
    $img = $_FILES["img"];
    $img2 = $_POST['img2'];
    $upload = $_FILES['img']['name'];

    // Check if the category already exists
    $stmt = $conn->prepare("SELECT * FROM categories WHERE `name` = :category");
    $stmt->bindParam(":category", $category);
    $stmt->execute();
    $a_category = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the category doesn't exist, insert it into the categories table
    if (!$a_category) {
        $stmt3 = $conn->prepare("INSERT INTO categories (`name`) VALUES (:category)");
        $stmt3->bindParam(":category", $category);
        $stmt3->execute();
        $categoryId = $conn->lastInsertId();
    } else {
        $categoryId = $a_category['id'];
    }

    if ($upload != "") {
        $allow = array("jpg", "jpeg", "png");
        $extension = explode(".", $img["name"]);
        $fileActExt = strtolower(end($extension));
        $file_new = rand() . "." . $fileActExt;
        $file_path = "uploads/" . $file_new;

        if (in_array($fileActExt, $allow)) {
            if ($img["size"] > 0 && $img["error"] == 0) {
                move_uploaded_file($img["tmp_name"], $file_path);
            }
        }
    } else {
        $file_new = $img2;
    }

    $sql = $conn->prepare("UPDATE products SET name = :name, categories_id = :categories_id, description = :description, start_bid = :start_bid, regular_price = :regular_price, bid_end_datetime = :bid_end_datetime, img_fname = :img_fname WHERE id = :id");
    $sql->bindParam(":id", $id);
    $sql->bindParam(":name", $name);
    $sql->bindParam(":categories_id", $categoryId); // Change to $categoryId
    $sql->bindParam(":description", $description);
    $sql->bindParam(":start_bid", $start_bid);
    $sql->bindParam(":regular_price", $regular_price);
    $sql->bindParam(":bid_end_datetime", $bid_end_datetime); // Remove date() function
    $sql->bindParam(":img_fname", $file_new);
    $sql->execute();

    if ($sql) {
        $_SESSION["success"] = "Data has been updated successfully.";
        header("location: admin.php");
        exit; // Add exit to stop script execution after redirection
    } else {
        $_SESSION["error"] = "Something went wrong. Please try again.";
        header("location: admin.php");
        exit; // Add exit to stop script execution after redirection
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Edit <?= $_POST['product-name'] ?></title>

    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1>Edit data</h1>
        <hr>
        <?php

        if (isset($_SESSION['admin_login'])) {
            $admin_id = $_SESSION['admin_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE id = $admin_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        ?>
        <h3 class="mt-4">Welcome Admin, <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></h3>
        <a href="logout.php" class="btn btn-danger">Logout</a>

        <hr>
        <form action="edit.php" class="needs-validation" novalidate method="post" enctype="multipart/form-data">
            <?php

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $stmt = $conn->query("SELECT * FROM products WHERE id = $id");
                $stmt->execute();
                $data = $stmt->fetch();
            }

            $stmt2 = $conn->prepare("SELECT * FROM categories");
            $stmt2->execute();
            $categories = $stmt2->fetchAll();

            ?>

            <div class="mb-3">
                <input type="text" readonly value="<?= $data["id"]; ?>" class="form-control" name="id">
                <label for="product-name" class="col-form-label">Product name:</label>
                <input type="text" value="<?= $data["name"]; ?>" class="form-control" name="product-name">
                <input type="hidden" value="<?= $data["img_fname"]; ?>" class="form-control" name="img2">
            </div>
            <div class="md-3">
                <label for="category" class="form-form-label">Category</label>
                <select class="form-select" name="category" required>
                    <option value="">Choose...</option>
                    <?php foreach ($categories as $category) : ?>
                        <option>
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    Please choose a category.
                </div>
            </div>
            <div class="mb-3">
                <label for="description-text" class="col-form-label">Description:</label>
                <textarea class="form-control" name="description-text"><?= $data["description"]; ?></textarea>
            </div>
            <div class="mb-3">
                <label class="col-form-label" for="start_bid">Start bid:</label>
                <input type="number" value="<?= $data["start_bid"]; ?>" name="start_bid" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="col-form-label" for="regular_price">Regular price:</label>
                <input type="number" value="<?= $data["regular_price"]; ?>" name="regular_price" class="form-control" />
            </div>
            <div class="md-3">
                <label for="bid_end_datetime" class="col-form-label">End bid:</label>
                <input type="date" value="<?= date("Y-m-d", strtotime($data["bid_end_datetime"])); ?>" name="bid_end_date" class="form-control">
                <input type="time" value="<?= date("H:i", strtotime($data["bid_end_datetime"])); ?>" name="bid_end_time" class="form-control">
            </div>
            <div class="mb-3">
                <label for="img" class="col-form-label">Image:</label>
                <input type="file" class="form-control" name="img" id="img_input">
                <img id="img_preview" src="uploads/<?= $data['img_fname']; ?>" alt="" width="100%">
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" href="admin.php">Back</a>
                <button type="submit" class="btn btn-primary" name="update">Update</button>
            </div>
        </form>
    </div>
    <!-- End of container -->

    <!-- Image Preview Script -->
    <script>
        let img_input = document.getElementById("img_input");
        let img_preview = document.getElementById("img_preview");

        img_input.onchange = evt => {
            const [file] = img_input.files;
            if (file) {
                img_preview.src = URL.createObjectURL(file);
            }
        }
    </script>

</body>

</html>