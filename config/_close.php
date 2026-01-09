<?php 
//mulai
session_start();
//melepaskan
session_unset();
//menghapus
session_destroy();
//back to index
header("Location:../index.php");
exit();
?>
