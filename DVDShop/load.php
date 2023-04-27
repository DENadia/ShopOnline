<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php
    session_start();
    include("connect.php");
    include("page_top.html");
    session_unset() ;
    /* eliminăm toate variabilele asociate acestei sesiuni */
    session_destroy();
    ?>
    <center><h1>Your order has been successfuly placed!&hearts;</h1></center>
</body>
</html>

