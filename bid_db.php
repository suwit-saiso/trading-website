<?php
session_start();
require_once "config/db.php";

if (isset($_GET['pid']) && isset($_GET["uid"])) {
    $pid = $_GET['pid'];
    $uid = $_GET["uid"];

    // Prepare and execute a query to fetch the product and user
    $pstmt = $conn->prepare("SELECT * FROM `products` WHERE `id` = :pid");
    $pstmt->bindParam(":pid", $pid);
    $pstmt->execute();
    $product = $pstmt->fetch(PDO::FETCH_ASSOC);

    $ustmt = $conn->prepare("SELECT * FROM `users` WHERE `id` = :uid");
    $ustmt->bindParam(":uid", $uid);
    $ustmt->execute();
    $user = $ustmt->fetch(PDO::FETCH_ASSOC);

    // Check if the product or user is not found
    if (!$product || !$user) {
        $_SESSION["error"] = "Product or user not found";
        header("location: bid.php?id=$pid");
        exit();
    }

    $current_time = time();
    $bid_end_datetime = strtotime($product['bid_end_datetime']);

    // Check if bidding is allowed (based on bid_end_datetime)
    if ($bid_end_datetime > $current_time) {
        // Check if the bid input is provided and not empty
        if (isset($_POST['bid_input']) && !empty($_POST['bid_input'])) {
            $bid_amount = $_POST["bid_input"];
            $start_bid = $product['start_bid'];

            if ($bid_amount > $start_bid) {
                // Get the highest bid for the product
                $bstmt = $conn->prepare("SELECT MAX(bid_amount) as max_bid FROM bids WHERE `product_id` = :pid");
                $bstmt->bindParam(":pid", $pid);
                $bstmt->execute();
                $max_bid = $bstmt->fetch(PDO::FETCH_ASSOC);
                $highest_bid = $max_bid['max_bid'];

                if ($bid_amount > $highest_bid) {
                    // Check if the user is already the highest bidder
                    if ($user["id"] !== $product['highest_bidder_id']) {
                        // Update the highest bidder in the product table
                        $update_stmt = $conn->prepare("UPDATE products SET highest_bidder_id = :user_id WHERE id = :pid");
                        $update_stmt->bindParam(":user_id", $user["id"]);
                        $update_stmt->bindParam(":pid", $pid);
                        $update_stmt->execute();

                        if ($update_stmt) {
                            // Insert the new bid
                            $status = 1;
                            $stmt = $conn->prepare("INSERT INTO bids(`user_id`, `product_id`, `bid_amount`, `status`) VALUES(:user_id, :product_id, :bid_amount, :status)");
                            $stmt->bindParam(":user_id", $user["id"]);
                            $stmt->bindParam(":product_id", $product["id"]);
                            $stmt->bindParam(":bid_amount", $bid_amount);
                            $stmt->bindParam(":status", $status);
                            $stmt->execute();

                            if ($stmt) {
                                $_SESSION["success"] = "Your bid has been placed successfully.";
                            } else {
                                $_SESSION["error"] = "Something went wrong. Please try again.";
                            }
                        } else {
                            $_SESSION["error"] = "Failed to update the highest bidder.";
                        }
                    } else {
                        $_SESSION["error"] = "You are already the highest bidder.";
                    }
                } else {
                    $_SESSION["error"] = "Your bid is not higher than the current highest bid.";
                }
            } else {
                $_SESSION["error"] = "Bid amount should be greater than the start bid.";
            }
        } else {
            $_SESSION["error"] = "Bid amount is not provided or is empty.";
        }
    } else {
        $_SESSION['error'] = "Bidding for this product has ended. Product end time: " . date("Y-m-d H:i:s", $bid_end_datetime) . ", Current time: " . date("Y-m-d H:i:s", $current_time);
    }

    header("location: bid.php?id=$pid");
}
?>
