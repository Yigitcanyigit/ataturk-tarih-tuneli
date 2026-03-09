<?php 
include 'header.php'; 

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_soyad = $_POST["ad_soyad"];
    $kullanici_adi = $_POST["kullanici_adi"]; // E-posta yerine kullanıcı adı
    $sifre = $_POST["sifre"];

    $dosya_yolu = "veri/kullanicilar.json";
    
    // Mevcut kullanıcıları oku
    $kullanicilar = array();
    if (file_exists($dosya_yolu)) {
        $kullanicilar = json_decode(file_get_contents($dosya_yolu), true);
    }

    // Yeni kullanıcıyı ekle
    $yeni_kullanici = array(
        "ad" => $ad_soyad,
        "kullanici_adi" => $kullanici_adi,
        "sifre" => $sifre
    );

    $kullanicilar[] = $yeni_kullanici;

    // Dosyaya geri kaydet
    if (file_put_contents($dosya_yolu, json_encode($kullanicilar, JSON_PRETTY_PRINT))) {
        $mesaj = "Kayıt başarıyla tamamlandı! <a href='login.php'>Giriş yapabilirsiniz.</a>";
    }
}
?>

<div class="auth-container">
    <h2>Yeni Hesap Oluştur</h2>
    
    <?php if($mesaj): ?>
        <p style="color: #27ae60; background: #d4efdf; padding: 10px; border-radius: 5px;"><?php echo $mesaj; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="ad_soyad" placeholder="Adınız Soyadınız" required>
        
        <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı Belirleyin" required>
        
        <input type="password" name="sifre" placeholder="Şifreniz" required>
        
        <button type="submit" style="width:100%; padding:12px; background:#1e3c72; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:bold;">Kayıt Ol</button>
    </form>
    
    <p style="margin-top:20px; font-size:14px;">Zaten hesabınız var mı? <a href="login.php" style="color:#2a5298; font-weight:bold;">Giriş Yap</a></p>
</div>

<?php include 'footer.php'; ?>