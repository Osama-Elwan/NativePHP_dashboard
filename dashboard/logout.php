<?php


session_start();
session_unset();
session_regenerate_id();
session_destroy();
setcookie("user_email",$email,time() - 3600 );
header("location: login.php");