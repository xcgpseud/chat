<?php

if(!defined("SERVLET"))
    die ("You may not view this page directly.");

?>

<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <title>Index page</title>

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- JS -->
    <script src="js/chatsystem.js"></script>
    <script src="js/jq.js"></script>
    <script>

        $(document).ready(function(){
            valign("#maincontainer", 3);
        })

    </script>

</head>

<body>

<a href="index.php">
    <button id="home">Home</button>
</a>
<a href="index.php?action=newpass">
    <button id="logout">Change password</button>
</a>
<a href="index.php?action=logout">
    <button id="logout">Log Out</button>
</a>

<div class="container text-center" id="maincontainer">

    <div id="errors">

        <?php if($this->errors != null) {

            foreach($this->errors as $error){
                ?>

                <p><?php echo $error ?></p>

                <?php
            }
        }
        ?>

    </div>

    <h1>Change Password</h1>

    <div id="nav">

        <form method="post" action="index.php?action=updatepassword">
            <label>New Password <input type="password" name="newPassword" id="newPassword"/></label>
            <input type="submit" value="login"/>
        </form>

    </div>

</div>

</body>

</html>