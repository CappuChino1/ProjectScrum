<?php 

    // - + sign of the page
    //V2.5 added
    session_start();
    require_once "config/db.php";
    $id=$_GET['id'];
    $op=$_GET['op'];
    $stmt = $conn->query("SELECT * FROM item WHERE itemID = $id");
    $stmt->execute();
    $users = $stmt->fetchAll();
    foreach($users as $user)
    $n=$user['quantity'];

    if ($op==1){
        //plus one on quantity
        $sql = $conn->query("UPDATE item 
        SET 
            quantity = $n+1
        WHERE
            itemID = $id");
        $sql->execute();

    }
    else if($op==0) {
        //minus one on quantity
        $sql = $conn->query("UPDATE item 
        SET 
            quantity = $n-1
        WHERE
        itemID = $id");
        $sql->execute();
        

    }
    if ($sql) {
        //success lead back to homepage
        header("refresh:1; url=Homepage.php");
        header("location: Homepage.php");
       
    } else {
        $_SESSION['error'] = "Sth wrong";
        header("location: Homepage.php");
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo $_GET['id'].$op?>
</body>
</html>

