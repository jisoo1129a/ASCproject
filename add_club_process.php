<?php
    $conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);
    $filtered_info = array(
        'name' => mysqli_real_escape_string($conn, $_GET['cName']),
        'aboutUs' => mysqli_real_escape_string($conn, $_GET['aboutUs']),
        'meet'=>mysqli_real_escape_string($conn, $_GET['meet']),
        'email'=>mysqli_real_escape_string($conn, $_GET['email'])
    );
    $sql = "
        INSERT INTO clubs(cName, aboutUs, meet, email, lastUpdated)
        VALUES(
            '{$filtered_info['name']}',
            '{$filtered_info['aboutUs']}',
            '{$filtered_info['meet']}',
            '{$filtered_info['email']}',
            NOW()
        );
    ";
    mysqli_query($conn, $sql);
    $id = mysqli_insert_id($conn);

    $sql = '';

    if(isset($_GET['events']))
    {
        $sql = "UPDATE clubs SET eventlist = 1 WHERE id = {$id};";
        mysqli_query($conn, $sql);

        for($i = 0; $i < 9; $i++)
        {
            if(!isset($_GET['eName_'.$i])){ break; }

            $filtered = array(
                'name' => mysqli_real_escape_string($conn, $_GET['eName_'.$i]),
                'date' => mysqli_real_escape_string($conn, $_GET['eDate_'.$i]),
                'des' => mysqli_real_escape_string($conn, $_GET['eDescription_'.$i])
            );


            $sql = "
                INSERT INTO eventList(eName, eDate, description, club_id)
                VALUES(
                    '{$filtered['name']}',
                    '{$filtered['date']}',
                    '{$filtered['des']}',
                    '{$id}'
                );
            ";

            mysqli_query($conn, $sql);
        }
    }
    if(isset($_GET['pName_0']))
    {
        $sql = "UPDATE clubs SET project = 1 WHERE id = {$id};";
        mysqli_query($conn, $sql);

        for($i = 0; $i < 9; $i++)
        {
            if(!isset($_GET['pName_'.$i])){
                break;
            }
            $filtered = array(
                'name' => mysqli_real_escape_string($conn, $_GET['pName_'.$i]),
                'date' => mysqli_real_escape_string($conn, $_GET['pDate_'.$i]),
                'des' => mysqli_real_escape_string($conn, $_GET['pDescription_'.$i])
            );

            $sql = "INSERT INTO
                    projectsList(club_Id, pName, pDate, pDescription)
                    VALUES(
                        '{$id}',
                        '{$filtered['name']}',
                        '{$filtered['date']}',
                        '{$filtered['des']}'
                    );";
            mysqli_query($conn, $sql);
        }
    }
    if(isset($_GET['fQuestion_0']))
    {
        $sql = "UPDATE clubs SET frq = 1 WHERE id = {$id};";
        mysqli_query($conn, $sql);

        for($i = 0; $i < 9; $i++)
        {
            if(!isset($_GET['fQuestion_'.$i])){
                break;
            }
            $filtered = array(
                'q' => mysqli_real_escape_string($conn, $_GET['fQuestion_'.$i]),
                'a' => mysqli_real_escape_string($conn, $_GET['fAnswer_'.$i])
            );

            $sql = "INSERT INTO frqList(club_id, fQuestion, fAnswer, fUpdated) VALUES('{$id}', '{$filtered['q']}', '{$filtered['a']}', NOW());";
            mysqli_query($conn, $sql);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FA clubs</title>
</head>
<body>
    <h3>successful</h3>
    <?php
        echo($_GET['eName_0']);
    ?>
    <a href="index.php">back</a>
</body>
</html>