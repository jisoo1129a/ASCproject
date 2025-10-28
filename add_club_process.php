<?php
    $conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);
    session_start();

    $filtered_info = array(
        'name' => mysqli_real_escape_string($conn, $_POST['cName']),
        'aboutUs' => mysqli_real_escape_string($conn, $_POST['aboutUs']),
        'meet'=>mysqli_real_escape_string($conn, $_POST['meet']),
        'email'=>mysqli_real_escape_string($conn, $_POST['email']),
        'adv_name'=>mysqli_real_escape_string($conn, $_POST['adv_name'])
    );
    $sql = "
    INSERT INTO clubs(cName, aboutUs, meet, email, adv_name, lastUpdated)
        VALUES(
            '{$filtered_info['name']}',
            '{$filtered_info['aboutUs']}',
            '{$filtered_info['meet']}',
            '{$filtered_info['email']}',
            '{$filtered_info['adv_name']}',
            NOW()
        );
    ";
    mysqli_query($conn, $sql);
    $id = mysqli_insert_id($conn);

    $sql = '';
    $upload_dir = 'pictures/';


    $image = $_FILES['topPic'];
    $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    $target_file = $upload_dir.$filtered_info['name']."_topImg.". $imageFileType;


    $result = move_uploaded_file($image['tmp_name'], $target_file);
    chmod($target_file, 0777);

    if($result){
        $sql = "UPDATE clubs SET topImg = '{$target_file}' WHERE id = {$id}";
        mysqli_query($conn, $sql);
    }
    else{ echo "<br>img upload error_1<br>";}

    $image = $_FILES['adv_pic'];
    $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    $target_file = $upload_dir.$filtered_info['name']."_advImg.".$imageFileType;


    $result = move_uploaded_file($image['tmp_name'], $target_file);
    chmod($target_file, 0777);

    if($result){
        $sql = "UPDATE clubs SET advImg = '{$target_file}' WHERE id={$id}";
        mysqli_query($conn, $sql);
    }
    else{ echo "img upload error_2<br>";}



    
    

    
    if(isset($_POST['events']))
    {
        $sql = "UPDATE clubs SET eventlist = 1 WHERE id = {$id};";
        mysqli_query($conn, $sql);

        for($i = 0; $i < 9; $i++)
        {
            if(!isset($_POST['eName_'.$i])){ break; }

            $filtered = array(
                'name' => mysqli_real_escape_string($conn, $_POST['eName_'.$i]),
                'date' => mysqli_real_escape_string($conn, $_POST['eDate_'.$i]),
                'des' => mysqli_real_escape_string($conn, $_POST['eDescription_'.$i])
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
    if(isset($_POST['pName_0']))
    {
        $sql = "UPDATE clubs SET project = 1 WHERE id = {$id};";
        mysqli_query($conn, $sql);

        for($i = 0; $i < 9; $i++)
        {
            if(!isset($_POST['pName_'.$i])){
                break;
            }
            $filtered = array(
                'name' => mysqli_real_escape_string($conn, $_POST['pName_'.$i]),
                'date' => mysqli_real_escape_string($conn, $_POST['pDate_'.$i]),
                'des' => mysqli_real_escape_string($conn, $_POST['pDescription_'.$i]),
                'image' => $_FILES['p_pictures_'.$i]
            );
            $target_file = $upload_dir.'project_'.$i.'_club_'.$id;
            if(move_uploaded_file($filtered['image']['tmp_name'], $target_file))
            {
                chmod($target_file, 0777);
                $sql = "INSERT INTO
                    projectsList(club_Id, pName, pDate, pDescription, pUrl, pNum)
                    VALUES(
                        '{$id}',
                        '{$filtered['name']}',
                        '{$filtered['date']}',
                        '{$filtered['des']}',
                        '{$target_file}',
                        '{$id}'
                    );";
                mysqli_query($conn, $sql);
            }
            
        }
    }
    if(isset($_POST['fQuestion_0']))
    {
        $sql = "UPDATE clubs SET frq = 1 WHERE id = {$id};";
        mysqli_query($conn, $sql);

        for($i = 0; $i < 9; $i++)
        {
            if(!isset($_POST['fQuestion_'.$i])){
                break;
            }
            $filtered = array(
                'q' => mysqli_real_escape_string($conn, $_POST['fQuestion_'.$i]),
                'a' => mysqli_real_escape_string($conn, $_POST['fAnswer_'.$i])
            );

            $sql = "INSERT INTO frqList(club_id, fQuestion, fAnswer, fUpdated) VALUES('{$id}', '{$filtered['q']}', '{$filtered['a']}', NOW());";
            mysqli_query($conn, $sql);
        }
    }
    header('location: index.php');
?>