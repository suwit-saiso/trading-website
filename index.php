<?php

session_start();
require_once 'config/db.php';

?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TradeMates</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

  <!-- Bootstrap links -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <!-- Font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <link rel="stylesheet" href="css/index-style.css">


  <!-- Custom styles for this template -->
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
      <a class="navbar-brand" href="#">TradeMates</a>
      <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Market place</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Aboutus.php">About us</a>
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
        <div class="text-center ">
          <?php if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])) {
            echo "<a class='btn btn-danger' href='logout.php' role='button'>Sign-out</a>";
          } else {
            echo "<a class='btn btn-outline-light' href='signin.php' role='button'><i class='fa fa-sign-in' aria-hidden='true'></i> Sign-in</a>
            <a class='btn btn-warning' href='signup.php' role='button'>Sign-up</a>";
          }
          ?>
        </div>
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

    <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm justify-content-center">
      <i class="fa-solid fa-bullhorn fa-2x"></i>
      <h2 class="text-white">
        <span class="badge badge-danger">
          <marquee width="100%" behavior="scroll" direction="up" scrollamount="3">
            NEW PRODUCT OUT NOW!!
          </marquee>
        </span>
      </h2>
    </div>

    <div class="container">
      <div class="row justify-content-center">
        <?php
        // Select and display products that are not expired
        $stmt = $conn->prepare("SELECT * FROM products WHERE bid_end_datetime >= NOW() ORDER BY id ASC");
        $stmt->execute();
        $productsNotExpired = $stmt->fetchAll();

        if (!empty($productsNotExpired)) :
          foreach ($productsNotExpired as $key => $product) :
        ?>
            <div class="col-3">
              <div class="card my-2">
                <form action="catalog.php?action=add&code">
                  <img src="uploads/<?php echo $product["img_fname"]; ?>" class="card-img-top" alt="images" height="300px" style="object-fit: cover;">
                  <div class="card-head text-center bg-danger text-white" data-end-time="<?php echo $product['bid_end_datetime']; ?>">
                  </div>
                  <div class="card-body">
                    <h5 class="card-title text-center"><?= $product['name'] ?></h5>
                    <p class="card-text">Regular price: <?= $product["regular_price"]; ?> Bath</p>
                  </div>
                  <div class="card-footer">
                    <div class="d-grid">
                      <a href="bid.php?id=<?= $product["id"]; ?>" class="btn btn-primary"><i class="fa fa-dollar" aria-hidden="true" name="bid"></i> Bid</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          <?php
          endforeach;
        endif;

        // Select and display expired products (not more than 1 day old)
        $stmt = $conn->prepare("SELECT * FROM products WHERE bid_end_datetime > DATE_SUB(NOW(), INTERVAL 1 DAY) AND bid_end_datetime < NOW() ORDER BY id ASC");
        $stmt->execute();
        $productsExpired = $stmt->fetchAll();

        if (!empty($productsExpired)) :
          foreach ($productsExpired as $key => $product) :
          ?>
            <div class="col-3">
              <div class="card my-2">
                <form action="catalog.php?action=add&code">
                  <img src="uploads/<?php echo $product["img_fname"]; ?>" class="card-img-top" alt="images" height="300px" style="object-fit: cover;">
                  <div class="card-head text-center bg-danger text-white" data-end-time="<?php echo $product['bid_end_datetime']; ?>">
                  </div>
                  <div class="card-body">
                    <h5 class="card-title text-center"><?= $product['name'] ?></h5>
                    <p class="card-text">Regular price: <?= $product["regular_price"]; ?> Bath</p>
                  </div>
                  <div class="card-footer">
                    <div class="d-grid">
                      <a href="bid.php?id=<?= $product["id"]; ?>" class="btn btn-primary"><i class="fa fa-dollar" aria-hidden="true" name="bid"></i> Bid</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
        <?php
          endforeach;
        endif;
        ?>
      </div>
    </div>



  </main>

  <?php
      echo "
      <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
      <script src='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js'></script>
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css'/>
    ";

    if (isset($_POST['bid'])) {
    if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])) {
      header("location: bid.php");
    } else {
      echo "
          <script>
              setTimeout(function(){
                  swal({
                      title: 'Please sign-in',
                      text: 'To view more option.',
                      type: 'warning'
                  }, function(){
                      window.location = 'index.php';
                  })   
              }, 1000);
          </script>
      ";
    }
    }
  
  ?>

  <script src="js/offcanvas-navbar.js"></script>

  <!-- Counter timer script -->
  <script>
    function updateCountdown(countdownElement) {
      const endTime = countdownElement.getAttribute('data-end-time');
      const intervalId = setInterval(function() {
        const now = new Date().getTime();
        const timeLeft = new Date(endTime) - now;
        const countdownElementId = countdownElement.id;

        if (timeLeft <= 0) {
          countdownElement.textContent = 'EXPIRED';
          clearInterval(intervalId);
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

    const countdownElements = document.querySelectorAll('[data-end-time]');
    countdownElements.forEach(updateCountdown);
  </script>


</body>

</html>