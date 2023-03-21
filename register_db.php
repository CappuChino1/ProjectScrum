<?php 
    session_start();
    include('server.php');
    //form for registeration of user
    $errors = array();

    if (isset($_POST['reg_user'])) {
        //if register button is pressed
        $username = mysqli_real_escape_string($conn2, $_POST['username']);
        $password_1 = mysqli_real_escape_string($conn2, $_POST['password_1']);
      //get username and password data
        $user_check_query = "SELECT * FROM user WHERE userID = '$username' LIMIT 1";
        //query for any duplicate user
        $query = mysqli_query($conn2, $user_check_query);
        $result = mysqli_fetch_assoc($query);
        if ($result) { // if user already exists
            if ($result['userID'] === $username) {
                array_push($errors, "Username already exists");
                $_SESSION['error'] = "Username already exists";
            }
        }
        if (count($errors) == 0) {
            //no error = register!
            $sql = "INSERT INTO user (userID, password) VALUES ('$username', '$password_1')";
            mysqli_query($conn2, $sql);

            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: Homepage.php');
            header("Refresh:1;"); 
        } else {
            header("location: login.php");
            header("Refresh:1;"); 
        }
    }

?>