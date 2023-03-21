<?php 
//this is for establishing connection to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "infridge_db";

    // Create Connection
    $conn2 = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn2) {
        die("Connection failed" . mysqli_connect_error());
    } 

?>