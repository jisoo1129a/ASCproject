<?php
    $conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fryeburg - Log In</title>
    <style>
        a{
            text-decoration: none;
            color: white;
        }
        html{
            height: 100%;
        }
        body{
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #logInForm{
            border: black dashed 2px;
            padding: 20px;
        }
        #logInForm p{
            margin: 20px;
        }
        #logInForm #schoolEmail, #logInForm #password1, #logInForm #password2{
            width: 300px;
        }
        #logInForm #error{
            background-color: rgb(255, 0, 0, 0.4);
            
            color: red;
            padding: 1px;
        }
        #logInForm #clear{
            background-color: rgb(0, 255, 0, 0.4);
            
            color: green;
            padding: 1px;
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>
    <div>
        <form id="logInForm" action="Create_account_process.php" method="post">
            <?php if(isset($_GET['error'])){ ?>
                <div id="error"><p><?=$_GET['error']?></p></div>
            <?php } ?>
            <?php if(isset($_GET['clear'])){ ?>
                <div id="clear"><p><?=$_GET['clear']?></p></div>
            <?php } ?>
            <p><label for="schoolEmail">School email: </label><input id="schoolEmail" name="user_id" type="email" placeholder="example@fryeburgacademy.org"></p>
            <p><label for="password1">Password: </label><input id="password1" name="user_password1" type="password" placeholder="8 ~ 16 characters"></p>
            <p><label for="password2">Re-type Password: </label><input id="password2" name="user_password2" type="password" placeholder="re-write password"></p>
            <p><input type="submit" style="margin-right: 10px;" value="Create account"></p>
        </form>
    </div>
    
</body>
</html>