<?php
    require "../functions.php";
    require "../config.php";
    session_start();

    if(isset($_SESSION['id']) && $_SESSION['id'] != 1){
        $id = $_SESSION['id'];
        $sql = "SELECT * FROM men WHERE ManID = $id";
        
        if($result = $mysqli->query($sql)){
            $row=$result->fetch_assoc();
            
        }
        else {
            header("Location: ../error.php");
            exit();
        }
    }

    else {
        header("Location: ../login.php");
        exit();
    }

    $count = "SELECT COUNT(menfights.FightID) as result from menfights JOIN fights ON fights.FightID = menfights.FightID WHERE ManID = $id AND isConfirmed = 1";
    $countresult = $mysqli->query($count);
    $countresult = $countresult->fetch_assoc();
    $count = $countresult['result'];

?>

<!DOCTYPE html>
<head>
    <title><?php echo "صفحة ".$row['name']." الشخصية";?></title>
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
    <div class="profile-page">
        <div class="user-info">
            <div class="profile-picture">
                <img src="<?php echo "../".$row['pfp'];?>">
            </div>
            <h1><?php echo $row['name']?></h1>
            <h3><?php echo "@".$row['uname']?></h3>
            <h2>عدد الخناقات</h2>
            <h2><?php echo $count ?></h2>
            <div class="settings">
                <a id="stngs" href="../coming-soon.php"> <i class="fa-solid fa-gear"></i> الإعدادات</a>
            </div>
        </div>
        <div class="list-fights">
        <?php
        $getfights = "SELECT * FROM fights JOIN menfights ON fights.FightID = menfights.FightID WHERE ManID = $id AND isConfirmed = 1 ORDER BY FightTime";
        $fights = $mysqli->query($getfights);
        while($fight = $fights->fetch_assoc()){
        ?>
        <div class="grid_container fight-card">
            <div class="fight-id">
                <h1><?php echo toAr($fight['FightID']); ?></h1>
            </div>
            <div class="fight-client-name">
                <h2>اسم العميل</h2>
                <h3><?php echo $fight['ClientName']?></h3>
            </div>

            <div class="fight-client-email">
                <h2>الإيميل</h2>
                <h3><?php echo $fight['email'];?></h3>
            </div>
            
            <div class="fight-client-phone">
                <h2>رقم الموبايل</h2>
                <h3><?php echo $fight['phone'];?></h3>
            </div>

            <div class="fight-address">
                <h2>عنوان الخناقة</h2>
                <p><?php echo $fight['FightAddress'];?></p>
            </div>

            <div class="fight-details">
                <h2>التفاصيل</h2>
                <p><?php echo $fight['details'];?></p>
            </div>

            <div class="fight-date-time">
                <h2>معاد الخناقة</h2>
                <h3><?php echo $fight['FightTime']; ?></h3>
            </div>
            <?php
            $FightID = $fight['FightID']; 
            $getmen = "SELECT men.ManID, name FROM men JOIN menfights ON men.ManID = menfights.ManID WHERE FightID = $FightID AND menfights.ManID != $id";
            $men = $mysqli->query($getmen);
            if(mysqli_num_rows($men)){?>
            <div class="participants">
                    <h2>البلطجية المشاركون</h2>
            </div>
            <?php } ?>
            <div class="fight-list-fighters">
            <?php
            while($man = $men->fetch_assoc()){
            ?>
                <div class="fight-fighter">
                    <h1><?php echo toAr($man['ManID']); ?></h1>
                    <h1><?php echo $man['name']?></h1>
                </div>
            <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</body>
</html>
