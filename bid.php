<?php
session_start();
require_once 'config/db.php';

echo "
    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js'></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css'/>
";

if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
  $_SESSION['error'] = "Please login";
  header("location: signin.php");
  exit(); // Add this to stop further execution of the script
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->query("SELECT * FROM products WHERE id = $id");
    $stmt->execute();
    $data = $stmt->fetch();

    $bid_end_datetime = $data["bid_end_datetime"];
}

if (isset($_SESSION["error"])) {
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
?>
    <script>
        setTimeout(function() {
            swal({
                title: 'Bidding fail',
                text: '<?= $error ?>',
                type: 'warning'
            }, function() {
                window.location = 'bid.php?id=<?php echo $_GET['id']; ?>';
            })
        }, 1000);
    </script>
<?php
}
if (isset($_SESSION["success"])) {
    $success = $_SESSION["success"];
    unset($_SESSION["success"]);
?>
    <script>
        setTimeout(function() {
            swal({
                title: 'Bidding success',
                text: '<?= $success ?>',
                type: 'success'
            }, function() {
                window.location = 'bid.php?id=<?php echo $_GET['id']; ?>';
            })
        }, 1000);
    </script>
<?php
}
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TradeMates <?= $data["name"]; ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <script src="js/color-modes.js"></script>

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/index-style.css">

    <link href="css/offcanvas-navbar.css" rel="stylesheet">

</head>

