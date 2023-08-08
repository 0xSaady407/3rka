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
        $price = $_POST['price'];
        if(isset($_POST['add'])) $sql="UPDATE men SET isConfirmed = 1, price = $price WHERE ManID = $id";
        elseif (isset($_POST['delete'])) $sql = "DELETE FROM men WHERE ManID = $id";

        if($mysqli->query($sql)){
            header("Location: fighters.php");
            exit();
        }

        else {
            header("Location: ../error.php");
            exit();
        }
    }
    
?>