<!DOCTYPE html>
<?php

use function PHPSTORM_META\type;

    session_start();
    $conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);

    $id = $_GET['id'];

    if(!isset($id))
    {
        header('location: index.php');
    }

    $sql = "SELECT * FROM clubs WHERE id= {$_GET['id']};";
    
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $article = array(
        'id' => $id,
        'name' => $row['cName'],
        'aboutus' => $row['aboutUs'],
        'meet' => $row['meet'],
        'email' => $row['email'],
        'adv_name' => $row['adv_name']
    );


    $events = array();
    $projects = array();
    $frqs = array();

    if($row['eventlist'] == 1)
    {
        $sql = "SELECT * FROM eventList WHERE club_id = {$id};";
        $result = mysqli_query($conn, $sql);
        while($eRow = mysqli_fetch_array($result))
        {
            $e = array(
                'id' => $eRow['id'],
                'name' => $eRow['eName'],
                'date' => $eRow['eDate'],
                'des' => $eRow['description']
            );
            array_push($events, $e);
        }
    }

    if($row['project'] == 1)
    {
        $sql = "SELECT * FROM projectsList WHERE club_Id = {$id}";
        $result = mysqli_query($conn, $sql);
        
        while($pRow = mysqli_fetch_array($result))
        {
            $p = array(
                'id' => $pRow['id'],
                'name' => $pRow['pName'],
                'date' => $pRow['pDate'],
                'des' => $pRow['pDescription'],
                'url' => $pRow['pUrl']
            );
            array_push($projects, $p);
        }
    }
    if($row['frq'] == 1)
    {
        $sql = "SELECT * FROM frqList WHERE club_id = {$id}";
        $result = mysqli_query($conn, $sql);

        while($fRow = mysqli_fetch_array($result))
        {
            $f = array(
                'id' => $fRow['id'],
                'question' => $fRow['fQuestion'],
                'answer' => $fRow['fAnswer']
            );
            array_push($frqs, $f);
        }
        
    }
    
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FA CLUBS</title>
    <style>
        .d_text_box{
            width: 400px;
        }
        #list-section
        {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
        }
    </style>
