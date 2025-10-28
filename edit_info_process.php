<?php
$conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);
session_start();



$filtered_info = array(
    'id' => mysqli_real_escape_string($conn, $_POST['c_identification']),
    'name' => mysqli_real_escape_string($conn, $_POST['c_name']),
    'aboutUs' => mysqli_real_escape_string($conn, $_POST['c_about']),
    'meet'=>mysqli_real_escape_string($conn, $_POST['c_meet']),
    'email'=>mysqli_real_escape_string($conn, $_POST['c_email'])
);
$sql = "
    UPDATE clubs SET cName='{$filtered_info['name']}',
                    aboutUs='{$filtered_info['aboutUs']}',
                    meet='{$filtered_info['meet']}',
                    email='{$filtered_info['email']}',
                    lastUpdated=NOW()
    WHERE id={$filtered_info['id']};
";


mysqli_query($conn, $sql);

$id = $filtered_info['id'];

$upload_dir = 'pictures/';
if(isset($_FILES['d_top_pic']) && $_FILES['d_top_pic']['error'] != 4)
{
    echo 'd_top_pic file exists';
    $sql = "SELECT topImg FROM clubs WHERE id = {$id}";
    $result = mysqli_query($conn, $sql);
    $filePath = mysqli_fetch_array($result);

    if (file_exists($filePath[0])) {
        unlink($filePath[0]);
    }
    else {
        echo "File not found.<br>";
    }

    $image = $_FILES['d_top_pic'];
    $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    $target_file = $upload_dir.$filtered_info['name']."_topImg.". $imageFileType;

    $result = move_uploaded_file($image['tmp_name'], $target_file);

    if($result)
    {
        chmod($target_file, 0777);
        $sql = "UPDATE clubs SET topImg = '{$target_file}' WHERE id = {$id}";
        mysqli_query($conn, $sql);
    }
    else
    {
        echo "image upload error";
    }
}

if(isset($_FILES['d_adv_pic']) && $_FILES['d_adv_pic']['error'] != 4)
{
    echo 'd_adv_pic file exists';
    $image = $_FILES['d_adv_pic'];
    $sql = "SELECT advImg FROM clubs WHERE id={$id}";
    $result = mysqli_query($conn, $sql);
    $filePath = mysqli_fetch_array($result);

    if (file_exists($filePath['advImg'])) {
        unlink($filePath['advImg']);
    }
    else {
        echo "File not found.";
    }

    var_dump($image);
    $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    $target_file = $upload_dir.$filtered_info['name']."_adv_img.". $imageFileType;

    if(move_uploaded_file($image['tmp_name'], $target_file))
    {
        chmod($target_file, 0777);
        $sql = "UPDATE clubs SET advImg = '{$target_file}' WHERE id = {$id}";
        mysqli_query($conn, $sql);
    }
    else
    {
        echo "image upload error";
    }
}




$sql = '';


if(isset($_POST['e_name_1']))
{
    $sql = "UPDATE clubs SET eventlist = 1 WHERE id = {$id};";
    mysqli_query($conn, $sql);

    for($i = 1; $i < 10; $i++)
    {
        
        if(!isset($_POST['e_identification_'.$i]))
        {
            if(!isset($_POST['e_name_'.$i])){ break; }
            if($_POST['e_name_'.$i] == ''){ break; }
            $filtered = array(
                'name' => mysqli_real_escape_string($conn, $_POST['e_name_'.$i]),
                'date' => mysqli_real_escape_string($conn, $_POST['e_date_'.$i]),
                'des' => mysqli_real_escape_string($conn, $_POST['e_des_'.$i])
            );

            $sql = "INSERT INTO
                eventList(eName, eDate, description, club_id)
                VALUES(
                    '{$filtered['name']}',
                    '{$filtered['date']}',
                    '{$filtered['des']}',
                    '{$id}'
                );";
        }
        else{
            
            if(!isset($_POST['e_name_'.$i]) || $_POST['e_name_'.$i] == '')
            {
                $sql = "DELETE FROM eventList WHERE id = {$_POST['e_identification_'.$i]}";
            }
            else
            {
                $filtered = array(
                    'id' => mysqli_real_escape_string($conn, $_POST['e_identification_'.$i]),
                    'name' => mysqli_real_escape_string($conn, $_POST['e_name_'.$i]),
                    'date' => mysqli_real_escape_string($conn, $_POST['e_date_'.$i]),
                    'des' => mysqli_real_escape_string($conn, $_POST['e_des_'.$i])
                );
                $sql = "
                UPDATE eventList
                SET eName='{$filtered['name']}',
                    eDate='{$filtered['date']}',
                    description='{$filtered['des']}',
                    club_id='{$filtered_info['id']}'
                WHERE id = {$filtered['id']};
                ";
            }
            
            
        }
        mysqli_query($conn, $sql);
    }
}

