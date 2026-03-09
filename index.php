<?php 
include 'header.php'; 

$dosya_yolu = "veri/gonderiler.json";

// === YENİ GÖNDERİ EKLEME VE DOSYA YÜKLEME İŞLEMİ ===
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["ad"])) {
    
    $resim_yolu = ""; // Varsayılan boş resim yolu
    
    // 1. ADIM: Dosya Yükleme Kontrolü
    if (isset($_FILES["resim_dosyasi"]) && $_FILES["resim_dosyasi"]["error"] == 0) {
        $dosya_adi = $_FILES["resim_dosyasi"]["name"];
        $gecici_yol = $_FILES["resim_dosyasi"]["tmp_name"];
        
        // Dosya isminin çakışmaması için başına zaman damgası ekliyoruz
        $yeni_dosya_adi = time() . "_" . basename($dosya_adi);
        $hedef_yol = "img/" . $yeni_dosya_adi;
        
        // Dosyayı sunucudaki (projedeki) img klasörüne taşı
        if (move_uploaded_file($gecici_yol, $hedef_yol)) {
            $resim_yolu = $hedef_yol;
        }
    }

    // 2. ADIM: Veriyi Hazırla
    $yeni_gonderi = array(
        "yazar" => $_SESSION["ad"],
        "kategori" => $_POST["kategori"],
        "resim" => $resim_yolu, // Klasöre kaydedilen yeni yol
        "icerik" => $_POST["icerik"],
        "tarih" => date("d.m.Y") 
    );

    // 3. ADIM: JSON Dosyasına Kaydet
    $gonderiler = array();
    if (file_exists($dosya_yolu)) {
        $gonderiler = json_decode(file_get_contents($dosya_yolu), true);
    }

    // Yeni gönderiyi en başa ekle
    array_unshift($gonderiler, $yeni_gonderi);
    file_put_contents($dosya_yolu, json_encode($gonderiler, JSON_PRETTY_PRINT));
    
    header("Location: index.php");
    exit();
}

// === GÖNDERİLERİ OKUMA ===
$tum_gonderiler = array();
if (file_exists($dosya_yolu)) {
    $tum_gonderiler = json_decode(file_get_contents($dosya_yolu), true);
}
?>

<div class="feed-container">
    <h2 style="text-align: center;">Tarih Tüneli</h2>

    <?php if (isset($_SESSION["ad"])): ?>
        <div class="post-form-card">
            <h3 style="margin-top:0;">Yeni Bilgi Paylaş</h3>
            <form method="POST" action="index.php" enctype="multipart/form-data">
                
                <select name="kategori" required style="width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ddd;">
                    <option value="">Kategori Seçin...</option>
                    <option value="Atatürk'ün Ailesi ve Gençlik Yılları">Atatürk'ün Ailesi ve Gençlik Yılları</option>
                    <option value="Askeri Liderlik ve Savaş Dönemleri">Askeri Liderlik ve Savaş Dönemleri</option>
                    <option value="İnkılaplar, Modernleşme ve Sosyal Hayat">İnkılaplar, Modernleşme ve Sosyal Hayat</option>
                    <option value="Halkla İç İçe (Halkla İlişkiler ve Yurt Gezileri)">Halkla İç İçe</option>
                    <option value="Dış Politika ve Diplomasi">Dış Politika ve Diplomasi</option>
                </select>
                
                <div style="margin-bottom: 10px; border: 1px solid #ddd; padding: 10px; background: #fdfdfd; border-radius: 4px;">
                    <label style="display:block; font-size:13px; margin-bottom:5px; color:#666;">Fotoğraf Yükle:</label>
                    <input type="file" name="resim_dosyasi" accept="image/*" required>
                </div>
                
                <textarea name="icerik" placeholder="Ne paylaşmak istersiniz?" rows="3" style="width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; border-radius: 4px; border: 1px solid #ddd;" required></textarea>
                
                <button type="submit" style="width: 100%; padding: 10px; background-color: #2a9df4; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold;">Gönderiyi Paylaş</button>
            </form>
        </div>
    <?php else: ?>
        <div style="background: #e9ecef; padding: 15px; text-align: center; border-radius: 8px; margin-bottom: 20px;">
            Bilgi paylaşmak ve tartışmalara katılmak için lütfen <a href="login.php" style="color: #2a9df4; font-weight:bold;">giriş yapın</a>.
        </div>
    <?php endif; ?>

    <?php 
    if (!empty($tum_gonderiler)) {
        foreach ($tum_gonderiler as $gonderi) {
            echo '<div class="post-card">';
            
            echo '<div class="post-header">';
            echo '<span class="post-author"><img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" style="width:20px; vertical-align:middle; margin-right:5px;">' . htmlspecialchars($gonderi['yazar']) . '</span>';
            echo '<span class="post-category">' . htmlspecialchars($gonderi['kategori']) . '</span>';
            echo '</div>';
            
            if (!empty($gonderi['resim'])) {
                echo '<div class="post-image"><img src="' . htmlspecialchars($gonderi['resim']) . '" alt="Gönderi Resmi"></div>';
            }
            
            echo '<div class="post-content">' . nl2br(htmlspecialchars($gonderi['icerik'])) . '</div>';
            echo '<div class="post-date">' . htmlspecialchars($gonderi['tarih']) . '</div>';
            
            echo '</div>';
        }
    } else {
        echo '<p style="text-align:center;">Henüz hiç gönderi paylaşılmamış.</p>';
    }
    ?>
</div>

<?php include 'footer.php'; ?>