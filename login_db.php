<?php 
    session_start();
    include('server.php');
    //form for login query
    $errors = array();

    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($conn2, $_POST['username']);
        $password = mysqli_real_escape_string($conn2, $_POST['password']);
        //get username and password that user typed
        if (count($errors) == 0) {
            //no errors? query for user!
            $query = "SELECT * FROM user WHERE userID = '$username' AND password = '$password' ";
            $result = mysqli_query($conn2, $query);
            if (mysqli_num_rows($result) == 1) {
                $_SESSION['username'] = $username;
                //redirect to homepage if the query is success
                header("location: Homepage.php");
            } else {
                //error messages and redirect to login page
                array_push($errors, "Wrong Username or Password");
                $_SESSION['error'] = "Wrong Username or Password!!";
                header("location: login.php");
               
            }
        } else {
            array_push($errors, "Wrong Username or Password!!");
            $_SESSION['error'] = "Wrong Username or Password!!";
            header("Refresh:1; url=login.php");
            header("location: login.php");
        }
       
    }
 
?>
