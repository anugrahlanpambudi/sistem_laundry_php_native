<?php 
//isset :ada/tidak kosong
//!isset : kosong

function checkLogin(){
    if(!isset($_SESSION['ID'])){
        header("location:index.php?access=failed");
    }

}

?>