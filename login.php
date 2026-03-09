<?php 
include 'header.php'; 

$hata = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $girilen_kullanici = $_POST["kullanici_adi"];
    $girilen_sifre = $_POST["sifre"];

    $dosya = "veri/kullanicilar.json";
    if (file_exists($dosya)) {
        $kullanicilar = json_decode(file_get_contents($dosya), true);
        
        $bulundu = false;
        foreach ($kullanicilar as $user) {
            // "kullanici_adi" anahtarına göre kontrol ediyoruz
            if ($user["kullanici_adi"] == $girilen_kullanici && $user["sifre"] == $girilen_sifre) {
                $_SESSION["ad"] = $user["ad"]; 
                $bulundu = true;
                header("Location: index.php");
                exit();
            }
        }
        
        if (!$bulundu) {
            $hata = "Kullanıcı adı veya şifre hatalı!";
        }
    }
}
?>

<div class="auth-container">
    <h2>Sisteme Giriş Yap</h2>
    
    <?php if($hata): ?>
        <p style="color: #e74c3c; background: #fadbd8; padding: 10px; border-radius: 5px;"><?php echo $hata; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adınız" required>
        <input type="password" name="sifre" placeholder="Şifreniz" required>
        <button type="submit" style="width:100%; padding:12px; background:#1e3c72; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:bold;">Giriş Yap</button>
    </form>
</div>

<?php include 'footer.php'; ?>