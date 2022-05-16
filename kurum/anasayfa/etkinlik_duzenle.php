<?php
    require 'header.php';
    date_default_timezone_set('Europe/Istanbul');
?><link rel="stylesheet" href="düzenle.css?v=<?php echo time(); ?>">
    <main>
        <h1 id="h">Etkinlik Düzenle</h1>
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
                if ($_GET['success'] == 'etkinlikGuncellemeBasarili') {
                    echo '<p>Etkinlik başarı ile Güncellendi.</p>';
                }
            }
        ?><div class="co">
        <div class="coc">
        <form action="../../includes/i_kurum/i_anasayfa_kurum/etkinlik_duzenle.inc.php" method="POST" enctype="multipart/form-data">
            
            <?php
            
                if (isset($_GET['e_adi'])) {
                    $e_adi = $_GET['e_adi'];
                    echo '<label for="e_adi">Etkinlik adı:</label>';
                    echo '<textarea name="e_adi" id="e_adi" cols="20" rows="5">'.$e_adi.'</textarea>';
                } 
                else {
                    echo '<label for="e_adi">Etkinlik adı:</label>';
                    echo '<textarea name="e_adi" id="e_adi" cols="20" rows="5">'.$_POST['etkinlik_adi'].'</textarea>';
                }

                if (isset($_GET['e_aciklama'])) {
                    $e_aciklama = $_GET['e_aciklama'];
                    echo '<label for="e_aciklama">Etkinlik açıklaması:</label>';
                    echo '<textarea name="e_aciklama" id="e_aciklama" cols="30" rows="7">'.$e_aciklama.'</textarea>';
                } 
                else {
                    echo '<label for="e_aciklama">Birim hakkında açıklama:</label>';
                    echo '<textarea name="e_aciklama" id="e_aciklama" cols="30" rows="7">'.$_POST['etkinlik_aciklama'].'</textarea>';
                }

                if (isset($_GET['e_tarih'])) {
                    $e_tarih = $_GET['e_tarih'];
                    echo '<label for="e_tarih">Etkinlik tarihi:</label>';
                    echo '<input type="datetime-local" name="e_tarih" id="e_tarih" value="'.str_replace(" ", "T", $e_tarih).'">';
                } 
                else {
                    $_SESSION['etkinlik_tarih'] = $_POST['etkinlik_tarih'];
                    echo '<label for="e_tarih">Etkinlik tarihi:</label>';
                    echo '<input type="datetime-local" name="e_tarih" id="e_tarih" value="'.str_replace(" ", "T", $_POST['etkinlik_tarih']).'">';
                }

                if (isset($_GET['e_yer'])) {
                    $e_yer = $_GET['e_yer'];
                    echo '<label for="e_yer">Etkinlik yeri:</label>';
                    echo '<textarea name="e_yer" id="e_yer" cols="30" rows="7">'.$e_yer.'</textarea>';
                } 
                else {
                    echo '<label for="e_yer">Etkinlik yeri:</label>';
                    echo '<textarea name="e_yer" id="e_yer" cols="30" rows="7">'.$_POST['etkinlik_yer'].'</textarea>';
                }

                if (isset($_GET['konusmacilar_implode'])) {
                    $konusmacilar_implode = $_GET['konusmacilar_implode'];
                    echo '<label for="e_konusmacilar">Konuşmacılar:</label>';
                    echo '<textarea name="e_konusmacilar" id="e_konusmacilar" cols="30" rows="7">'.$konusmacilar_implode.'</textarea>';
                } 
                else {
                    $etkinlik_konusmacilar = $_POST['etkinlik_konusmacilar'];
                    echo '<label for="e_konusmacilar">Konuşmacılar:</label>';
                    echo '<textarea name="e_konusmacilar" id="e_konusmacilar" cols="30" rows="7">'.$etkinlik_konusmacilar.'</textarea>';
                }
                if (isset($_POST['etkinlik_afis_resmi'])) {
                    echo '<label for="afis_resmi">Afiş resmi:</label>';
                    echo '<img src="'.$_POST['etkinlik_afis_resmi'].'" id="afis_resmi">';
                    echo '<label for="afis_resmi_yukle">Yeni resim yükle:</label>';
                    echo '<input type="file" name="afis_resmi_yukle" id="afis_resmi_yukle">';
                    echo '<input type="hidden" name="afis_resmi" value="'.$_POST['etkinlik_afis_resmi'].'">';
                }
                else {
                    echo '<label for="afis_resmi">Afiş resmi:</label>';
                    echo '<img src="'.$_GET['etkinlik_afis_resmi'].'" id="afis_resmi">';
                    echo '<label for="afis_resmi_yukle">Yeni resim yükle:</label>';
                    echo '<input type="file" name="afis_resmi_yukle" id="afis_resmi_yukle">';
                    echo '<input type="hidden" name="afis_resmi" value="'.$_GET['etkinlik_afis_resmi'].'">';
                }
                
                
                
                
            ?>
           
            <?php
                if (isset($_POST['etkinlik_id'])) {
                    $_SESSION['et_id'] = $_POST['etkinlik_id'];
                }
                
            ?>
            <button type="submit" name="k_etkinlik_duzenle_submit"id="güncel">Etkinliği Güncelle</button>
        </form> <div class="circle"> </div>
        <div class="circle1"> </div>
    </main>


