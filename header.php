<?php
session_start();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mustafa Kemal Atatürk</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="logo-alani">
        <h1 style="font-size: 20px;">Mustafa Kemal Atatürk Bilgi Paylaşım Platformu</h1>
        
        <?php
        if (isset($_SESSION["ad"])) {
            echo "<p style='margin: 5px 0 0 0; font-size: 14px; color: #f39c12;'>Hoş Geldin, " . $_SESSION["ad"] . "</p>";
        }
        ?>
    </div>
    <nav>
        <ul style="flex-wrap: wrap; justify-content: flex-end;">
            <li><a href="index.php">Ana Sayfa</a></li>
            <li><a href="kategori.php?kategori=Atatürk'ün Ailesi ve Gençlik Yılları">Ailesi ve Gençliği</a></li>
            <li><a href="kategori.php?kategori=Askeri Liderlik ve Savaş Dönemleri">Savaşlar</a></li>
            <li><a href="kategori.php?kategori=İnkılaplar, Modernleşme ve Sosyal Hayat">İnkılaplar</a></li>
            <li><a href="kategori.php?kategori=Halkla İç İçe (Halkla İlişkiler ve Yurt Gezileri)">Halkla İç İçe</a></li>
            <li><a href="kategori.php?kategori=Dış Politika ve Diplomasi">Diplomasi</a></li>
            
            <?php if (!isset($_SESSION["ad"])): ?>
                <li><a href="login.php" style="color:#2a9df4;">Giriş Yap</a></li>
                <li><a href="kayit.php" style="color:#2a9df4;">Kayıt Ol</a></li>
            <?php else: ?>
                <li><a href="cikis.php" style="color: #ff4757;">Çıkış Yap</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<div class="container">