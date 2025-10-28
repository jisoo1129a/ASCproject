<?php
    $conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);
    session_start();
    
    if(isset($_POST['user_id']) && isset($_POST['user_password1']) && isset($_POST['user_password2']))
    {
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $user_password1 = mysqli_real_escape_string($conn, $_POST['user_password1']);
        $user_password2 = mysqli_real_escape_string($conn, $_POST['user_password2']);

        if(empty($user_id))
        {
            header("location: Create_account.php?error=please write down id.");
            exit();
            //history.back();
        }
        else if(empty($user_password1) || empty($user_password2))
        {
            header("location: Create_account.php?error=please write down password.");
            exit();
        }
        else if(strlen($user_password1) < 8)
        {
            header("location: Create_account.php?error=password is less than 8 characters.");
            exit();
        }
        else if($user_password1 != $user_password2)
        {
            header("location: Create_account.php?error=passwords do not match.");
            exit();
        }
        else
        {
            $user_password = password_hash($user_password1, PASSWORD_DEFAULT);
            
            $sql_same_id = "SELECT * FROM managers WHERE USER_ID = '$user_id'";
            $result = mysqli_query($conn, $sql_same_id);

            if(mysqli_num_rows($result) > 0)
            {
                header("location: Create_account.php?error=id already exists.");
                exit();
            }
            else
            {
                $sql = "INSERT INTO managers(USER_ID, USER_PASSWORD) VALUES('$user_id', '$user_password')";
                mysqli_query($conn, $sql);
                header("location: Create_account.php?clear=Successfully done.");
            }
        }
        
    }
    else{
        if(isset($_POST['user_id']))
        {
            header("location: Create_account.php?error=please write down password.");
            exit();
        }
        else if(isset($_POST['user_password1']))
        {
            header("location: Create_account.php?error=please write down id.");
            exit();
        }
    }
?>