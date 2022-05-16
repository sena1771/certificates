<?php
    require "header.php";
    require '../../includes/i_database_handler/dbh.inc.php'; //veritabanı bağlantısı
?><link rel="stylesheet" href="etkinlikekle.css?v=<?php echo time(); ?>">

    <main>
        <h1 id="h">Etkinlik Ekle</h1>
        <?php
            //Uyarı mesajları
            if (isset($_GET['error'])) {
                $errorCheck = $_GET['error'];

                switch ($errorCheck) {
                    case 'bos':
                        echo '<p>Tüm alanları doldurunuz!</p>';
                        break;
                    case 'etkinlikVar':
                        echo '<p>Girdiğiniz etkinlik zaten var!</p>';
                        break;
                    case 'yanlisTarihZaman':
                        echo '<p>Geçerli bir tarih ve zaman giriniz!</p>';
                        break;
                    case 'yerZamanAyni':
                        echo '<p>Aynı yerde ve aynı zamanda farklı bir etkinlik var!</p>';
                        break;
                    case 'konusmaciHatasi':
                        echo '<p>Konuşmacıları doğru giriniz (Her konuşmacı arasında bir virgül olması gerekiyor)!</p>';
                        break;
                    case 'sqlHatasi':
                        echo '<p>Veritabanında bir sorun oluştu!</p>';
                        break;
                    case 'resimDegil':
                        echo '<p>Yüklenen dosya resim dosyası değil!</p>';
                        break;
                    case 'resimVar':
                        echo '<p>Farklı bir resim yükleyiniz(yüklenen resim zaten var)!</p>';
                        break;
                    case 'dosyaTipiYanlis':
                        echo '<p>Yüklenecek resmin dosya tipi jpg, png veya jpeg olabilir!</p>';
                        break;
                    case 'yuklemeSorunu':
                        echo '<p>Resim yüklenirken bir sorun oluştu. Tekrar deneyin!</p>';
                        break;
                }
            }
            else if (isset($_GET['success']))
            {
                if ($_GET['success'] == 'etkinlikEklemeBasarili') {
                    echo '<p>Etkinlik başarı ile eklendi.</p>';
                }
            }
        ?> <div class="co">
        <div class="coc">
        <form action="../../includes/i_kurum/i_anasayfa_kurum/etkinlik_ekle.inc.php" method="POST" enctype="multipart/form-data">
            <?php
                if (isset($_GET['e_adi'])) {
                    echo '<label for="e_adi">Etkinlik adı:</label>';
                    echo '<input type="text" name="e_adi" id="e_adi" value='.$_GET['e_adi'].'>';
                }
                else {
                    echo '<label for="e_adi">Etkinlik adı:</label>';
                    echo '<input type="text" name="e_adi" id="e_adi">';
                }

                if (isset($_GET['e_aciklama'])) {
                    echo '<label for="e_aciklama">Etkinlik açıklaması:</label>';
                    echo '<textarea name="e_aciklama" id="e_aciklama" cols="30" rows="10">'.$_GET['e_aciklama'].'</textarea>';
                }
                else {
                    echo '<label for="e_aciklama">Etkinlik açıklaması:</label>';
                    echo '<textarea name="e_aciklama" id="e_aciklama" cols="30" rows="10"></textarea>';
                }

                if (isset($_GET['e_tarih'])) {
                    echo '<label for="e_tarih">Etkinlik tarihi:</label>';
                    echo '<input type="datetime-local" name="e_tarih" id="e_tarih" value='.$_GET['e_tarih'].'>';
                }
                else {
                    echo '<label for="e_tarih">Etkinlik tarihi:</label>';
                    echo '<input type="datetime-local" name="e_tarih" id="e_tarih">';
                }
                
            ?>

            
            

            <?php
                if (isset($_GET['e_yer'])) {
                    echo '<label for="e_yer">Etkinlik yeri:</label>';
                    echo '<textarea name="e_yer" id="e_yer" cols="30" rows="10">'.$_GET['e_yer'].'</textarea>';
                }
                else {
                    echo '<label for="e_yer">Etkinlik yeri:</label>';
                    echo '<textarea name="e_yer" id="e_yer" cols="30" rows="10"></textarea>';
                }

                if (isset($_GET['konusmacilar_implode'])) {
                    echo '<label for="konusmacilar">Konuşmacı ekleyiniz:</label>';
                    echo '<sub>her konuşmacı arasına virgül koyunuz</sub>';
                    echo '<textarea name="konusmacilar" id="konusmacilar" cols="30" rows="10">'.$_GET['konusmacilar_implode'].'</textarea>';
                }
                else {
                    echo '<label for="konusmacilar">Konuşmacı ekleyiniz:</label>';
                    echo '<sub>her konuşmacı arasına virgül koyunuz</sub>';
                    echo '<textarea name="konusmacilar" id="konusmacilar" cols="30" rows="10"></textarea>';
                }
            ?>
            
            <input type="checkbox" id="kontrol">Etkinlik ortak yapılıyor.
            <label for="diger_kurumlar" id="diger_kurumlar_label">Kurum(ları) seçiniz:</label>
            <select name="diger_kurumlar[]" id="diger_kurumlar" multiple>
                <?php $res=mysqli_query($conn, "SELECT svb_id,birim_adi FROM sertifika_veren_birim WHERE NOT (svb_id=".$_SESSION['svb_id'].")");
                while($row=mysqli_fetch_assoc($res))
                echo"<option value=".$row['svb_id'].">".$row['birim_adi']."</option>";?>
            </select>

            <label for="afis_resmi">Afiş resmi yükleyiniz:</label>
            <input type="file" name="afis_resmi" id="afis_resmi">

            <button type="submit" name="etkinlik_ekle_submit"id="ekle">ekle</button> </div> </div>
        </form>   <div class="circle"> </div>
        <div class="circle1"> </div>
        <script type="text/javascript">
            $('#kontrol').on('change', function() {
            $('#diger_kurumlar').toggle(this.checked);
            $('#diger_kurumlar_label').toggle(this.checked);
            }).change();
        </script>
        
    </main>

