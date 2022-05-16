<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="kurum.css?v=<?php echo time(); ?>">
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <title>SVB giriş</title>
</head>
<body>
    <a href="../index.php"id="gerit">Geri</a>
    
    <h1 id="h">Giriş Yap</h1>
        <?php
            if (isset($_GET['success'])) {
                if ($_GET['success'] == 'cikisBasarili') {
                    echo '<p>Çıkış işlemi başarılı bir şekilde gerçekleşti.</p>';
                }   
            }
            else if(isset($_GET['error']))
            {
                $errorCheck = $_GET['error'];

                switch ($errorCheck) {
                    case 'bos':
                        echo '<p>Tüm alanları doldurunuz!</p>';
                        break;
                    case 'yanlisSifre':
                        echo '<p>Yanlış şifre girdiniz!</p>';
                        break;
                    case 'sqlHatasi':
                        echo '<p>Veritabanında bir sorun oluştu!</p>';
                        break;
                    case 'kullaniciYok':
                        echo '<p>Kullanıcı adı yanlış!</p>';
                        break;
                }
            }
        ?> <div class="co">
            <div class="coc">
                <div class="circ"> </div>
        <form action="../includes/i_kurum/kurum_giris.inc.php" method="POST">
            <label for="svb_kullaniciAdi "id="id1">Kullanıcı adı:</label>
            <input type="text" name="svb_kullaniciAdi" id="svb_kullaniciAdi">

            <label for="svb_sifre"id="id2">Şifre:</label>
            <input type="password" name="svb_sifre" id="svb_sifre">

            <button type="submit" name="svb_giris_submit"id="button">giriş yap</button>
        </form>
    </div> </div> 
    <div class="circle"> </div>
    <div class="circle1"> </div>
</body>
</html>