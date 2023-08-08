<?php
    require "../functions.php";
    require "../config.php";
    session_start();
    if($_SESSION['id'] != 1){
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <script src="https://kit.fontawesome.com/2c1af483e4.js" crossorigin="anonymous"></script>
    <title>Dashboard</title>
</head>
        <nav>
            <ul>
                <li><a id="nav_home" href="../index.php" style="background-image: url('../img/logo.png'); background-size: cover;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                <div id="left_nav">
                <?php
                    if(isset($_SESSION['id'])){
                        $id = $_SESSION['id'];
                        if($_SESSION['id'] != 1){
                            $getpfp = "SELECT * FROM men WHERE ManID = $id";
                            $getpfp = $mysqli->query($getpfp);
                            $getpfp = $getpfp->fetch_assoc();
                            $pfp = $getpfp['pfp'];
                ?>
                <li><a href="../fighters/profile.php"><?php echo '<i class="fa-solid fa-user"></i>&nbsp;'." ".$getpfp['name'];?></a></li>
                <?php } ?>

                <li><a href="../logout.php">تسجيل الخروج</a></li>
                <?php
                }
                    else {
                ?>
                <li><a href="../login.php">تسجيل الدخول</a></li>
                <?php } ?>
                </div>
            </ul>
        </nav> 
<body style="background-image: url('../img/apply_bg.png'); background-size: cover;">
    <div class="menu">
        <a href="fighters.php">البلطجية</a>
        <a href="fights.php">الخناقات</a>
    </div>
</body>
</html><?php
    require "../functions.php";
    require "../config.php";
    session_start();
    if($_SESSION['id'] != 1){
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <script src="https://kit.fontawesome.com/2c1af483e4.js" crossorigin="anonymous"></script>
    <title>Dashboard</title>
</head>
        <nav>
            <ul>
                <li><a id="nav_home" href="../index.php" style="background-image: url('../img/logo.png'); background-size: cover;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                <div id="left_nav">
                <?php
                    if(isset($_SESSION['id'])){
                        $id = $_SESSION['id'];
                        if($_SESSION['id'] != 1){
                            $getpfp = "SELECT * FROM men WHERE ManID = $id";
                            $getpfp = $mysqli->query($getpfp);
                            $getpfp = $getpfp->fetch_assoc();
                            $pfp = $getpfp['pfp'];
                ?>
                <li><a href="../fighters/profile.php"><?php echo '<i class="fa-solid fa-user"></i>&nbsp;'." ".$getpfp['name'];?></a></li>
                <?php } ?>

                <li><a href="../logout.php">تسجيل الخروج</a></li>
                <?php
                }
                    else {
                ?>
                <li><a href="../login.php">تسجيل الدخول</a></li>
                <?php } ?>
                </div>
            </ul>
        </nav> 
<body style="background-image: url('../img/apply_bg.png'); background-size: cover;">
    <div class="menu">
        <a href="fighters.php">البلطجية</a>
        <a href="fights.php">الخناقات</a>
    </div>
</body>
</html>