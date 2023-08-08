<?php
    require "../functions.php";
    require "../config.php";
    session_start();
    if($_SESSION['id'] != 1){
        header("Location: index.php");
        exit();
    }

    $sql = "SELECT * FROM fights WHERE isConfirmed = 0 ORDER BY FightTime";
    $result = $mysqli->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Fights</title>
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
        <div class="list-fights">
        <?php 
            $sql = "SELECT * FROM fights WHERE isConfirmed = 0 ORDER BY FightTime";
            $result = $mysqli->query($sql);
            while($row = $result->fetch_assoc()){
        ?>
        <form action="accept-fights.php" id="form-list-fights" method="post">
            <div class="grid_container fight-card">
                <div class="fight-id">
                    <h1><?php echo toAr($row['FightID']); ?></h1>
                </div>
                <div class="fight-client-name">
                    <h2>اسم العميل</h2>
                    <h3><?php echo $row['ClientName']?></h3>
                </div>

                <div class="fight-client-email">
                    <h2>الإيميل</h2>
                    <h3><?php echo $row['email'];?></h3>
                </div>
                
                <div class="fight-client-phone">
                    <h2>رقم الموبايل</h2>
                    <h3><?php echo $row['phone'];?></h3>
                </div>

                <div class="fight-address">
                    <h2>عنوان الخناقة</h2>
                    <p><?php echo $row['FightAddress'];?></p>
                </div>

                <div class="fight-details">
                    <h2>التفاصيل</h2>
                    <p><?php echo $row['details'];?></p>
                </div>

                <div class="fight-date-time">
                    <h2>معاد الخناقة</h2>
                    <h3><?php echo $row['FightTime']; ?></h3>
                </div>
                <div class="fight-list-fighters">
                <?php
                $FightID = $row['FightID']; 
                $getmen = "SELECT men.ManID, name FROM men JOIN menfights ON men.ManID = menfights.ManID WHERE FightID = $FightID";
                $men = $mysqli->query($getmen);
                while($man = $men->fetch_assoc()){
                ?>
                    <div class="fight-fighter">
                        <h1><?php echo toAr($man['ManID']); ?></h1>
                        <h1><?php echo $man['name']?></h1>
                    </div>
                <?php } ?>
                </div>
                <div class="buttons">
                    <button type="submit" name="add"><i class="fa-solid fa-square-check"></i></button>
                    <input type="text" style="display: none;" name="id" value="<?php echo $row['FightID'];?>">
                    <button type="submit" name="delete"><i class="fa-solid fa-square-xmark"></i></button>
                </div>
            </div>
        </form>
        <?php } ?>
       </div> 
</body>
</html>