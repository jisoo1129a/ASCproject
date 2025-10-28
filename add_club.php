<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="add_club.css">
    <title>FA Clubs</title>
</head>
<body>
    <h1>Add new club</h1>
    <div id="page">
        <div>
            <h2>This section is for creating new club page</h2>
            <p>
            * is required information<br>
            1. Email<br>
            Please write president or advisory who will update the club information.<br>
            2. Club name & description<br>
            Name should be appropriate and no more than 30 characters. Club description will be shown 'about us' section. <br>
            3. Representative picture is file of picture that will be shown on the top page.<br>
            </p>
        </div>
        <div>
            <form action="add_club_process.php" method="post" enctype="multipart/form-data">
                <p>Email*: <input type="email" name="email" placeholder="example@fryeburgacademy.org"></p>
                <p>Advisory or President Name*: <input type="text" name="adv_name" placeholder="name"></p>
                <p>Advisory or President Picture: <input type="file" name="adv_pic" accept=".png, .jpg, .jpeg"></p>
                <p>Club Name*: <input type="text" name="cName" placeholder="Club Name" required></p>
                <textarea name="aboutUs" placeholder="Club description" required style="width: 50%;"></textarea>
                <p>Representative Picture*: <input type="file" name="topPic" accept=".png, .jpg, .jpeg"></p>
                <p>Meet: <input type="text" name="meet" placeholder="e.g. We meet every Wednesday in the computer lab" style="width: 50%;"></p>
                <p>Extra Materials:
                    <input type="checkbox" id="events" name="events" onclick="eventForm(0)"><label for="events">Upcoming events section</label>
                    <input type="checkbox" id="projects" name="projects" onclick="projectForm(0)"><label for="projects">Project section</label>
                    <input type="checkbox" id="frq" name="frq" onclick="frqForm(0)"><label for="frq">FRQ section</label>
                </p>
                <div id="eventsInput"></div>
                <div id="projectsInput"></div>
                <div id="frqInput"></div>

                <div><input type="submit"><button style="margin-left: 20px;" onclick="history.back();">back</button></div>
            </form>
        </div>
    </div>
    
    <script>

        function frqForm(focus){
            const box = document.getElementById('frqInput');
            const check = document.getElementById('frq');

            let li = [];
            let text = '';

            active(box, check, 'frqForm', focus);
            for(let i = 0; i < focus; i++)
            {
                text = `
                <p>Question: <input type="text" name="fQuestion_${i}" placeholder="Question" required></p>\
                <p>Answert: <input type="text" name="fAnswer_${i}" placeholder="Answer" requried></p><hr />`;

                li.push(text);
            }
            box.innerHTML += li.join('');
        }
        function projectForm(focus)
        {
            const box = document.getElementById('projectsInput');
            const check = document.getElementById('projects');

            let li = [];
            let text = '';

            active(box, check, 'projectForm', focus);
            for(let i = 0; i < focus; i++)
            {
                text = `
                <p>Project Name: <input type="text" name="pName_${i}" placeholder="Project Name" required></p>\
                <p>Project Date: <input type="date" name="pDate_${i}"></p>\
                <p>Project Description: <input type="text" name="pDescription_${i}" placeholder="Project Description"></p>\
                <p>Project Picture: <input type="file" name="p_pictures_${i}" accept=".png, .jpg, .jpeg"></p><hr />`;

                li.push(text);
            }
            box.innerHTML += li.join('');
        }
        function eventForm(focus)
        {
            const box = document.getElementById('eventsInput');
            const check = document.getElementById('events');

            let li = [];
            let text = '';

            active(box, check, 'eventForm', focus);
            for(let i = 0; i < focus; i++)
            {
                text = `
                <p>event name: <input type="text" name="eName_${i}" placeholder="event name" required></p>\
                <p>event date: <input type="date" name="eDate_${i}"></p>\
                <p>event description: <input type="text" name="eDescription_${i}" placeholder="event description"></p><hr />`;

                li.push(text);
            }
            box.innerHTML += li.join('');
        }

        function active(eId, cId, fId, focus)
        {
            const box = eId;
            const check = cId;

            if(check.checked === true)
            {
                let li = [];

                for(let i = 0; i < 10; i++)
                {
                    if(i === focus){text = `<input type="radio" id="${i}" onclick="${fId}(${i})" checked><label for="${i}">${i}</label>`;}
                    else{text = `<input type="radio" id="${i}" onclick="${fId}(${i})"><label for="${i}">${i}</label>`;}
                    li.push(text);
                }
                box.innerHTML = li.join('');
            }
            else{box.innerHTML = '';}
        }
    </script>
</body>
</html>