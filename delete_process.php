<?php
    $conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);
    $sql = "SELECT COUNT(id) FROM clubs;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    
    for($i = 0; $i < 100; $i++)
    {
        if(isset($_GET[$i]))
        {
            $sql = "DELETE FROM clubs WHERE id={$i};";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM eventList WHERE club_id={$i};";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM frqList WHERE club_id={$i};";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM projectsList WHERE club_Id={$i};";
            mysqli_query($conn, $sql);
        }
    }

?>
<a href="index.php">back</a>