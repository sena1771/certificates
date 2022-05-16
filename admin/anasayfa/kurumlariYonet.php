<!DOCTYPE html>
<html lang="en">

<?php
    require "header.php";
    include_once '../../includes/i_database_handler/dbh.inc.php'; //veritabanı bağlantısı
?>
<link rel="stylesheet" href="kurumyönet.css?v=<?php echo time(); ?>">
 <body>
    <main>
        <a href="kurumEkle.php" id="kurumek">Kurum Ekle</a>

        <!-- Burada kurumlar listelenecek. Kurum silme ve düzenleme seçenekleri olacak -->
        <?php
            if (isset($_GET['success'])) {
                $successCheck = $_GET['success'];
                switch ($successCheck) {
                    case 'silmeBasarili':
                        echo '<p>Silme işlemi başarı ile gerçekleşti.</p>';
                        break;
                }
            }
            else if (isset($_GET['error'])) {
                $errorCheck = $_GET['error'];
                switch ($errorCheck) {
                    case 'silmeBasarisiz':
                        echo '<p>Silme işlemi yapılırken bir sorun oluştu!</p>';
                        break;
                }
            }
            $sql = "SELECT svb_id AS 'ID', birim_adi AS 'Birim Adı', svb_aciklama AS 'Birim Açıklaması', adres AS 'Adres', y_adi AS 'Yetkili Adı', y_soyadi AS 'Yetkili Soyadı', y_eposta AS 'Yetkili E-posta' FROM sertifika_veren_birim;";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                $query = array();
                
                while($query[] = mysqli_fetch_assoc($result));
                array_pop($query);

                // veritabanı tablosuna göre dinamik tablo oluşturma
                echo '<table border="1" style="text-align: center;">';
                
                echo '<tr>';
                foreach($query[0] as $key => $value) {
                    echo '<td>';
                    echo $key;
                    echo '</td>';
                }
                echo '<td>';
                echo '</td>';
                echo '<td>';
                echo '</td>';
                echo '</tr>';
                foreach($query as $row) {
                    echo '<tr>';
                    foreach($row as $column) {
                        echo '<td>';
                        echo $column;
                        echo '</td>';
                    }

                    ?>
                        <!-- Düzenleme İşlemi => veriler "kurum_duzenle.php" sayfasına aktarılıyor(gizli şekilde) -->
                        <form action="kurum_duzenle.php" method="POST">
                            <input type='hidden' name='svbirim_id' value="<?php echo $row['ID'] ?>"> 
                            <input type='hidden' name='svb_ad' value="<?php echo $row['Birim Adı'] ?>">
                            <input type='hidden' name='svb_aciklama' value="<?php echo $row['Birim Açıklaması'] ?>">
                            <input type='hidden' name='svb_adres' value="<?php echo $row['Adres'] ?>">
                            <input type='hidden' name='y_ad' value="<?php echo $row['Yetkili Adı'] ?>">
                            <input type='hidden' name='y_soyad' value="<?php echo $row['Yetkili Soyadı'] ?>">
                            <input type='hidden' name='y_eposta' value="<?php echo $row['Yetkili E-posta'] ?>">                           
                            <td><button type="submit" name="svb_duzenle_submit" class="butonDuzenle">Düzenle</button></td>  
                        </form>

                        <!-- Silme İşlemi => Seçilen kurumun ID'si "kurum_sil.php" dosyasına gönderiliyor ve bu ID ye ait kurum siliniyor -->
                        <form action="kurum_sil.php" method="POST">
                        <input type='hidden' name='svb_id' value="<?php echo $row['ID'] ?>">
                            <td><button type="submit" name="svb_sil_submit" class="butonSil">Sil</button></td>
                        </form>
                    <?php
                    echo '</tr>';
                }   
                echo '</table>';
            }
        ?>
        
    </main>
       
<?php
    require "footer.php";
?>  </body></html>