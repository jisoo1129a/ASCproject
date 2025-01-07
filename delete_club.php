<?php
$conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);
$sql = "SELECT * FROM clubs;";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result))
{
    $list = $list."<p><input type='checkbox' name='{$row['id']}' id='check_{$row['id']}'><label for='check_{$row['id']}'>{$row['cName']}</li></p>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

    </style>
    <title>Delete</title>
</head>
<body>
    <h3>Choose clubs you want to delete</h3>
    <form action="delete_process.php">
        <?=$list?>
        <input type="submit">
    </form>
    
    
</body>
</html>