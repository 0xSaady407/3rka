<?php
    require "../functions.php";
    require "../config.php";


    session_start();
    if(isset($_SESSION['id']) && $_SESSION['id'] != 1){
        header("Location: ../fighters/profile.php");
        exit();
    }

    $nameErr = $unameErr =$passErr = $phoneErr = $imgErr = $weaponErr = $areaErr = $emailErr = $crecordErr = "";



    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        //display name
        $name = $_POST['display_name'];
        $name = cleanInput($name);
        if(empty($name)) $nameErr = "الاسم مينفعش يبقى فاضي";
        else {
            
            if(!preg_match("/^[\p{Arabic} ]+$/u", $name)) $nameErr = "الاسم لازم يكون حروف عربي فقط";
        }

        //username
        $uname = $_POST['username'];
        $uname = cleanInput($uname);
        if(empty($uname)) $unameErr = "اسم المستخدم مينفعش يبقى فاضي";
        elseif(!preg_match("/^(?=.*[a-zA-Z])[a-zA-Z0-9]+$/", $uname)) $unameErr = "اسم المستخدم لازم يكون متكون من حروف انجليزي وأرقام فقط";
        else {
            $uname_av_query = "SELECT uname FROM men WHERE uname = ?";
            $uname_av = $mysqli->prepare($uname_av_query);
            $uname_av->bind_param("s", $uname);
            $uname_av->execute();
            $uname_av->bind_result($result_uname);
            if($uname_av->fetch()){
                $unameErr = "اسم المستخدم موجود بالفعل، جرب واحد تاني";
            }
            $uname_av->free_result();
            $uname_av->close();

        }
        

        //email
        $email = $_POST['email'];
        $email = cleanInput($email);
        if(empty($email)) $emailErr = "دخل بريد الكتروني صحيح";
        elseif(!preg_match("/^[a-zA-Z\.0-9-_~+]+[@][a-z]*\.[a-z]+$/", $email)) $emailErr = "الإيميل غير صحيح، دخل ايميل مظبوط";
        else {
            $email_av_query = "SELECT email FROM men WHERE email = ?";
            $email_av = $mysqli->prepare($email_av_query);
            if ($email_av === false) {
                die('Error preparing query: ' . $mysqli->error);
            }
            $email_av->bind_param("s", $email);          
            $email_av->execute();
            $email_av->bind_result($result_email);
            if($email_av->fetch()){
                $emailErr = "الإيميل موجود بالفعل، جرب واحد تاني";
            }
            $email_av->free_result();
            $email_av->close();

        }
        
        //password
        $pass = $_POST['user_pass'];
        $pass = cleanInput($pass);
        if(empty($pass)) $passErr = "كلمة السر متنفعش تبقى فاضية";
        else if(!preg_match("/^[a-zA-Z0-9]{8,20}$/", $pass)) $passErr = "طول كلمة السر لا يقل عن 8 ولا يزيد عن 16،كلمة السر لازم تكون متكونة من حروف انجليزي وأرقام فقط";
        else $pass = md5($pass);
        

        //phone
        $phone = $_POST['phone'];
        $phone = cleanInput($phone);
        if(empty($phone)) $phoneErr = "ادخل رقم مصري صحيح";
        else {
            
            if(!preg_match("/^[0][1][0-25][0-9]{8}$/", $phone)) $phoneErr = "الرقم غير صحيح! دخل رقم مصري صحيح";
        }

        //area
        $area = $_POST['area'];
        $area = cleanInput($area);
        if(empty($area)) $areaErr = "المنطقة مينفعش تبقى فاضية، دخل عنوان صحيح";

        //criminal record
        $crecord = $_POST['crecord'];
        $crecord = cleaninput($crecord);
        if(empty($crecord)) $crecordErr = "اكتب سجلك الإجرامي";
        //weapon
        $weapon = $_POST['weapon'];
        if(empty($weapon)) $weaponErr = "ايه بتخش بطولك؟ اختار سلاح";


        //image
        if(isset($_FILES['usr_img']) && $_FILES['usr_img']['error'] === UPLOAD_ERR_INI_SIZE) { $imgErr = "حجم الصورة لازم يكون 2 ميجا أو أقل"; }

        else if(isset($_FILES['usr_img']['tmp_name']) && !empty($_FILES['usr_img']['tmp_name'])){
            // File is uploaded
            $img_name = $_FILES['usr_img']['name'];
            $tmp = $_FILES['usr_img']['tmp_name'];
            $img_size = $_FILES['usr_img']['size'];
            $ext = strtolower(end(explode('.', $img_name)));
        
            if($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') $imgErr = "مسموح بس بـ PNG أو JPG";
            else {
                $imgPath = "Uploads/".$uname."_".time().'.'.$ext;
                move_uploaded_file($tmp,"../".$imgPath);
            }
        }
        else {
            $imgErr = "لازم ترفع صورتك";
        }

        if($nameErr == "" && $unameErr == "" && $passErr == "" && $phoneErr == "" && $imgErr == "" && $weaponErr == "" && $areaErr == "" && $emailErr == "" && $crecordErr == ""){
            $query = $mysqli->prepare("INSERT INTO men (`Phone`, `uname`, `name`, `password`, `email`, `crecord`, `pfp`, `address`, `fav_weapon`, `isConfirmed`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, false)");
            $query->bind_param("sssssssss", $phone, $uname, $name, $pass, $email, $crecord, $imgPath, $area, $weapon);
            
            if ($query->execute()) {
                $_SESSION['name'] = $name;
                header('Location: success.php');
                exit();
            }

            //mysqli_query($connection, $query)

            else {
                header("Location: ../error.php");
                exit();
            }
        }

        //echo $uname.$name.$pass.$area.$email.$fav_weapn;
        

    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>عركة - انضم لينا</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <script src="https://kit.fontawesome.com/2c1af483e4.js" crossorigin="anonymous"></script>
        <script>
            function get(input) {
                if (input.files[0]) {
                    const reader = new FileReader();
                    reader.onloadend = function (e) {
                        const imageUrl = e.target.result;
                        document.getElementById("preview").style.backgroundImage = `url(${imageUrl})`;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </head>
    <body id="join_body">
        <nav>
            <ul>
                <li><a id="nav_home" href="../index.php" style="background-image: url('../img/logo.png'); background-size: cover;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                <div id="left_nav">
                <li><a href="../login.php">تسجيل الدخول</a></li>
                </div>
            </ul>
        </nav>
        <form id="application" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
             <div class ="grid_container apply">
                <div class="join_logo">
                    <h1>انضم لينا</h1>
                </div>
                <div class="field dp">   
                    <label for="display_name">اسم الشهرة</label><br>
                    <input name="display_name" type="text"><br>
                    <span class="error"><?php echo $nameErr ?></span>
                </div>

                <div class="field un">
                    <label for="username">اسم المستخدم</label><br>
                    <input name="username" type="text"><br>
                    <span class="error"><?php echo $unameErr ?></span>
                </div>

                <div class="field em">
                    <label for="email">الايميل</label><br>
                    <input name="email" type="text"><br>
                    <span class="error"><?php echo $emailErr ?></span>
                </div>

                <div class="field pw">
                    <label for="user_pass">كلمة السر</label><br>
                    <input name="user_pass" type="password"><br>
                    <span class="error"><?php echo $passErr ?></span>
                </div>
                
                <div class="field pn">
                    <label for="phone"> رقم الموبايل</label><br>
                    <input type="text" name="phone"><br>
                    <span class="error"><?php echo $phoneErr ?></span>
                </div>

                <div class="field ar">
                    <label for="area">المنطقة</label><br>
                    <input name="area" type="text"><br>
                    <span class="error"><?php echo $areaErr ?></span>
                </div>

                <div class="field cr">
                    <label for="crecord">سجلك الإجرامي</label><br>
                    <textarea name="crecord"></textarea><br>
                    <span class="error"><?php echo $crecordErr ?></span>
                </div>

                <div class="upload_img_container">
                    <div class="upload img" id="preview">    
                        <input name="usr_img" type="file" onchange="get(this);">
                        <label for="usr_img">ارفع صورتك</label>
                    </div>
                    <span class="error"><?php echo $imgErr ?></span>
                </div>


                <div class="field wpn">
                    <label for="weapon">سلاحك الأساسي؟</label>
                    <div><label><input type="radio" name="weapon" value="المطوة" id="wpn1"> المطوة </label></div>
                    <div><label><input type="radio" name="weapon" value="السنجة" id="wpn2"> السنجة </label></div>
                    <div><label><input type="radio" name="weapon" value="الطبنجة" id="wpn3"> الطبنجة </label></div>
                    <div><label><input type="radio" name="weapon" value="الآلي" id="wpn4"> الآلي </label></div>
                    <span class="error"><?php echo $weaponErr ?></span>
                </div>
                <input type="submit" name="submit_app" value="سجل" id="submit_app"> 
            </div>
            
        </form>

        
    </body>
</html><?php
    require "../functions.php";
    require "../config.php";


    session_start();
    if(isset($_SESSION['id']) && $_SESSION['id'] != 1){
        header("Location: ../fighters/profile.php");
        exit();
    }

    $nameErr = $unameErr =$passErr = $phoneErr = $imgErr = $weaponErr = $areaErr = $emailErr = $crecordErr = "";



    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        //display name
        $name = $_POST['display_name'];
        $name = cleanInput($name);
        if(empty($name)) $nameErr = "الاسم مينفعش يبقى فاضي";
        else {
            
            if(!preg_match("/^[\p{Arabic} ]+$/u", $name)) $nameErr = "الاسم لازم يكون حروف عربي فقط";
        }

        //username
        $uname = $_POST['username'];
        $uname = cleanInput($uname);
        if(empty($uname)) $unameErr = "اسم المستخدم مينفعش يبقى فاضي";
        elseif(!preg_match("/^(?=.*[a-zA-Z])[a-zA-Z0-9]+$/", $uname)) $unameErr = "اسم المستخدم لازم يكون متكون من حروف انجليزي وأرقام فقط";
        else {
            $uname_av_query = "SELECT uname FROM men WHERE uname = ?";
            $uname_av = $mysqli->prepare($uname_av_query);
            $uname_av->bind_param("s", $uname);
            $uname_av->execute();
            $uname_av->bind_result($result_uname);
            if($uname_av->fetch()){
                $unameErr = "اسم المستخدم موجود بالفعل، جرب واحد تاني";
            }
            $uname_av->free_result();
            $uname_av->close();

        }
        

        //email
        $email = $_POST['email'];
        $email = cleanInput($email);
        if(empty($email)) $emailErr = "دخل بريد الكتروني صحيح";
        elseif(!preg_match("/^[a-zA-Z\.0-9-_~+]+[@][a-z]*\.[a-z]+$/", $email)) $emailErr = "الإيميل غير صحيح، دخل ايميل مظبوط";
        else {
            $email_av_query = "SELECT email FROM men WHERE email = ?";
            $email_av = $mysqli->prepare($email_av_query);
            if ($email_av === false) {
                die('Error preparing query: ' . $mysqli->error);
            }
            $email_av->bind_param("s", $email);          
            $email_av->execute();
            $email_av->bind_result($result_email);
            if($email_av->fetch()){
                $emailErr = "الإيميل موجود بالفعل، جرب واحد تاني";
            }
            $email_av->free_result();
            $email_av->close();

        }
        
        //password
        $pass = $_POST['user_pass'];
        $pass = cleanInput($pass);
        if(empty($pass)) $passErr = "كلمة السر متنفعش تبقى فاضية";
        else if(!preg_match("/^[a-zA-Z0-9]{8,20}$/", $pass)) $passErr = "طول كلمة السر لا يقل عن 8 ولا يزيد عن 16،كلمة السر لازم تكون متكونة من حروف انجليزي وأرقام فقط";
        else $pass = md5($pass);
        

        //phone
        $phone = $_POST['phone'];
        $phone = cleanInput($phone);
        if(empty($phone)) $phoneErr = "ادخل رقم مصري صحيح";
        else {
            
            if(!preg_match("/^[0][1][0-25][0-9]{8}$/", $phone)) $phoneErr = "الرقم غير صحيح! دخل رقم مصري صحيح";
        }

        //area
        $area = $_POST['area'];
        $area = cleanInput($area);
        if(empty($area)) $areaErr = "المنطقة مينفعش تبقى فاضية، دخل عنوان صحيح";

        //criminal record
        $crecord = $_POST['crecord'];
        $crecord = cleaninput($crecord);
        if(empty($crecord)) $crecordErr = "اكتب سجلك الإجرامي";
        //weapon
        $weapon = $_POST['weapon'];
        if(empty($weapon)) $weaponErr = "ايه بتخش بطولك؟ اختار سلاح";


        //image
        if(isset($_FILES['usr_img']) && $_FILES['usr_img']['error'] === UPLOAD_ERR_INI_SIZE) { $imgErr = "حجم الصورة لازم يكون 2 ميجا أو أقل"; }

        else if(isset($_FILES['usr_img']['tmp_name']) && !empty($_FILES['usr_img']['tmp_name'])){
            // File is uploaded
            $img_name = $_FILES['usr_img']['name'];
            $tmp = $_FILES['usr_img']['tmp_name'];
            $img_size = $_FILES['usr_img']['size'];
            $ext = strtolower(end(explode('.', $img_name)));
        
            if($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') $imgErr = "مسموح بس بـ PNG أو JPG";
            else {
                $imgPath = "Uploads/".$uname."_".time().'.'.$ext;
                move_uploaded_file($tmp,"../".$imgPath);
            }
        }
        else {
            $imgErr = "لازم ترفع صورتك";
        }

        if($nameErr == "" && $unameErr == "" && $passErr == "" && $phoneErr == "" && $imgErr == "" && $weaponErr == "" && $areaErr == "" && $emailErr == "" && $crecordErr == ""){
            $query = $mysqli->prepare("INSERT INTO men (`Phone`, `uname`, `name`, `password`, `email`, `crecord`, `pfp`, `address`, `fav_weapon`, `isConfirmed`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, false)");
            $query->bind_param("sssssssss", $phone, $uname, $name, $pass, $email, $crecord, $imgPath, $area, $weapon);
            
            if ($query->execute()) {
                $_SESSION['name'] = $name;
                header('Location: success.php');
                exit();
            }

            //mysqli_query($connection, $query)

            else {
                header("Location: ../error.php");
                exit();
            }
        }

        //echo $uname.$name.$pass.$area.$email.$fav_weapn;
        

    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>عركة - انضم لينا</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <script src="https://kit.fontawesome.com/2c1af483e4.js" crossorigin="anonymous"></script>
        <script>
            function get(input) {
                if (input.files[0]) {
                    const reader = new FileReader();
                    reader.onloadend = function (e) {
                        const imageUrl = e.target.result;
                        document.getElementById("preview").style.backgroundImage = `url(${imageUrl})`;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </head>
    <body id="join_body">
        <nav>
            <ul>
                <li><a id="nav_home" href="../index.php" style="background-image: url('../img/logo.png'); background-size: cover;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                <div id="left_nav">
                <li><a href="../login.php">تسجيل الدخول</a></li>
                </div>
            </ul>
        </nav>
        <form id="application" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
             <div class ="grid_container apply">
                <div class="join_logo">
                    <h1>انضم لينا</h1>
                </div>
                <div class="field dp">   
                    <label for="display_name">اسم الشهرة</label><br>
                    <input name="display_name" type="text"><br>
                    <span class="error"><?php echo $nameErr ?></span>
                </div>

                <div class="field un">
                    <label for="username">اسم المستخدم</label><br>
                    <input name="username" type="text"><br>
                    <span class="error"><?php echo $unameErr ?></span>
                </div>

                <div class="field em">
                    <label for="email">الايميل</label><br>
                    <input name="email" type="text"><br>
                    <span class="error"><?php echo $emailErr ?></span>
                </div>

                <div class="field pw">
                    <label for="user_pass">كلمة السر</label><br>
                    <input name="user_pass" type="password"><br>
                    <span class="error"><?php echo $passErr ?></span>
                </div>
                
                <div class="field pn">
                    <label for="phone"> رقم الموبايل</label><br>
                    <input type="text" name="phone"><br>
                    <span class="error"><?php echo $phoneErr ?></span>
                </div>

                <div class="field ar">
                    <label for="area">المنطقة</label><br>
                    <input name="area" type="text"><br>
                    <span class="error"><?php echo $areaErr ?></span>
                </div>

                <div class="field cr">
                    <label for="crecord">سجلك الإجرامي</label><br>
                    <textarea name="crecord"></textarea><br>
                    <span class="error"><?php echo $crecordErr ?></span>
                </div>

                <div class="upload_img_container">
                    <div class="upload img" id="preview">    
                        <input name="usr_img" type="file" onchange="get(this);">
                        <label for="usr_img">ارفع صورتك</label>
                    </div>
                    <span class="error"><?php echo $imgErr ?></span>
                </div>


                <div class="field wpn">
                    <label for="weapon">سلاحك الأساسي؟</label>
                    <div><label><input type="radio" name="weapon" value="المطوة" id="wpn1"> المطوة </label></div>
                    <div><label><input type="radio" name="weapon" value="السنجة" id="wpn2"> السنجة </label></div>
                    <div><label><input type="radio" name="weapon" value="الطبنجة" id="wpn3"> الطبنجة </label></div>
                    <div><label><input type="radio" name="weapon" value="الآلي" id="wpn4"> الآلي </label></div>
                    <span class="error"><?php echo $weaponErr ?></span>
                </div>
                <input type="submit" name="submit_app" value="سجل" id="submit_app"> 
            </div>
            
        </form>

        
    </body>
</html>