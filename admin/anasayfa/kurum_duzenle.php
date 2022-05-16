<?php
    require 'header.php';
?>
<link rel="stylesheet" href="kurumduzenle.css?v=<?php echo time(); ?>">
    <main>
        <h1>Kurum Düzenle</h1>
        <?php
            //Uyarı mesajları
            if (isset($_GET['error'])) {
                $errorCheck = $_GET['error'];

                switch ($errorCheck) {
                    case 'bos':
                        echo '<p>Tüm alanları doldurunuz!</p>';
                        break;
                    case 'gecersizEpostaVeKullaniciAdi':
                        echo '<p>Geçerli bir e-posta veya kullanıcı adı giriniz!</p>';
                        break;
                    case 'gecersizEposta':
                        echo '<p>Geçerli bir e-posta giriniz!</p>';
                        break;
                    case 'gecersizKullaniciAdi':
                        echo '<p>Geçerli bir kullanıcı adı giriniz!</p>';
                        break;
                    case 'sifreFarkli':
                        echo '<p>Girdiğiniz şifreler farklı!</p>';
                        break;
                    case 'sqlHatasi':
                        echo '<p>Veritabanında bir sorun oluştu!</p>';
                        break;
                    case 'kullaniciAdiMevcut':
                        echo '<p>Farklı bir kullanıcı adı giriniz(kullanıcı adı veritabanında mevcut)!</p>';
                        break;
                }
            }
            else if (isset($_GET['success']))
            {
                if ($_GET['success'] == 'duzenlemeBasarili') {
                    echo '<p>Kurum düzenlemesi başarı ile yapılmıştır.</p>';
                }
            }
        ?><div class="co">
        <div class="coc">
        <form action="../../includes/i_admin/i_anasayfa_admin/i_kurumlari_yonet/kurum_duzenle.inc.php" method="POST">
            
            <?php
            echo '<div class="all">';
                if (isset($_GET['svb_adi'])) {
                    $svb_adi = $_GET['svb_adi'];
                    echo '<label for="svb_adi">Birim adı:</label>';
                    echo '<textarea name="svb_adi" id="svb_adi" cols="20" rows="5">'.$svb_adi.'</textarea>';
                } 
                else {
                    echo '<label for="svb_adi">Birim adı:</label>';
                    echo '<textarea name="svb_adi" id="svb_adi" cols="20" rows="5">'.$_POST['svb_ad'].'</textarea>';
                }

                if (isset($_GET['svb_aciklama'])) {
                    $svb_aciklama = $_GET['svb_aciklama'];
                    echo '<label for="svb_aciklama">Birim hakkında açıklama:</label>';
                    echo '<textarea name="svb_aciklama" id="svb_aciklama" cols="30" rows="7">'.$svb_aciklama.'</textarea>';
                } 
                else {
                    echo '<label for="svb_aciklama">Birim hakkında açıklama:</label>';
                    echo '<textarea name="svb_aciklama" id="svb_aciklama" cols="30" rows="7">'.$_POST['svb_aciklama'].'</textarea>';
                }

                if (isset($_GET['svb_adres'])) {
                    $svb_adres = $_GET['svb_adres'];
                    echo '<label for="svb_adres">Adres:</label>';
                    echo '<textarea name="svb_adres" id="svb_adres" cols="30" rows="7">'.$svb_adres.'</textarea>';
                } 
                else {
                    echo '<label for="svb_adres">Adres:</label>';
                    echo '<textarea name="svb_adres" id="svb_adres" cols="30" rows="7">'.$_POST['svb_adres'].'</textarea>';
                }

                if (isset($_GET['y_adi'])) {
                    $y_adi = $_GET['y_adi'];
                    echo '<label for="y_adi">Yetkili adı:</label>';
                    echo '<textarea name="y_adi" id="y_adi" cols="30" rows="7">'.$y_adi.'</textarea>';
                } 
                else {
                    echo '<label for="y_adi">Yetkili adı:</label>';
                    echo '<textarea name="y_adi" id="y_adi" cols="30" rows="7">'.$_POST['y_ad'].'</textarea>';
                }

                if (isset($_GET['y_soyadi'])) {
                    $y_soyadi = $_GET['y_soyadi'];
                    echo '<label for="y_soyadi">Yetkili soyadı:</label>';
                    echo '<textarea name="y_soyadi" id="y_soyadi" cols="30" rows="7">'.$y_soyadi.'</textarea>';
                } 
                else {
                    echo '<label for="y_soyadi">Yetkili soyadı:</label>';
                    echo '<textarea name="y_soyadi" id="y_soyadi" cols="30" rows="7">'.$_POST['y_soyad'].'</textarea>';
                }

                if (isset($_GET['y_eposta'])) {
                    $y_eposta = $_GET['y_eposta'];
                    echo '<label for="y_eposta">Yetkili e-postası:</label>';
                    echo '<input type="email" name="y_eposta" id="y_eposta" value="'.$y_eposta.'">';
                } 
                else {
                    echo '<label for="y_eposta">Yetkili e-postası:</label>';
                    echo '<input type="email" name="y_eposta" id="y_eposta" value="'.$_POST['y_eposta'].'">';
                }
                echo '</div>';
            ?>
            <?php
                if (isset($_POST['svbirim_id'])) {
                    $_SESSION['svbir_id'] = $_POST['svbirim_id'];
                }
                
            ?>
            <button type="submit" name="a_kurum_duzenle_submit" id="güncelle">Kurumu Güncelle</button>
        </form><div class="circle"> </div>
        <div class="circle1"> </div>
    </main>

<?php
    require 'footer.php';
?>