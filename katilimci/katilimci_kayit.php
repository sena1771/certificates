<?php
    //session_start();
    include_once '../includes/i_database_handler/dbh.inc.php'; //veritabanı bağlantısı
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
 
    <link rel="stylesheet" href="katilimcikayit.css?v=<?php echo time(); ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="../js/katilimci/katilimci.js"></script>
</head>
<body>
    
        <h1 id="h">Kayıt Ol</h1>
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
                        echo '<p>Farklı bir kullanıcı adı giriniz(kullanıcı adı mevcut)!</p>';
                        break;
                }
            }
        ?>
        <a href="katilimci_giris.php" id="gerib">Geri</a> <div class="co">
                <div class="coc">
        <form action="../includes/i_katilimci/katilimci_kayit.inc.php" method="POST">
            <?php
                if (isset($_GET['k_adi'])) {
                    $k_adi = $_GET['k_adi'];
                    echo '<label for="k_adi">Ad:</label>';
                    echo '<input type="text" name="k_adi" id="k_adi" value="'.$k_adi.'">';
                } 
                else {
                    echo '<label for="k_adi">Ad:</label>';
                    echo '<input type="text" name="k_adi" id="k_adi">';
                }

                if (isset($_GET['k_soyadi'])) {
                    $k_soyadi = $_GET['k_soyadi'];
                    echo '<label for="k_soyadi">Soyad:</label>';
                    echo '<input type="text" name="k_soyadi" id="k_soyadi" value="'.$k_soyadi.'">';
                } 
                else {
                    echo '<label for="k_soyadi">Soyad:</label>';
                    echo '<input type="text" name="k_soyadi" id="k_soyadi">';
                }

                if (isset($_GET['k_telefon'])) {
                    $k_telefon = $_GET['k_telefon'];
                    echo '<label for="k_telefon">Telefon:</label>';
                    echo '<input type="tel" name="k_telefon" id="k_telefon" value="'.$k_telefon.'" placeholder="0 ile başlamalı" pattern="^0[0-9]{10}$" required>';
                } 
                else {
                    echo '<label for="k_telefon">Telefon:</label>';
                    echo '<input type="tel" name="k_telefon" id="k_telefon" placeholder="0 ile başlamalı" pattern="^0[0-9]{10}$" required>';
                }

                if (isset($_GET['k_eposta'])) {
                    $k_eposta = $_GET['k_eposta'];
                    echo '<label for="k_eposta">E-posta:</label>';
                    echo '<input type="text" name="k_eposta" id="k_eposta" value="'.$k_eposta.'">';
                } 
                else {
                    echo '<label for="k_eposta">E-posta:</label>';
                    echo '<input type="text" name="k_eposta" id="k_eposta">';
                }
            ?>


            
            
            <label for="k_universite">Üniversite:</label>
            <select name="k_universite" id="k_universite">
                <option value="default">üniversite seçiniz</option>
                <?php $res=mysqli_query($conn, "select * from yok_universiteler");
                while($row=mysqli_fetch_assoc($res))
                echo"<option value=".$row['id'].">".$row['name']."</option>";?>
            </select>

            <label for="k_fakulte">Fakülte:</label>
            <select name="k_fakulte" id="k_fakulte">
                <option value="">fakülte seçiniz</option>
            </select>

            <label for="k_bolum">Bölüm:</label>
            <select name="k_bolum" id="k_bolum">
                <option value="">Bölüm seçiniz</option>
            </select>

            <label for="k_sinif">Sınıf:</label>
            <select name="k_sinif" id="k_sinif">
                <option value="">Sınıf seçiniz</option>
                <?php $res=mysqli_query($conn, "select * from sinif");
                while($row=mysqli_fetch_assoc($res))
                echo"<option value=".$row['id'].">".$row['name']."</option>";?>
            </select>

            <?php
                if (isset($_GET['k_kullanici_adi'])) {
                    $k_kullanici_adi = $_GET['k_kullanici_adi'];
                    echo '<label for="k_kullanici_adi">Kullanıcı adı:</label>';
                    echo '<input type="text" name="k_kullanici_adi" id="k_kullanici_adi" value="'.$k_kullanici_adi.'">';
                } 
                else {
                    echo '<label for="k_kullanici_adi">Kullanıcı adı:</label>';
                    echo '<input type="text" name="k_kullanici_adi" id="k_kullanici_adi">';
                }
            ?>

            
            

            <label for="k_sifre">Şifre:</label>
            <input type="password" name="k_sifre" id="k_sifre">

            <label for="k_sifre_tekrar">Şifre tekrar:</label>
            <input type="password" name="k_sifre_tekrar" id="k_sifre_tekrar">
            
            <button type="submit" name="k_kayit_submit">kayıt ol</button>
        </form>
        <div class="circle"> </div>
        <div class="circle1"> </div>

    <script type="text/javascript">
        $(document).ready(function(){
            // üniversiteye bağlı select
            $("#k_universite").on("change",function(){
                var universiteId = $(this).val();
                $.ajax({
                    url :"../includes/i_katilimci/katilimci_kayit_action.inc.php",
                    type:"POST",
                    cache:false,
                    data:{universiteId:universiteId},
                    success:function(data){
                        $("#k_fakulte").html(data);
                        $('#k_bolum').html('<option value="">bölüm seçiniz</option>');
                    }
                });			
            });

            // fakulteye bağlı select
            $("#k_fakulte").on("change", function(){
                var fakulteId = $(this).val();
                $.ajax({
                    url :"../includes/i_katilimci/katilimci_kayit_action.inc.php",
                    type:"POST",
                    cache:false,
                    data:{fakulteId:fakulteId},
                    success:function(data){
                        $("#k_bolum").html(data);
                    }
                });
            });
        });
    </script>

            
    
    
</body>
</html>