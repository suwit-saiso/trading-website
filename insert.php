<?php

session_start();
require_once "config/db.php";

echo "
    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js'></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css'/>
";

if (isset($_POST['submit'])) {

    $name = $_POST['product-name'];
    $category = $_POST['category'];
    $description = $_POST['description-text'];
    $start_bid = floatval($_POST['start_bid']);
    $regular_price = floatval($_POST['regular_price']);
    $bid_end_datetime = date_format(date_create($_POST['bid_end_date'] . " " . $_POST['bid_end_time']), "Y-m-d H:i:s");
    $img = $_FILES['img'];
    
    $allow = array("jpg", "jpeg", "png");
    $extension = explode(".", $img["name"]);
    $fileActExt = strtolower(end($extension));
    $file_new = rand() . "." . $fileActExt;
    $file_path = "uploads/" . $file_new;
    
    if(in_array($fileActExt, $allow)){
        if($img["size"] > 0 && $img["error"] == 0){
            if(move_uploaded_file($img["tmp_name"], $file_path)) {
                // Check if the category already exists
                $stmt = $conn->prepare("SELECT * FROM categories WHERE `name` = :category");
                $stmt->bindParam(":category", $category);
                $stmt->execute();
                $a_category = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$a_category) {
                    $stmt3 = $conn->prepare("INSERT INTO categories (`name`) VALUES (:category)");
                    $stmt3->bindParam(":category", $category);
                    $stmt3->execute();
                    $categoryId = $conn->lastInsertId();
                } else {
                    $categoryId = $a_category['id'];
                }

                $name = ucwords($name);
                $bid_end_datetime = date($bid_end_datetime);
                
                $sql = $conn->prepare("INSERT INTO products(name, categories_id, description, start_bid, regular_price, bid_end_datetime, img_fname) VALUES(:name, :category, :description, :start_bid, :regular_price, :bid_end_datetime, :img)");
                $sql->bindParam(":name", ucwords($name));
                $sql->bindParam(":category", $categoryId);
                $sql->bindParam(":description", $description);
                $sql->bindParam(":start_bid", $start_bid);
                $sql->bindParam(":regular_price", $regular_price);
                $sql->bindParam(":bid_end_datetime", date($bid_end_datetime));
                $sql->bindParam(":img", $file_new);
                $sql->execute();
                
                if($sql){
                    echo "
                    <script>
                        setTimeout(function(){
                            swal({
                                title: 'Insert successfully',
                                text: 'Correct information',
                                type: 'success'
                            }, function(){
                                window.location = 'admin.php';
                            })   
                        }, 1000);
                    </script>
                ";
                }else{
                    echo "
                    <script>
                        setTimeout(function(){
                            swal({
                                title: 'Insert fail',
                                text: 'Information not correct',
                                type: 'warning'
                            }, function(){
                                window.location = 'admin.php';
                            })   
                        }, 1000);
                    </script>
                ";
                }
            }else{
                echo "
                    <script>
                        setTimeout(function(){
                            swal({
                                title: 'Insert fail',
                                text: 'Can not save your image',
                                type: 'warning'
                            }, function(){
                                window.location = 'admin.php';
                            })   
                        }, 1000);
                    </script>
                ";
            }
        }else{
            echo "
                    <script>
                        setTimeout(function(){
                            swal({
                                title: 'Insert fail',
                                text: 'Image file does not correct.',
                                type: 'warning'
                            }, function(){
                                window.location = 'admin.php';
                            })   
                        }, 1000);
                    </script>
                ";
        }
    }else{
        echo "
            <script>
                setTimeout(function(){
                    swal({
                        title: 'Insert fail',
                        text: 'Please fill product infomation.',
                        type: 'warning'
                    }, function(){
                        window.location = 'admin.php';
                    })   
                }, 1000);
            </script>
        ";
    }
    
}
