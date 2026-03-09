<?php include 'header.php'; ?>

<div style="text-align: center; margin-top: 50px; padding: 40px;">
    <h2>Platforma Hoşgeldiniz!</h2>
    <p style="font-size: 18px;">Sayın <b style="color: #2a9df4;"><?php echo isset($_SESSION["ad"]) ? $_SESSION["ad"] : ""; ?></b>, başarılı bir şekilde giriş yaptınız.</p>
    <p>Birkaç saniye içinde ana sayfaya yönlendiriliyorsunuz...</p>
    
    <meta http-equiv="refresh" content="8;url=index.php">
    
    <div style="margin-top: 30px;">
        <a href="index.php" style="padding: 10px 20px; background-color: #1a1a1a; color: white; text-decoration: none; border-radius: 5px;">Beklemek İstemiyorum</a>
    </div>
</div>

<?php include 'footer.php'; ?>