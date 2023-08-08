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
    <title>Fighters</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <script src="https://kit.fontawesome.com/2c1af483e4.js" crossorigin="anonymous"></script>
</head>
<body style="background-image: url('../img/apply_bg.png'); background-size: cover; background-repeat: no-repeat; background-attachment:fixed;">
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
    <div class="list-fighters">
        <?php
            $sql = "SELECT * FROM men WHERE isConfirmed = 0 ORDER BY ManID";
            $result = $mysqli->query($sql);
            while($row = $result->fetch_assoc()){
        ?>
        <form method="post" action="accept.php" class="form-admin-fighters">
            <div class="grid_container admin-fighters">
                <div class="fighter-id">
                    <h1><?php echo toAr($row['ManID']);?></h1>
                </div>
                <div class="fighter-picture"><img src="<?php echo "../".$row['pfp'];?>"></div>
                <div class="fighter-username">
                    <h2><?php echo $row['uname'];?></h2>
                </div>
                <div class="fighter-name">
                    <h2>الإسم</h2>
                    <h3><?php echo $row['name'];?></h3>
                </div>
                <div class="fighter-phone">
                    <h2>رقم الموبايل</h2>
                    <h3><?php echo $row['Phone'];?><h3>
                </div>
                <div class="fighter-email">
                    <h2>الإيميل</h2>
                    <h3><?php echo $row['email'];?></h3>
                </div>
                <div class="fighter-address">
                    <h2>العنوان</h2>
                    <p><?php echo $row['address'];?></p>
                </div>
                <div class="fighter-crecord">
                    <h2>السجل الإجرامي</h2>
                    <p><?php echo $row['crecord'];?></p>
                </div>
                 <div class="fighter-weapon">
                    <h2>السلاح</h2>
                    <h3><?php echo $row['fav_weapon'];?></h3>
                </div>
                <div class="fighter-price field">
                    <input type="text" name="price" placeholder="السعر">
                    <input type="text" name="id" value="<?php echo $row['ManID']?>" style="display: none;">
                </div>
                <div class="buttons">
                    <button type="submit" name="add"><i class="fa-solid fa-square-check"></i></button>
                    <button type="submit" name="delete"><i class="fa-solid fa-square-xmark"></i></button>
                </div>
            </div>
        </form>
        <?php } ?>
    </div>
    
</body>
</html>