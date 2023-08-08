<?php
    require "functions.php";
    require "config.php";
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>

        <title> عركة - الصفحة الرئيسية</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <script src="https://kit.fontawesome.com/2c1af483e4.js" crossorigin="anonymous"></script>

    </head>

    <body style="background-image: url('img/new_bg.webp'); background-size: cover; background-position: center;">
        <nav>
            <ul>
                <li><a id="nav_home" href="index.php" style="background-image: url('img/logo.png'); background-size: cover;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
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
                <li><a href="fighters/profile.php"><?php echo '<i class="fa-solid fa-user"></i>&nbsp;'." ".$getpfp['name'];?></a></li>
                <?php } ?>

                <li><a href="logout.php">تسجيل الخروج</a></li>
                <?php
                }
                    else {
                ?>
                <li><a href="login.php">تسجيل الدخول</a></li>
                <?php } ?>
                </div>
            </ul>
        </nav>
        <div class="home-page">
            <h1>معاك عركة؟ مزنوق في رجالة؟<br>طلبك عندنا...</h1>
            <div class="home-paragraph">
                <p>موقع عركة بيقدملك تشكيلة من اشد البلطجية متنقيين عالفرازة
                    تقدر تنقي الرجالة اللي ع مزاجك حسب مهاراتهم واسلحتهم وتخش 
                    وانت مش شايل هم، حدد معاد ومكان الخناقة وظبط تشكيلتك وخلي الباقي علينا.
                </p>
            </div>
            <a href="order.php" id="submit_app">احجز خناقة</a>
            <div id="join_us"><p>بلطجي؟ <a href="join/">انضم لينا</a></p></div>
            <a href="about.php">عن الموقع</a>
        </div>
    
    </body>
</html>