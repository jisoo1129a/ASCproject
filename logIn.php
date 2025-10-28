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
        #logInForm #schoolEmail, #logInForm #password{
            width: 300px;
        }
        #logInForm #error{
            background-color: rgb(255, 0, 0, 0.4);
            
            color: red;
            padding: 1px;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include("header.php");
    ?>
    <div>
        <form id="logInForm" action="logIn_process.php" method="post">
            <?php if(isset($_GET['error'])){ ?>
                <div id="error"><p><?=$_GET['error']?></p></div>
            <?php } ?>
            <p><label for="schoolEmail">School email: </label><input id="schoolEmail" name="user_id" type="email" placeholder="example@fryeburgacademy.org"></p>
            <p><label for="password">Password: </label><input id="password" name="user_password" type="password" placeholder="8 ~ 16 characters" ></p>
            <p><input type="submit" style="margin-right: 10px;"></p>
        </form>
    </div>
    
</body>
</html>