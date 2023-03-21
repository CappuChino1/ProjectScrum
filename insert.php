<?php 

session_start();
require_once "config/db.php";
//form for inserting new item to database
if (isset($_POST['submit'])) {
    $itemName = $_POST['itemName'];
    $expDate = $_POST['expDate'];
    $Img = $_FILES['Img'];
    $quantity = $_POST['quantity'];
    //get all the input from user and stored it


        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $Img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
        $filePath = 'uploads/'.$fileNew;
                 

        if (in_array($fileActExt, $allow)) {
            if ($Img['size'] > 0 && $Img['error'] == 0) {
               if (move_uploaded_file($Img['tmp_name'], $filePath)) {   
                            //insert query
                            $exp = date('Y-m-d', strtotime($_POST['expDate']));                 
                            $sql = $conn->prepare("INSERT INTO item(itemName, expDate, Img, quantity,userID) 
                            VALUES(:itemName, :expDate, :Img, :quantity, :userID)");
                            $sql->bindParam(":itemName", $itemName);
                            $sql->bindParam(":expDate", $exp);
                            $sql->bindParam(":quantity", $quantity);
                            $sql->bindParam(":Img", $fileNew);
                            $sql->bindParam(":userID", $_SESSION['username']);
                            $sql->execute(); 
                        if($sql){
                        $_SESSION['success'] = "Data has been inserted successfully";
                        header("location: Homepage.php");
                        }else{
                            $_SESSION['error'] = "Data has not been inserted successfully";
                            header("location: Homepage.php");
                        }
                    }  
                }
             
            }

        
        }
?>