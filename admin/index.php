<?php
    require "../functions.php";
    require "../config.php";
    session_start();

    if($_SESSION['id'] == 1){
        header("Location: dashboard.php");
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

        if($error == ["username" => "" ,"password" => ""]){
            $adminPass = md5("password");
            $adminUser = "admin";
            if($adminPass == $password && $adminUser == $username ){
                

                $_SESSION['id'] = 1;
                $_SESSION['name'] = "سعدي";
                header("Location: dashboard.php");
                
                exit();
            }

            else {
                $error['password'] = "اسم المستخدم أو كلمة المرور غير صحيحة";
            }
        }


    }    

?>


<html>
    <head>
        <title>عركة - بوابة الأدمن</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <script src="https://kit.fontawesome.com/2c1af483e4.js" crossorigin="anonymous"></script>
    </head>

    <body style="background-image: url('../img/apply_bg.png'); background-size: cover;">

        <div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <div class="grid_container admin_login">
                    <div class="login_logo"><h1>الأدمن</h1></div>
                    
                    <div class="field un">
                        <label for="username">اسم المستخدم</label><br>
                        <input type="text" name="username"><br>
                        <span class="error"><?php echo $error['username'] ?></span>            
                    </div>
                    
                    
                    <div class="field pw">
                        <label for="password">كلمة السر</label><br>
                        <input type="password" name="password"><br>
                        <span class="error"><?php echo $error['password'] ?></span>            
                    </div>
                    
                    <input type="submit" value="تسجيل الدخول" id="submit_app">
                    
                
            </form>   
    </body>
</html><?php
    require "../functions.php";
    require "../config.php";
    session_start();

    if($_SESSION['id'] == 1){
        header("Location: dashboard.php");
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

        if($error == ["username" => "" ,"password" => ""]){
            $adminPass = md5("p@ssw0rd123!");
            $adminUser = "admin";
            if($adminPass == $password && $adminUser == $username ){
                

                $_SESSION['id'] = 1;
                $_SESSION['name'] = "سعدي";
                header("Location: dashboard.php");
                
                exit();
            }

            else {
                $error['password'] = "اسم المستخدم أو كلمة المرور غير صحيحة";
            }
        }


    }    

?>


<html>
    <head>
        <title>عركة - بوابة الأدمن</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <script src="https://kit.fontawesome.com/2c1af483e4.js" crossorigin="anonymous"></script>
    </head>

    <body style="background-image: url('../img/apply_bg.png'); background-size: cover;">

        <div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <div class="grid_container admin_login">
                    <div class="login_logo"><h1>الأدمن</h1></div>
                    
                    <div class="field un">
                        <label for="username">اسم المستخدم</label><br>
                        <input type="text" name="username"><br>
                        <span class="error"><?php echo $error['username'] ?></span>            
                    </div>
                    
                    
                    <div class="field pw">
                        <label for="password">كلمة السر</label><br>
                        <input type="password" name="password"><br>
                        <span class="error"><?php echo $error['password'] ?></span>            
                    </div>
                    
                    <input type="submit" value="تسجيل الدخول" id="submit_app">
                    
                
            </form>   
    </body>
</html>