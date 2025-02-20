<?php
    $conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);
    $sql = "SELECT * FROM clubs;";
    $result = mysqli_query($conn, $sql);
    $list = '';
    while($row = mysqli_fetch_array($result))
    {
        $list = $list."<li><a href=\"index.php?id={$row['id']}\">{$row['cName']}</a></li>";
    }
?>
<style>
    #title{
        background-color: #002D5B;
        color: white;
        width: 100%;
        margin: 0px; padding: 10px;
        position: fixed;
        display: grid;
        grid-template-columns: 150px 80% 10%;
        align-items: center;
        top: 0; left: 0;
        z-index: 10;
    }
    #title img{
        padding-left: 23%;
        width: 100px;
    }
    #title h1{
        color: white;
        font-family: "adobe-garamond-pro", serif;
        font-weight: 400;
        font-style: normal;
        font-size: 200%;
    }
    #title a{
        color: white;
    }
    #side-menu
    {
        position: fixed;
        z-index: 11;
        background-color: #002D5B;
        top: 20%;
        left: 0;
        padding: 30px;
        transform: translateX(-80%);
        transition: all 0.5s;
    }
    #side-menu:hover
    {
        transform: translateX(0%);
    }
    #side-menu li{
        list-style-type: none;
    }
    #side-menu a{
        font-family: "adobe-garamond-pro", serif;
        font-weight: 400;
        font-style: normal;
        color: white;
    }
</style>
<div>
    <div id="title">
        <img src="./pictures/SchoolLogo.png" alt="logo"/>
        <a id="header" href="index.php"><h1>FRYEBURG ACADEMY</h1></a>
        <p id="logIn"><a href="logIn.php">Log In</a><a href="Create_account.php"> | Create Account</a></p>
    </div>
    <div id="side-menu">
        
        <?=$list?>
    </div>
</div>
