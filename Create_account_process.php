<?php
    $conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);
    $id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $password = mysqli_real_escape_string($conn, $_POST['user_password']);
    
    if(strlen($password) < 8) echo "<script>location.href=</script>"
?>