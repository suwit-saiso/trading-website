<?php

    session_start();
    require_once 'config/db.php';

    if(isset($_POST['signup'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $province = $_POST['province'];
        $district = $_POST['district'];
        $subdistrict = $_POST['subdistrict'];
        $postalcode = $_POST['postalcode'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $tel = $_POST['tel'];
        $urole = 'user';

        if(strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5){
            $_SESSION['error'] = 'Password must between 5 - 20 character.';
            header("location: signup.php");
        }else if($password != $c_password){
            $_SESSION['error'] = 'Password dont match.';
            header("location: signup.php");
        }else{
            try{
                $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);
    
                if($row['email'] == $email){
                    $_SESSION['warning'] = "This Email already exist. <a href='signin.php'>Click here</a> to login.";
                    header("location: signup.php");
                }else if(!isset($_SESSION['error'])){
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $r_address = $address . " " . $subdistrict . " " . $district . " " . $province . " " . $postalcode;
                    $stmt = $conn->prepare("INSERT INTO users(firstname, lastname, email, password, contact, address, urole) VALUES(:firstname, :lastname, :email, :password, :contact, :address, :urole)");
                    $stmt->bindParam(":firstname", ucwords($firstname));
                    $stmt->bindParam(":lastname", ucwords($lastname));
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":contact", $tel);
                    $stmt->bindParam(":address", $r_address);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->execute();
                    $_SESSION['success'] = "Sign up Successfully <a href='signin.php' class='alert-link'>Click here</a> to Login.";
                    header("location: signup.php");
                }else{
                    $_SESSION['error'] = "Something wrong.";
                    header("location: signup.php");
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }


?>