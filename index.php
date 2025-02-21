<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<?php
    $conn = mysqli_connect("localhost", "demo", "00000000", "CLUB", 3306);
    $sql = "SELECT * FROM clubs;";
    $result = mysqli_query($conn, $sql);

    $list = '<button><a href="add_club.php">Add club</a></button>
        <button><a href="delete_club.php">Delete Club</a></button>';
    while($row = mysqli_fetch_array($result))
    {
        $list = $list."<li><a href=\"index.php?id={$row['id']}\">{$row['cName']}</a></li>";
    }
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

                $events = $events."<div id='inner_{$i}' class=\"inner\"><h4>{$e['name']}</h4><p>{$e['des']}</p><p>planned date: {$e['date']}</p></div>";
                if($i == 0)
                {
                    $radio = $radio."<input type='radio' name='slide' class='radio' id='radio_{$i}' checked>";
                }
                else $radio = $radio."<input type='radio' name='slide' class='radio' id='radio_{$i}'>";

                $i++;
            }
            $event = '<div id="event_outer"><h2>Club Events</h2><div class="mid"><div id="eBox" class="middleBox">'.$events.'</div></div>'.$radio.'</div>';
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
            for($i = 1; $i < count($projects); $i++)
            {
                if($i % 2 == 1)
                {
                    $p = $p."<div class='inner'>{$projects[$i - 1]}{$projects[$i]}</div>";
                }
                else if($i == count($projects) - 1 && $i % 2 == 0)
                {
                    $p = $p."{$projects[$i]}";
                }
            }

            $project = "<div id='project_outer'>
                <h2><u>Projects</u></h2>
                    {$p}
                </div>
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
        $topPic = '<img src= "./pictures/PROGRAMMINGCLUB1.png" alt= "pic" width="100%">';
        $title = "<h1 id='club-title'>".$article['name']."</h1>";
        $aboutUs = '<h2 id="aboutUs">About Us</h2><p id="aboutUs_p">'.$article['aboutus'].'</p>';
        $contact = '<p>If you want to join the club or have a question, contact here! '.$article['email'].'</p>';
        $meet = '<p>'.$article['meet'].'</p>';
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
        }
        else{
            btn.style.display = 'block';
            box.className = 'block-clicked';
            box.style.width = window.innerWidth;
        }
        
    }
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">
    
    <title>FA Clubs</title>
</head>
<body>
    <div id="title">
        <img src="./pictures/schoolLogo-white.png" alt="logo"/>
        <a id="header" href="index.php"><h1>Fryeburg Academy Clubs</h1></a>
        <p id="logIn"><a href="logIn.html">Log In</a><a href="Create_account.php"> | Create account</a></p>
    </div>
    <div id="page" >
        <div id="club-list">
            <ul><?=$list?></ul>
        </div>
        <div id="page-content">
            <?=$topPic?>
            <?=$title?>
            <?=$aboutUs?>
            <?=$contact?>
            <?=$meet?>
            <?=$event?>
            <?=$project?>
            
            <?=$frq?>

            <?php
                if(!isset($_GET['id'])){ include("home.html"); }
            ?>
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