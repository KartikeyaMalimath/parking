<!DOCTYPE html>

<?php

include ('../include/db.php');
include ('../include/data.php');

?>

<html>
<head>
    <title><?php echo $loginTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/custom.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="../bootstrap-4.3.1-dist/js/tether.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

    
</head>
<!--Body of the Index page-->
<body>
    <!--============================-->
    <!---->
    <!-- column for Image-->
    <div class="sidebar">
        <a class="active" href="#home"><i class="fa fa-fw fa-user"></i>Home</a>
        <a href="#news">News</a>
        <a href="#contact">Contact</a>
        <a href="#about">About</a>
    </div>    
    <!--column for login box-->
    <div class="content">
    <h2>Responsive Sidebar Example</h2>
    <p>This example use media queries to transform the sidebar to a top navigation bar when the screen size is 700px or less.</p>
    <p>We have also added a media query for screens that are 400px or less, which will vertically stack and center the navigation links.</p>
    <h3>Resize the browser window to see the effect.</h3>
    </div>
    <!--=============================-->
</body>
</html>