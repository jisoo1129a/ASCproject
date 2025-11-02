<?php
    $conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);
    session_start();
    //searching
    
        
    if(isset($_POST['user_id']) && isset($_POST['user_password']))
    {
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);

        if(empty($user_id))
        {
            echo "<script>
            window.location.href = 'logIn.php?error=please write down id'
            </script>";
            exit();
            //history.back();
            
        }
        else if(empty($user_password))
        {
            header("location: logIn.php?error=please write down password");
            exit();
        }
        else
        {
            $sql = "SELECT * FROM managers WHERE USER_ID='$user_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($row['USER_ID'] != null)
            {
                if(password_verify($user_password, $row['USER_PASSWORD']))
                {
                    $_SESSION['UserInfo'] = $user_id;
                    header("location: index.php");
                }
                else{
                    header("location: logIn.php?error=wrong id or password");
                    exit();
                }
            }
        }
        
    }
    else{
        header("location: logIn.php");
        exit();
    }
?>