</head>
<body>
    <h2>Editting information</h2>
    <form action="edit_info_process.php" method="post" enctype="multipart/form-data">
        <p><strong>Upload files in case you want to change.</strong></p>
        <input name="c_identification" value="<?=$article['id']?>" hidden>
        <p><label for="d_name">Club Name: </label><input class="d_text_box" id="d_name" name="c_name" type="text" value="<?=$article['name']?>" required></p>
        <p><label for ="d_top_pic">Representative Picture: </label><input type="file" id="d_top_pic" name="d_top_pic" accept=".png, .jpg, .jpeg"></p>
        <p><label for="d_aboutUs">About Us: </label><input class="d_text_box" id="d_aboutUs" name="c_about" type="text" value="<?=$article['aboutus']?>" required></p>
        <p><label for="d_meet">Meeting Time: </label><input class="d_text_box" id="d_meet" name="c_meet" type="text" value="<?=$article['meet']?>"></p>
        <p><label for="d_adv_name">Advisory or President Name: </label><input class="d_text_box" id="d_adv_name" type="text" name="c_adv_name" value="<?=$article['adv_name']?>"></p>
        <p><label for="d_email">President / Advisory Email: </label><input class="d_text_box" name="c_email" id="d_email" type="email" value="<?=$article['email']?>" required></p>
        <p><label for ="d_adv_pic">President / Advisory Picture: </label><input type="file" id="d_adv_pic" name="d_adv_pic" accept=".png, .jpg, .jpeg"></p>
        <div id="list-section">
            <div>
                <p>Events</p>
                <?php
                    $output = '<div>';
                    for($i = 1; $i < 10; $i++)
                    {
                        if($events[$i - 1] != null)
                        {
                            $output = $output.'<p style= "margin-bottom: 30px;">'.$i.'<br>';
                            $output = $output.'<input name="e_identification_'.$i.'" value="'.$events[$i - 1]['id'].'" hidden>';
                            $output = $output.'<input type="text" class="d_text_box" name="e_name_'.$i.'" value="'.$events[$i - 1]['name'].'"><br>';
                            $output = $output.'<input type="date" name="e_date_'.$i.'" value='.$events[$i - 1]['date'].'><br>';
                            $output = $output."<input type='text' name='e_des_".$i."' class='d_text_box' value='".$events[$i - 1]['des']."'></p>";
                        }
                        else
                        {
                            $output = $output.'<p style= "margin-bottom: 30px;">'.$i.'<br>';
                            $output = $output.'<input type="text" class="d_text_box" name="e_name_'.$i.'" placeholder="title"><br>';
                            $output = $output.'<input type="date" name="e_date_'.$i.'"><br>';
                            $output = $output.'<input type="text" name="e_des_'.$i.'" class="d_text_box" placeholder="description"></p>';
                        }
                        
                    }
                    $output = $output.'</div>';

                    echo $output;
                ?>
            </div>
            <div>
                <p>Projects</p>
                <?php
                    $output = '<div>';
                    for($i = 1; $i < 10; $i++)
                    {
                        if($projects[$i - 1] != null)
                        {
                            $output = $output.'<p style= "margin-bottom: 30px;">'.$i.'<br>';
                            $output = $output.'<input name="p_identification_'.$i.'" value="'.$projects[$i - 1]['id'].'" hidden>';
                            $output = $output.'<input type="text" class="d_text_box" name="p_name_'.$i.'" value="'.$projects[$i - 1]['name'].'"><br>';
                            $output = $output.'<input type="date" name="p_date_'.$i.'" value='.$projects[$i - 1]['date'].'><br>';
                            $output = $output.'<input type="text" name="p_des_'.$i.'" class="d_text_box" value="'.$projects[$i - 1]['des'].'"><br>';
                            $output = $output.'<label for ="p_picture'.$i.'">Project Picture: </label><input type="file" id="p_picture'.$i.'" name="p_picture'.$i.'"></p>';
                        }
                        else{
                            $output = $output.'<p style= "margin-bottom: 30px;">'.$i.'<br>';
                            $output = $output.'<input type="text" class="d_text_box" name="p_name_'.$i.'" placeholder="title"><br>';
                            $output = $output.'<input type="date" name="p_date_'.$i.'"><br>';
                            $output = $output.'<input type="text" name="p_des_'.$i.'" class="d_text_box" placeholder="description"><br>';
                            $output = $output.'<label for ="p_picture'.$i.'">Project Picture: </label><input type="file" id="p_picture'.$i.'" name="p_picture'.$i.'"></p>';
                        }
                        
                    }
                    $output = $output.'</div>';

                    echo $output;
                ?>
            </div>
            <div>
                <p>FRQs</p>
                <?php
                    $output = '<div>';
                    for($i = 1; $i < 10; $i++)
                    {
                        if($frqs[$i - 1] != null)
                        {
                            $output = $output.'<p style= "margin-bottom: 30px;">'.$i.'<br>';
                            $output = $output.'<input name="f_identification_'.$i.'" value="'.$frqs[$i - 1]['id'].'" hidden>';
                            $output = $output.'<input type="text" class="d_text_box" name="f_ques_'.$i.'" value="'.$frqs[$i - 1]['question'].'"><br>';
                            $output = $output.'<input type="text" class="d_text_box" name="f_ans_'.$i.'" value="'.$frqs[$i - 1]['answer'].'"></p>';
                        }
                        else
                        {
                            $output = $output.'<p style= "margin-bottom: 30px;">'.$i.'<br>';
                            $output = $output.'<input type="text" class="d_text_box" name="f_ques_'.$i.'" placeholder="question"><br>';
                            $output = $output.'<input type="text" class="d_text_box" name="f_ans_'.$i.'" placeholder="answer"></p>';
                        }
                        
                    }
                    $output = $output.'</div>';

                    echo $output;
                ?>
            </div>
            <p><input type="submit"><button style="margin-left: 30px;" onclick="history.back();">back</button></p>
        </div>
    </form>
</body>
</html>