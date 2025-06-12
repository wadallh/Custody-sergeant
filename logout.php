<?php
session_start();
session_unset(); 
session_destroy(); 
header("Location: login.html"); // يمكنك تغيير الرابط إلى صفحة تسجيل الدخول
exit();
?>