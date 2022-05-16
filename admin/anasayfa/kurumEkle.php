<?php
    require "header.php";
?>
<link rel="stylesheet" href="kurumekle.css?v=<?php echo time(); ?>">
    <main>
        <h1>Kurum Ekle</h1>
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
                if ($_GET['success'] == 'kayitBasarili') {
                    echo '<p>Kurum kaydı başarı ile yapılmıştır.</p>';
                }
            }
        ?><div class="co">
        <div class="coc">
        <form action="../../includes/i_admin/i_anasayfa_admin/i_kurumlari_yonet/kurumEkle.inc.php" method="POST">
            <?php 
            echo  '<div class="all">';
                if (isset($_GET['svb_adi'])) {
                    $svb_adi = $_GET['svb_adi'];
                    echo '<label for="svb_adi">Birim adı:</label>';
                    echo '<input type="text" name="svb_adi" id="svb_adi" value="'.$svb_adi.'">';
                } 
                else {
                    echo '<label for="svb_adi">Birim adı:</label>';
                    echo '<input type="text" name="svb_adi" id="svb_adi">';
                }

                if (isset($_GET['svb_aciklama'])) {
                    $svb_aciklama = $_GET['svb_aciklama'];
                    echo '<label for="svb_aciklama">Birim hakkında açıklama:</label>';
                    echo '<textarea name="svb_aciklama" id="svb_aciklama" cols="30" rows="7">'.$svb_aciklama.'</textarea>';
                } 
                else {
                    echo '<label for="svb_aciklama">Birim hakkında açıklama:</label>';
                    echo '<textarea name="svb_aciklama" id="svb_aciklama" cols="30" rows="7"></textarea>';
                }

                if (isset($_GET['svb_adres'])) {
                    $svb_adres = $_GET['svb_adres'];
                    echo '<label for="svb_adres">Adres:</label>';
                    echo '<textarea name="svb_adres" id="svb_adres" cols="30" rows="7">'.$svb_adres.'</textarea>';
                } 
                else {
                    echo '<label for="svb_adres">Adres:</label>';
                    echo '<textarea name="svb_adres" id="svb_adres" cols="30" rows="7"></textarea>';
                }

                if (isset($_GET['y_adi'])) {
                    $y_adi = $_GET['y_adi'];
                    echo '<label for="y_adi">Yetkili adı:</label>';
                    echo '<input type="text" name="y_adi" id="y_adi" value="'.$y_adi.'">';
                } 
                else {
                    echo '<label for="y_adi">Yetkili adı:</label>';
                    echo '<input type="text" name="y_adi" id="y_adi">';
                }

                if (isset($_GET['y_soyadi'])) {
                    $y_soyadi = $_GET['y_soyadi'];
                    echo '<label for="y_soyadi">Yetkili soyadı:</label>';
                    echo '<input type="text" name="y_soyadi" id="y_soyadi" value="'.$y_soyadi.'">';
                } 
                else {
                    echo '<label for="y_soyadi">Yetkili soyadı:</label>';
                    echo '<input type="text" name="y_soyadi" id="y_soyadi">';
                }

                if (isset($_GET['y_eposta'])) {
                    $y_eposta = $_GET['y_eposta'];
                    echo '<label for="y_eposta">Yetkili e-postası:</label>';
                    echo '<input type="email" name="y_eposta" id="y_eposta" value="'.$y_eposta.'">';
                } 
                else {
                    echo '<label for="y_eposta">Yetkili e-postası:</label>';
                    echo '<input type="email" name="y_eposta" id="y_eposta">';
                }
               
            ?>
                 
            <label for="svb_kullaniciAdi">Kullanıcı adı:</label>
            <input type="text" name="svb_kullaniciAdi" id="svb_kullaniciAdi">

            <label for="svb_sifre">Şifre:</label>
            <input type="password" name="svb_sifre" id="svb_sifre">

            <label for="svb_sifre_tekrar">Şifre tekrar:</label>
            <input type="password" name="svb_sifre_tekrar" id="svb_sifre_tekrar">

            <button type="submit" name="a_kurumEkle_submit">Kurumu ekle</button>
        </form><div class="circle"> </div>
        <div class="circle1"> </div>
        
       
    </main>

<?php
    require "footer.php";
?>