<?php
    require "../functions.php";
    require "../config.php";
    session_start();
    if($_SESSION['id'] != 1){
        header("Location: index.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $id = $_POST['id'];
        echo $id;

        if(isset($_POST['add'])) $sql="UPDATE fights SET isConfirmed = 1 WHERE FightID = $id";
        elseif (isset($_POST['delete'])) $sql = "DELETE FROM menfights WHERE FightID = $id";

        if($mysqli->query($sql)){
            if(isset($_POST['delete'])){
                $sqll = "DELETE FROM fights WHERE FightID = $id";
                if($mysqli->query($sqll)) {
                    header("Location: fights.php");
                    exit();
                }
            }

            else {
            header("Location: fights.php");
            exit();
            }
        }

        else echo "Error1".$myslqi->error;
    }
    
?>