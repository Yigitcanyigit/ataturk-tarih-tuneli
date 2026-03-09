<?php
session_start();
session_destroy(); // Tüm oturum bilgilerini (isim vb.) siler
header("Location: index.php"); // Sildikten sonra ana sayfaya atar
exit();
?>