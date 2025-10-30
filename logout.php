<?php
include("conn.php");
session_start();
if (isset($_POST['logoutButton'])) {
  session_destroy();
    header("location:signup.php");
    exit();
  } else {
    session_destroy(); 
  }
?>