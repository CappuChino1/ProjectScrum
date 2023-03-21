<?php 
    //V1 added
    session_start();
    require_once "config/db.php";
    // statement for fetching item's data
    $id=$_GET['id'];
    $stmt = $conn->query("SELECT * FROM item WHERE itemID = $id");
    $stmt->execute();
    $users = $stmt->fetchAll();
    foreach($users as $user)

    if ($user['fav']==1){
        //updating favorite back to non-fav
        $sql = $conn->query("UPDATE item 
        SET 
            fav = 0
        WHERE
            itemID = $id");
        $sql->execute();
    }
    else {
        //set favorite to 1
        $sql = $conn->query("UPDATE item 
        SET 
            fav = 1
        WHERE
        itemID = $id");
        $sql->execute();
    }
        header("refresh:1; url=Homepage.php");
        header("location: Homepage.php");
       
?>

