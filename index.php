<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<?php
    $conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);

    $login_state = '';
    $btn = '';
    if(isset($_POST['logIn']))
    {
        $login_state = $_POST['user_id'];
    }
    if($_POST['logIn'] == 'loged_out')
    {
        $login_state = '';
    }
    if($login_state != '')
    {
        $btn = '<div><button><a href="add_club.php">Add club</a></button>
        <button><a href="edit_info.php">Edit information</button>
        <button><a href="delete_club.php">Delete Club</a></button></div>';
    }

    //id, supervise

    $sql = "SELECT * FROM clubs;";
    $result = mysqli_query($conn, $sql);
    
    
    $topPic = '';
    $title = '';
    $aboutUs = '';
    $contact = '';
    $meet = '';
    $event = '';
    $project = '';

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $sql = "SELECT * FROM clubs WHERE id={$_GET['id']};";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $article = array(
            'name' => $row['cName'],
            'aboutus' => $row['aboutUs'],
            'meet' => $row['meet'],
            'email' => $row['email']
        );
        
        $events = '';
        $event = null;
        $projects = array();
        $project = null;
        $frqs = '';
        $frq = null;


        if($row['eventlist'] == 1)
        {
            $sql = "SELECT * FROM eventList WHERE club_id = {$id};";
            $result = mysqli_query($conn, $sql);
            $radio = '';

            $i = 0;

            while($eRow = mysqli_fetch_array($result))
            {
                $e = array(
                    'name' => $eRow['eName'],
                    'date' => $eRow['eDate'],
                    'des' => $eRow['description']
                );

                $events = $events."<div id='inner_{$i}' class=\"inner\"><h4>{$e['name']}</h4><p>{$e['des']}</p><p>Date: {$e['date']}</p></div>";
                if($i == 0)
                {
                    $radio = $radio."<input type='radio' name='slide' class='radio' id='radio_{$i}' checked>";
                }
                else $radio = $radio."<input type='radio' name='slide' class='radio' id='radio_{$i}'>";

                $i++;
            }
            $event = '<h2>Club Events</h2><div id="event_outer"><div class="mid"><div id="eBox" class="middleBox">'.$events.'</div></div>'.$radio.'</div>';
        }

        if($row['project'] == 1)
        {
            $sql = "SELECT * FROM projectsList WHERE club_Id = {$id}";
            $result = mysqli_query($conn, $sql);
            $i = 0;
            while($pRow = mysqli_fetch_array($result))
            {
                $p = array(
                    'name' => $pRow['pName'],
                    'date' => $pRow['pDate'],
                    'des' => $pRow['pDescription'],
                    'url' => $pRow['pUrl']
                );
                array_push($projects, "<div class='block' id='block_{$i}' onclick='maximize({$i})'><img src='./pictures/BIGBAND1.png' width='100%' alt='pic'><h4>{$p['name']}</h4><button id='btn_{$i}' style=\"display: none;\">X</button></div>");
                $i++;
            }
            $p = '';
            for($i = 0; $i < count($projects); $i++)
            {
                $p = $p."<div class='inner'>{$projects[$i]}</div>";
            }

            $project = "<div id='project_outer'>
                <h2>Projects</h2>
                    {$p}
                </div>";
        }
        if($row['frq'] == 1)
        {
            $sql = "SELECT * FROM frqList WHERE club_id = {$id}";
            $result = mysqli_query($conn, $sql);
            $i = 1;
            while($fRow = mysqli_fetch_array($result))
            {
                $frqs = $frqs.'<div class="inner"><h4>'.$i.'. '.$fRow['fQuestion'].'</h4><p>'.$fRow['fAnswer'].'</p></div>';
            }
            $frq = "<h2>FRQ</h2><div id='frq_outer'>{$frqs}</div>";
        }
        //$topPic = '<img src='.$article['topPic'].'alt=\'pic\'>';
        $topPic = '<img id="topPic" src= "./pictures/PROGRAMMINGCLUB1.png" alt= "pic" width="100%">';
        $title = "<h1 id='club-title'>".$article['name']."</h1>";
        $aboutUs = '<div id="aboutUs"><h3>About Us</h3><p>'.$article['aboutus'].'</p></div>';
        $contact = '<h3>President</h3><img src="./pictures/unknown.png" alt="pic" /><br><p>Jisoo<br>'.$article['email'].'<br></p>';
        $meet = '<div id="meetInfo"><h3>Meeting Info</h3><p>'.$article['meet'].'</p></div>';
    }
?>
<script>
    function maximize(num)
    {
        const box = document.getElementById("block_" + num);
        const btn = document.getElementById("btn_" + num);
        if(btn.style.display === 'block')
        {
            btn.style.display = 'none';
            box.className = 'block';
            box.style.width = '90%';
            box.style.transform = 'translateX(0%)';
        }
        else{
            btn.style.display = 'block';
            box.className = 'block-clicked';
            box.style.width = '80%';
            //window.innerWidth
        }
        
    }
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.typekit.net/nop3wuo.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">

    
    <title>FA Clubs</title>
</head>
<body>
    <?php include("header.php"); ?>
    <?php if(!isset($_GET['id'])){
        include("home.html"); 
        echo "<script>
            const page = document.getElementById('title');
            document.getElementById('home').style.marginTop = page.offsetHeight + 'px';
        </script>";
    } ?>
    <div id="page">
        <?=$topPic?>
        <?=$title?>
        <?=$btn?>
        <div id="page-content">
                <div>
                    <?=$aboutUs?>
                    <div id="evn_block"><?=$event?></div>
                    <?=$project?>
                    <?=$frq?>
                </div>
                <div id="left-block"><div id="contact"><?=$contact?></div><?=$meet?></div>
        </div>
        
    </div>
    <script>
        const title = document.getElementById("title");
        document.getElementById("page").style.paddingTop = title.offsetHeight + "px";

        
        const radio = document.getElementsByClassName('radio');
        if(radio != null)
        {
            for(let i = 0; i < radio.length; i++){
            const r = document.getElementById('radio_' + i);
            r.addEventListener('click', function(){
                const box = document.getElementById('eBox');
                let v = -100 * i;
                box.style.transform = `translateX(${v}%)`;
            });
            }
        }
        

    </script>
    <div id="footer">
        <p>©2024. Programming Club all rights reserved.</p>
    </div>

</body>
</html>