<?php 
include 'header.php'; 

// URL'den hangi kategoriye tıklandığını 'GET' ile alıyoruz
$secilen_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$dosya_yolu = "veri/gonderiler.json";
$tum_gonderiler = array();

// Gönderileri okuyoruz
if (file_exists($dosya_yolu)) {
    $tum_gonderiler = json_decode(file_get_contents($dosya_yolu), true);
}
?>

<div class="feed-container">
    <h2 style="text-align: center; color: #2a9df4; margin-bottom: 5px;">
        <?php echo htmlspecialchars($secilen_kategori); ?>
    </h2>
    <p style="text-align: center; color: #888; margin-bottom: 30px;">Bu kategoriye ait paylaşımlar listeleniyor</p>

    <?php 
    $gonderi_bulundu = false;

    if (!empty($tum_gonderiler)) {
        foreach ($tum_gonderiler as $gonderi) {
            
            // DİKKAT: Sadece seçilen kategoriyle eşleşen gönderileri ekrana basıyoruz!
            if ($gonderi['kategori'] === $secilen_kategori) {
                $gonderi_bulundu = true;
                
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
        }
    } 

    // Eğer o kategoride hiç resim/gönderi yoksa bu mesaj çıkacak
    if (!$gonderi_bulundu) {
        echo '<div style="background: #fff; padding: 30px; text-align: center; border-radius: 8px; border: 1px solid #ddd;">';
        echo '<h3>Bu kategoride henüz gönderi bulunmamaktadır.</h3>';
        echo '<p>Ana sayfaya dönüp bu kategori için ilk paylaşımı siz yapabilirsiniz!</p>';
        echo '</div>';
    }
    ?>
</div>

<?php include 'footer.php'; ?>