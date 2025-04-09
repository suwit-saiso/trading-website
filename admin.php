<?php

session_start();
require_once 'config/db.php';

echo "
    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js'></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css'/>
";

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = "Please login";
    header("location: signin.php");
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->prepare("DELETE FROM products WHERE id = :delete_id");
    $deletestmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    $deletestmt->execute();

    if ($deletestmt) {
        echo "
            <script>
                setTimeout(function(){
                    swal({
                        title: 'Delete complete',
                        text: 'The data has been delete',
                        type: 'success'
                    }, function(){
                        window.location = 'admin.php';
                    })   
                }, 1000);
            </script>
        ";
    } else {
        echo "
            <script>
                setTimeout(function(){
                    swal({
                        title: 'Delete fail',
                        text: 'Somthing wrong',
                        type: 'warning'
                    }, function(){
                        window.location = 'admin.php';
                    })   
                }, 1000);
            </script>
        ";
    }
}

if (isset($_GET['remove'])) {
    $delete_id = $_GET['remove'];
    $deletestmt = $conn->prepare("DELETE FROM bids WHERE id = :delete_id");
    $deletestmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    $deletestmt->execute();

    if ($deletestmt) {
        echo "
            <script>
                setTimeout(function(){
                    swal({
                        title: 'Delete complete',
                        text: 'The data has been delete',
                        type: 'success'
                    }, function(){
                        window.location = 'admin.php';
                    })   
                }, 1000);
            </script>
        ";
    } else {
        echo "
            <script>
                setTimeout(function(){
                    swal({
                        title: 'Delete fail',
                        text: 'Somthing wrong',
                        type: 'warning'
                    }, function(){
                        window.location = 'admin.php';
                    })   
                }, 1000);
            </script>
        ";
    }
}
if (isset($_SESSION['admin_login'])) {
    $admin_id = $_SESSION['admin_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE id = $admin_id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

$stmt2 = $conn->prepare("SELECT * FROM categories");
$stmt2->execute();
$categories = $stmt2->fetchAll();

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trademates Admin <?= $row["firstname"]; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.2/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="mask-icon" href="/docs/5.2/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="css/admin.css" rel="stylesheet">
</head>

<body>

    <div class="modal fade" id="product_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="insert.php" class="needs-validation" novalidate method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="product-name" class="col-form-label">Product name:</label>
                                    <input type="text" class="form-control" name="product-name" pattern=".{1,}" title="Please enter a product name" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="category" class="col-form-label">Category:</label>
                                    <select class="form-select" name="category" required>
                                        <option value="">Choose...</option>
                                        <?php foreach ($categories as $category) : ?>
                                            <option>
                                                <?= $category['name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description-text" class="col-form-label">Description:</label>
                                    <textarea class="form-control" name="description-text" required pattern=".{1,}" title="Please enter a description"></textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="col-form-label" for="start_bid">Start bid:</label>
                                    <input type="number" name="start_bid" class="form-control" required />
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="col-form-label" for="regular_price">Regular price:</label>
                                    <input type="number" name="regular_price" class="form-control" required />
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="md-3">
                                    <label for="bid_end_date" class="col-form-label">End bid: date</label>
                                    <input type="date" name="bid_end_date" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="md-3">
                                    <label for="bid_end_time" class="col-form-label">Time:</label>
                                    <input type="time" name="bid_end_time" class="form-control" required>
                                </div>
                            </div>

                        </div>


                        <div class="mb-3">
                            <label for="img" class="col-form-label">Image:</label>
                            <input type="file" class="form-control" name="img" required id="img_input" required>
                            <img id="img_preview" alt="" width="100%" class="mt-3">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="index.php">Trademates ADMIN</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="logout.php">Sign-out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin.php">
                                <span data-feather="home" class="align-text-bottom"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="modal" data-bs-target="#product_modal" href="">
                                <span data-feather="file" class="align-text-bottom"></span>
                                Add product
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="toggle-bid-history">
                                <span data-feather="shopping-cart" class="align-text-bottom"></span>
                                Bid History
                            </a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">
                                <span data-feather="users" class="align-text-bottom"></span>
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">
                                <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">
                                <span data-feather="layers" class="align-text-bottom"></span>
                                Integrations
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main-content-container">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Admin, <?= $row["firstname"]; ?></h1>
                </div>

                <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

                <h2>All product</h2>
                <div class="table-responsive">
                <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Start bid</th>
                                <th scope="col">Regular price</th>
                                <th scope="col">Bid start datetime</th>
                                <th scope="col">Bid end datetime</th>
                                <th scope="col">Image</th>
                                <th scope="col">Higher bids</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->query("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.categories_id = c.id");
                            $stmt->execute();
                            $pros = $stmt->fetchAll();
                            if (!$pros) {
                                echo "<tr><td colspan='9' class='text-center'>No product found</td></td></tr>";
                            } else {
                                foreach ($pros as $pro) {
                            ?>
                                    <tr>
                                        <th scope="row">
                                            <?= $pro['id'] ?>
                                        </th>
                                        <td>
                                            <?= $pro['name'] ?>
                                        </td>
                                        <td>
                                            <?= $pro['start_bid'] ?>
                                        </td>
                                        <td>
                                            <?= $pro['regular_price'] ?>
                                        </td>
                                        <td>
                                            <?= $pro['bid_end_datetime'] ?>
                                        </td>
                                        <td>
                                            <?= $pro['date_craeted'] ?>
                                        </td>
                                        <td width="80px"><img width="100%" src="uploads/<?= $pro['img_fname'] ?>" class="rounded" alt=""></td>
                                        <td>
                                            <?php

                                            $ustmt = $conn->prepare("SELECT * FROM users WHERE `id` = :higher_bid");
                                            $ustmt->bindParam(":higher_bid", $pro['highest_bidder_id']);
                                            $ustmt->execute();
                                            $wuid = $ustmt->fetch(PDO::FETCH_ASSOC);

                                            ?>
                                            <?php if (empty($wuid)) : ?>
                                            <?php else : ?>
                                                <?= $wuid['firstname'] . ' ' . $wuid['lastname'] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="edit.php?id=<?= $pro["id"]; ?>" class="btn btn-warning"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            <a href="?delete=<?= $pro["id"]; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-close" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                            <?php }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>

            <div id="bid-history-container" style="display: none;" class="col-md-9 ms-sm-auto col-lg-10 px-md-4"">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Bidding history</h1>
                </div>
                <hr>
                <div class="table-responsive">
                <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User</th>
                                <th scope="col">Product</th>
                                <th scope="col">Bid amount</th>
                                <th scope="col">status</th>
                                <th scope="col">Datetime</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM `bids` ORDER BY `date_created` DESC");
                            $stmt->execute();
                            $bids = $stmt->fetchAll();
                            if (!$bids) {
                                echo "<tr><td colspan='7' class='text-center'>No bidding found</td></td></tr>";
                            } else {
                                foreach ($bids as $bid) {
                                
                                $ustmt = $conn->prepare("SELECT * FROM `users` WHERE `id` = :id");
                                $ustmt->bindParam(":id", $bid['user_id']);
                                $ustmt->execute();
                                $user = $ustmt->fetch(PDO::FETCH_ASSOC);
                                
                                $pstmt = $conn->prepare("SELECT * FROM `products` WHERE `id` = :id");
                                $pstmt->bindParam(":id", $bid['product_id']);
                                $pstmt->execute();
                                $product = $pstmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                                    <tr>
                                        <th scope="row">
                                            <?= $bid['id'] ?>
                                        </th>
                                        <td>
                                            <?= $user["firstname"] . " " . $user["lastname"] ?>
                                        </td>
                                        <td>
                                            <?= $product["name"] ?>
                                        </td>
                                        <td>
                                            <?= $bid['bid_amount'] ?>
                                        </td>
                                        <td>
                                            <?= $bid['status'] ?>
                                        </td>
                                        <td>
                                            <?= $bid['date_created'] ?>
                                        </td>
                                        <td>
                                            <a href="?remove=<?= $bid["id"]; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-close" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                            <?php }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="js/admin.js"></script>

    <script type="text/javascript">
        let img_input = document.getElementById("img_input");
        let img_preview = document.getElementById("img_preview");

        img_input.onchange = evt => {
            const [file] = img_input.files;
            if (file) {
                img_preview.src = URL.createObjectURL(file);
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
    $(document).ready(function() {
        $("#toggle-bid-history").click(function() {
            // Hide the main content
            $("#main-content-container").hide();
            
            // Show the Bid History content
            $("#bid-history-container").show();
        });
    });
    </script>

</body>

</html>