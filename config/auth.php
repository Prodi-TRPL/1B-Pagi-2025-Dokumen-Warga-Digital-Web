<?php

session_start();

//validasi siapa yang login warga / petugas / admin jika tidak ada sesiion maka di buang
if(!isset($_SESSION["id_warga"] ) & !isset($_SESSION['id_petugas']) &  !isset($_SESSION['id_admin'])){

  header("Location:../login.php");
  exit();
}



?>  
