<?php 
    require "functions.php";
    require "config.php";
    session_start();

    $error = array();
    $rows = array();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $cname = $_POST['cname'];
        $cname = cleanInput($cname);
        if(empty($cname)) $error['cname'] = "دخل اسمك";
        else {
            
            if(!preg_match("/^[\p{Arabic} ]+$/u", $cname)) $error['cname'] = "الاسم لازم يكون حروف عربي فقط";
        }

        $phone = $_POST['phone'];
        $phone = cleanInput($phone);
        if(empty($phone)) $error['phone'] = "دخل رقم تليفونك";
        else {
            
            if(!preg_match("/^[0][1][0-25][0-9]{8}$/", $phone)) $error['phone'] = "الرقم غير صحيح! دخل رقم مصري صحيح";
        }


        $email = $_POST['email'];
        $email = cleanInput($email);
        if(empty($email)) $error['email'] = "دخل بريد الكتروني صحيح";
        else {
            if(!preg_match("/^[a-zA-Z\.0-9-_~+]+[@][a-z]*\.[a-z]+$/", $email)) $error['email'] = "الإيميل غير صحيح، دخل ايميل مظبوط";
        }

        $area = $_POST['area'];
        $area = cleanInput($area);
        if(empty($area)) $error['area'] = "العنوان مينفعش يبقى فاضي، دخل عنوان صحيح";

        $date = $_POST['date'];
        if(empty($date)) $error['date'] = "دخل تاريخ الخناقة";

        $time = $_POST['time'];
        if(empty($time)) $error['time'] = "دخل توقيت الخناقة";

        if(!empty($date) && !empty($time)) {
            if (!validateDateTime($date, $time)){
                $error['date'] = "معاد الخناقة مينفعش يكون قبل 24 ساعة من دلوقتي";
            }
        }

        $details = $_POST['details'];
        $details = cleanInput($details);
        if(empty($details)) $error['details'] = "دخل تفاصيل الخناقة، لو مفيش اكتب لا يوجد";

        if(isset($_POST['selectedIDs'])){
            $selectedIDs = [];
            $selectedIDs = $_POST['selectedIDs'];
        }
        else $error['fighters'] = "لازم تختار على الأقل بلطجي واحد";


        if(empty($error)){
            $datetime = $date." ".$time;
            $sql = $mysqli->prepare("INSERT INTO fights(ClientName, FightAddress, FightTime, phone, details, email) VALUES(?, ?, ?, ?, ?, ?)");
            $sql->bind_param("ssssss", $cname, $area, $datetime, $phone, $details, $email);
            if($sql->execute()){
                $fightID = $sql->insert_id;

                foreach($selectedIDs as $MID){
                    $stmt = "INSERT INTO menfights(ManID, FightID) VALUES ($MID, $fightID)";
                    if($mysqli->query($stmt)){
                        $flag = true;
                    }
                    else {
                        break;
                    }
                }

                if($flag) {
                    $_SESSION['cname'] = $cname;
                        header("Location: thanks.php");
                        exit();
                }
            }

        }
        
    }
    $sql = "SELECT * FROM men WHERE isConfirmed = 1";
    $result = $mysqli->query($sql);
?>
<html>
    <head>
        <title>عركة - جهز خناقة</title>
        <link rel="stylesheet" href="css/style.css">
        <script src="https://kit.fontawesome.com/2c1af483e4.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>

    <body style="background-image: url('img/apply_bg.png'); background-size: cover; background-repeat: no-repeat; background-attachment:fixed;">
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

        <form method="post" id="order" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            

            <div class="grid_container fight">
                
                <div class="fight_logo"><h1>جهز خناقة</h1></div>

                <div class="field dp">
                    <label for="cname">اسمك</label><br>
                    <input type="text" name="cname"><br>
                    <span class="error"><?php echo $error['cname'] ?></span>            
                </div>

                <div class="field pn">
                    <label for="phone">رقم التليفون</label><br>
                    <input type="text" name="phone"><br>
                    <span class="error"><?php echo $error['phone'] ?></span>            
                </div>
                
                <div class="field em">
                    <label for="email">الإيميل</label><br>
                    <input type="text" name="email"><br>
                    <span class="error"><?php echo $error['email'] ?></span>            
                </div>

                <div class="field ar">
                    <label for="area">مكان الخناقة</label><br>
                    <input type="text" name="area"><br>
                    <span class="error"><?php echo $error['area'] ?></span>            
                </div>

                <div class="field dt">
                    <label for="date">اليوم</label><br>
                    <input type="date" name="date"><br>
                    <span class="error"><?php echo $error['date'] ?></span>            
                </div>

                <div class="field tm">
                    <label for="time">الوقت</label><br>
                    <input type="time" name="time"><br>
                    <span class="error"><?php echo $error['time'] ?></span>            
                </div>

                <div class="field dtls">
                    <label for="details">التفاصيل</label><br>
                    <textarea name="details"></textarea><br>
                    <span class="error"><?php echo $error['details'] ?></span>            
                </div>
            
                <input type="submit" value="تأكيد" id="submit_app">
                
                <br><div class="divide"></div><br>

                <div class="choose"><h1 style="color:white;">اختار رجالتك</h1>
                    <span class="error"><?php echo $error['fighters'] ?></span>
                </div>                
                
                
                <div class="fighters">
                <?php
                $sql = "SELECT * FROM men WHERE isConfirmed = 1";
                $result = $mysqli->query($sql);
                    while($row = $result->fetch_assoc()) {     
                ?>
                    <div class="card">
                        <div class="card_img">
                        <div class="imgsrc"><img src="<?php echo $row['pfp']?>" alt=""></div>
                            <div class="card_name"><h1><?php echo $row['name']?></h1></div>
                        </div>
                        
                        <div class="desc"><p><?php echo $row['crecord'] ?></p></div>
                        <div class="card_wpn">
                            <h2>السلاح</h2>
                            <p><?php echo $row['fav_weapon'] ?></p>
                        </div>
                        
                        <div class="price">
                            <h1>جـــــ<br><?php echo toAr($row['price']);?></h1>
                        </div>

                        <div class="tick">
                            <input type="checkbox" name="selectedIDs[]" class="select" value="<?php echo $row['ManID'] ?>">
                            <i class="fa fa-check-circle"></i>
                        </div>

                        <div class="checkmark">
                        </div>
                    </div>
                <?php } ?>

                </div>
            </div>
        </form>

    </body>
</html>