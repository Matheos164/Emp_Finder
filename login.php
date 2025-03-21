<?php
    session_start();

    if(isset($_POST['username']) && isset($_POST['password'])){
        function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        }
    }

//----------------------------------------------------------- 
// Change the following 2 fileds to change the login username and password
//insure to keep the "" and ; to insure the code does not break

    $adminUname = "Admin"; 
    $adminPass = "admin";

//----------------------------------------------------------- 

    $uname = validate($_POST['username']);
    $pass = validate($_POST['password']);

    if(!isset($uname) && !isset($pass)){
        header("Location: main.php?error=");
        exit();
    }elseif(empty($uname) && empty($pass)){
        header("Location: main.php?error=Username and Password are required");
        exit();
    }elseif(empty($pass)){
        header("Location: main.php?error=Password is required");
        exit();
    }elseif (empty($uname)){
        header("Location: main.php?error=Username is required");
        exit();
    }


    if($uname === $adminUname && $pass === $adminPass){
       $_SESSION['user'] = $uname;
       $_SESSION['id'] = session_id();
        header("Location: main.php");
        exit();
    }else{
        header("Location: main.php?error=Incorect Username or Password");
        exit();
    }
?>