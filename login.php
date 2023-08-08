<?php
    session_start();
    require "functions.php";
    require "config.php";

    if(isset($_SESSION['id']) && $_SESSION['id'] != 1){
        header("Location: fighters/profile.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === "POST"){

        $error = array(
            "username" => "",
            "password" => ""
        );

        $username = $_POST['username'];
        $username = cleanInput($username);
        if(empty($username)) $error['username'] = "دخل ايميل او اسم مستخدم صحيح";


        $password = $_POST['password'];
        $password = cleanInput($password);
        if(empty($password)) $error['password'] = "دخل كلمة مرور صحيحة";
        else $password = md5($password);

        if ($error == ["username" => "", "password" => ""]) {
            $query = $mysqli->prepare("SELECT * FROM men WHERE password = ? AND (uname = ? OR email = ?) AND isConfirmed = 1");
            $query->bind_param("sss", $password, $username, $username);
            
            if ($query->execute()) {
                $result = $query->get_result();
                $num_rows = $result->num_rows;

                if ($num_rows === 0) {
                    $error['password'] = "مستخدم غير موجود أو لم يتم قبوله بعد";
                } else {
                    $row = $result->fetch_assoc();
                    $_SESSION['id'] = $row['ManID'];
                    $_SESSION['name'] = $row['name'];
                    header("Location: fighters/profile.php");
                    exit();
                }
            }

            else {
                header("Location: error.php");
                exit();
            }
        }



    }
    
?>

<html>
    <head>
        <title>عركة - تسجيل الدخول</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>

    <body style="background-image: url('img/login_full.webp'); background-size:cover; background-positition: left;" id="login">
        <nav>
            <ul>
                <li><a id="nav_home" href="index.php" style="background-image: url('img/logo.png'); background-size: cover; background-positition: bottom;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                <div id="left_nav">
                <li><a href="login.php">تسجيل الدخول</a></li>
                </div>
            </ul>
        </nav>


        <div class="login-right">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <div class="grid_container login">
                    <div class="login_logo"><h1>تسجيل الدخول</h1></div>
                    
                    <div class="field un">
                        <label for="username">اسم المستخدم أو الإيميل</label><br>
                        <input type="text" name="username"><br>
                        <span class="error"><?php echo $error['username'] ?></span>            
                    </div>
                    
                    
                    <div class="field pw">
                        <label for="password">كلمة السر</label><br>
                        <input type="password" name="password"><br>
                        <span class="error"><?php echo $error['password'] ?></span>            
                    </div>

                    <div class="register">
                    <div id="join_us"><p style="color: #212121;">لسة مسجلتش؟ <a href="join/">انضم لينا</a></p></div>
                    </div>
                    
                    <input type="submit" value="تسجيل الدخول" id="submit_app">
                    
                
            </form>   
    </body>
</html>