if(isset($_POST['p_name_1']))
{
    $sql = "UPDATE clubs SET project = 1 WHERE id = {$id};";
    mysqli_query($conn, $sql);

    for($i = 1; $i < 10; $i++)
    {
        if(!isset($_POST['p_identification_'.$i]))
        {
            if(!isset($_POST['p_name_'.$i])){ break; }
            if($_POST['p_name_'.$i] == ''){ break; }

            $filtered = array(
                'name' => mysqli_real_escape_string($conn, $_POST['p_name_'.$i]),
                'date' => mysqli_real_escape_string($conn, $_POST['p_date_'.$i]),
                'des' => mysqli_real_escape_string($conn, $_POST['p_des_'.$i])
            );
            $sql = "INSERT INTO
                projectsList(club_Id, pName, pDate, pDescription)
                VALUES(
                    '{$filtered_info['id']}',
                    '{$filtered['name']}',
                    '{$filtered['date']}',
                    '{$filtered['des']}'
                );";
            
            mysqli_query($conn, $sql);

            $identification = mysqli_insert_id($conn);
            var_dump($identification);
            if(isset($_FILES['p_picture'.$i]) && $_FILES['p_picture'.$i]['error'] != 4)
            {
                $image = $_FILES['p_picture'.$i];
                
                $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
                $target_file = $upload_dir.$filtered_info['name']."_project_".$i."_picture.".$imageFileType;
                if(move_uploaded_file($image['tmp_name'], $target_file))
                {
                    $sql = "UPDATE projectsList SET pUrl = '{$target_file}' WHERE id = {$identification}";
                    mysqli_query($conn, $sql);
                }
                else
                {
                    echo "image upload error<br>";
                }
            }

        }
        else{
            if(!isset($_POST['p_name_'.$i]) || $_POST['p_name_'.$i] == '')
            {
                $identification = $_POST['p_identification_'.$i];
                $sql = "DELETE FROM projectsList WHERE id = {$identification}";
                mysqli_query($conn, $sql);
            }
            else{
                $filtered = array(
                    'id' => mysqli_real_escape_string($conn, $_POST['p_identification_'.$i]),
                    'name' => mysqli_real_escape_string($conn, $_POST['p_name_'.$i]),
                    'date' => mysqli_real_escape_string($conn, $_POST['p_date_'.$i]),
                    'des' => mysqli_real_escape_string($conn, $_POST['p_des_'.$i])
                );
                $sql = "
                UPDATE projectsList
                SET pName='{$filtered['name']}',
                    pDate='{$filtered['date']}',
                    pDescription='{$filtered['des']}',
                    club_Id= {$id}
                WHERE id = {$filtered['id']};
                ";
                mysqli_query($conn, $sql);

                if(isset($_FILES['p_picture'.$i]) && $_FILES['p_picture'.$i]['error'] != 4)
                {
                    $image = $_FILES['p_picture'.$i];
                    $sql = "SELECT pUrl FROM projectsList WHERE id= {$filtered['id']};";
                    $result = mysqli_query($conn, $sql);
                    $filePath = mysqli_fetch_array($result);
                    if (file_exists($filePath['pUrl'])) {
                        unlink($filePath['pUrl']);
                    }
                    else {
                        echo "File not found.<br>";
                    }

                    $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
                    $target_file = $upload_dir.$filtered_info['name']."_project_".$i."_picture.".$imageFileType;
                    if(move_uploaded_file($image['tmp_name'], $target_file))
                    {
                        $sql = "UPDATE projectsList SET pUrl = '{$target_file}' WHERE id = {$filtered['id']}";
                        mysqli_query($conn, $sql);
                    }
                    else
                    {
                        echo "image upload error<br>";
                    }
                } 
            }

        }
        
    }
}

if(isset($_POST['f_ques_1']) && $_POST['f_ques_1'] != '')
{
    $sql = "UPDATE clubs SET frq = 1 WHERE id = {$id};";
    mysqli_query($conn, $sql);

    for($i = 1; $i < 10; $i++)
    {
        if(!isset($_POST['f_identification_'.$i]))
        {
            if(!isset($_POST['f_ques_'.$i])){ break; }
            if($_POST['f_ques_'.$i] == ''){ break; }
            $filtered = array(
                'q' => mysqli_real_escape_string($conn, $_POST['f_ques_'.$i]),
                'a' => mysqli_real_escape_string($conn, $_POST['f_ans_'.$i])
            );
            $sql =
            "INSERT INTO frqList(club_id, fQuestion, fAnswer, fUpdated)
            VALUES(
                '{$id}',
                '{$filtered['q']}',
                '{$filtered['a']}',
                NOW()
            );";
        }
        else{

            if(!isset($_POST['f_ques_'.$i]) || $_POST['f_ques_'.$i] == ''){
                $sql = "DELETE FROM frqList WHERE id={$_POST['f_identification_'.$i]}";
            }
            else{
                $filtered = array(
                    'id' => mysqli_real_escape_string($conn, $_POST['f_identification_'.$i]),
                    'q' => mysqli_real_escape_string($conn, $_POST['f_ques_'.$i]),
                    'a' => mysqli_real_escape_string($conn, $_POST['f_ans_'.$i])
                );
                $sql = "
                UPDATE frqList
                SET fQuestion='{$filtered['q']}',
                    fAnswer='{$filtered['a']}',
                    club_id='{$id}',
                    fUpdated=NOW()
                WHERE id = {$filtered['id']};
            ";
            }
            
        }


        
        mysqli_query($conn, $sql);
    }
}
header('location: index.php');

?>
