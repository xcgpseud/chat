<?php

if(!defined("SERVLET"))
    die ("You may not view this page directly.");

?>

<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <title>Chat page</title>

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/jq.js"></script>
    <script src="js/chatsystem.js"></script>
</head>

<body onload="setup()">

<a href="index.php">
    <button id="home">Home</button>
</a>
<a href="index.php?action=newpass">
    <button id="logout">Change password</button>
</a>
<a href="index.php?action=logout">
    <button id="logout">Log Out</button>
</a>


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


<div id="info">
    <input type="hidden" id="chatid" name="chatid" value="<?php echo $this->chat->getId()?>"/>

</div>


<div id="chatarea">

    <!-- chat stuff -->

</div>

<div id="nav">




    <!-- chat message box -->
    <!-- POST : GET
        PUT/DELETE/POST -> doesn't have to be immutable
        GET -> GET Should be immutable
    -->
    <div id="messagearea">
        <input type="text" name="message" id="message" />
        <button id="sendbutton" onclick="sendMessage()">Send</button>
    </div>

</div>

</body>

</html>