<body>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
        </symbol>
    </svg>

    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                <use href="#circle-half"></use>
            </svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#sun-fill"></use>
                    </svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#moon-stars-fill"></use>
                    </svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div>


    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">TradeMates</a>
            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Market place</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">About us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle disabled" href="#" data-bs-toggle="dropdown" aria-expanded="false">Settings</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
                <a class='btn btn-danger' href='index.php' role='button'>Back</a>
            </div>
        </div>
    </nav>

    <div class="nav-scroller bg-body shadow-sm">
        <nav class="nav" aria-label="Secondary navigation">
            <a class="nav-link disabled" aria-current="page" href="#">Market place</a>
            <a class="nav-link disabled" href="">
                Cart
                <span class="badge text-bg-danger rounded-pill align-text-bottom">Coming-soon</span>
            </a>
            <a class="nav-link disabled" href="">On bidding
                <span class="badge text-bg-danger rounded-pill align-text-bottom">Coming-soon</span>
            </a>
            <a class="nav-link disabled" href="">More</a>
        </nav>
    </div>

    <main class="container">

        <?php

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $conn->query("SELECT * FROM products WHERE id = $id");
            $stmt->execute();
            $data = $stmt->fetch();

            $bid_end_datetime = $data["bid_end_datetime"];

            $bstmt = $conn->prepare("SELECT MAX(bid_amount) as max_bid, user_id as uid FROM bids WHERE `product_id` = :pid");
            $bstmt->bindParam(":pid", $id);
            $bstmt->execute();
            $max_bid = $bstmt->fetch(PDO::FETCH_ASSOC);

            $wstmt = $conn->prepare("SELECT * FROM users WHERE `id` = :max_higher_bidder");
            $wstmt->bindParam(":max_higher_bidder", $max_bid['uid']);
            $wstmt->execute();
            $higher_bidder = $wstmt->fetch(PDO::FETCH_ASSOC);
        }

        ?>

        <div class="card mb-3 my-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="uploads/<?= $data["img_fname"]; ?>" width="100%" height="100%" class="rounded-start object-fit-cover">
                </div>
                <div class="col-md-8 d-flex flex-column">
                    <div class="card-head text-center bg-danger text-white rounded-end">
                        <span>
                            <h2 id="countdown"></h2>
                        </span>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title text-center">
                            <div class="row">
                                <div class="col-8">
                                    <?= $data["name"]; ?>
                                </div>
                                <div class="col-2">
                                    <?php
                                    $current_time = time();
                                    if ((strtotime($bid_end_datetime) - $current_time) <= 0) {
                                        echo '<span class="badge bg-success">On bidding</span>';
                                    } else {
                                        if (!empty($higher_bidder)) {
                                            echo '<span class="badge bg-success">Winner: ' . $higher_bidder['firstname'] . '</span>';
                                        } else {
                                            echo '<span class="badge bg-success">No bids received</span>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>


                        </h2>
                        <p class="card-text"><span class="badge bg-primary rounded-pill">Description: </span> <?= $data["description"]; ?></p>
                        <div class="row">
                            <div class="col-4">
                                <div class="card text-bg-danger text-center">
                                    <div class="card-header">START BIDS</div>
                                    <div class="card-body">
                                        <h1 class="card-title"><?= $data["start_bid"]; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card text-bg-success text-center">
                                    <div class="card-header">REGULAR PRICE</div>
                                    <div class="card-body">
                                        <h1 class="card-title"><?= $data["regular_price"]; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card text-bg-warning text-center">
                                    <div class="card-header">HIGHER BIDS</div>
                                    <div class="card-body">
                                        <h1 class="card-title">
                                            <?php if (empty($max_bid["max_bid"])) {
                                                echo $data["start_bid"];
                                            } else {
                                                echo $max_bid["max_bid"];
                                            }
                                            ?>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <hr class="mt-3">

                            <form method="POST" action="bid_db.php?pid=<?= $data["id"]; ?>&uid=<?= $_SESSION['user_login']; ?>">
                                <div class="row gap-2">
                                    <div class="col-12">
                                        <div class="form-outline">
                                            <input type="number" name="bid_input" class="form-control form-control-lg form-icon-trailing" id="bidInput" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary btn-lg" name="submit_bid" id="submitBidButton">
                                                Submit Bids
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <small class="text-muted mt-auto">Place on <?= $data["date_craeted"]; ?></small>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h6 class="border-bottom pb-2 mb-0">Bidding history</h6>
            <?php

            $bstmt = $conn->prepare("SELECT * FROM `bids` WHERE `product_id` = :id");
            $bstmt->bindParam(":id", $_GET['id']);
            $bstmt->execute();
            $bids = $bstmt->fetchAll();


            if (!$bids) {
                echo "<tr><td class='text-center'>No bidding history found</td></td></tr>";
            } else {
                foreach ($bids as $bid) {
                    $ustmt = $conn->prepare("SELECT * FROM `users` WHERE `id` = :pid");
                    $ustmt->bindParam(":pid", $bid['user_id']);
                    $ustmt->execute();
                    $user = $ustmt->fetch(PDO::FETCH_ASSOC);
            ?>
                    <div class="d-flex text-body-secondary pt-3">
                        <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
                        </svg>
                        <p class="pb-3 mb-0 small lh-sm border-bottom">
                            <strong class="d-block text-gray-dark"><?= $user["firstname"] . " " . $user["lastname"] . " " . $bid['date_created']; ?></strong>Bids amount: <?= $bid["bid_amount"]; ?>
                        </p>
                        <br>
                        <p>

                        </p>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </main>

    <script src="js/offcanvas-navbar.js"></script>

    <script>
        function updateCountdown(endTime, countdownElementId) {
            const countdownElement = document.getElementById(countdownElementId);

            const intervalId = setInterval(function() {
                const now = new Date().getTime();
                const timeLeft = new Date(endTime) - now;

                if (timeLeft <= 0) {
                    countdownElement.textContent = 'EXPIRED';
                } else {
                    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    if (days == 0) {
                        countdownElement.textContent = `${hours}hr ${minutes}m ${seconds}s`;
                        if (hours == 0) {
                            countdownElement.textContent = `${minutes}m ${seconds}s`;
                            if (minutes == 0) {
                                countdownElement.textContent = `${seconds}s`;
                            }
                        }
                    } else {
                        countdownElement.textContent = `${days}Day ${hours}hr ${minutes}m ${seconds}s`;
                    }
                }
            }, 1000);
        }

        updateCountdown('<?= $bid_end_datetime; ?>', 'countdown');
    </script>

    <script>
        const bidInput = document.getElementById('bidInput');
        const submitBidButton = document.getElementById('submitBidButton');

        // Check if the product is expired
        const isProductExpired = new Date('<?= $bid_end_datetime; ?>') <= new Date();

        if (isProductExpired) {
            bidInput.disabled = true;
            submitBidButton.disabled = true;
            submitBidButton.textContent = 'Submit Bids (Expired)';
        }
    </script>

</body>

</html>