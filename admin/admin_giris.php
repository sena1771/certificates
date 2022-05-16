<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css?v=<?php echo time(); ?>">
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <title>Admin giriş</title>
</head>
<body>
    <a href="../index.php"><span class="geri">Geri</span></a>
    
    <h1 id="h">Giriş Yap (Admin)</h1>
        <?php
            if (isset($_GET['success'])) {
                if ($_GET['success'] == 'cikisBasarili') {
                    echo '<p>Çıkış işlemi başarılı bir şekilde gerçekleşti.</p>';
                }
            }
            else if (isset($_GET['error'])) {
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
                        echo '<p>Böyle bir admin bulunmamaktadır!</p>';
                        break;
                }
            }
        ?> 
        <div class="co">
            <div class="coc">
                <div class="circ"> </div>
        <form action="../includes/i_admin/admin_giris.inc.php" method="POST">
            <label for="a_kullaniciAdi" id="id1">Kullanıcı adı:</label>
            <input type="text" name="a_kullaniciAdi" id="a_kullaniciAdi">

            <label for="a_sifre" id="id2">Şifre:</label>
            <input type="password" name="a_sifre" id="a_sifre">

            <button type="submit" name="a_giris_submit">giriş yap</button>
        </form> </div>
    </div> 
    <div class="circle"> </div>
    <div class="circle1"> </div>
</body>
</html>