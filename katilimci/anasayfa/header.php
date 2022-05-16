<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header1.css?v=<?php echo time(); ?>">
    <title></title>
</head>
<body>
    <header>
        <nav>
            <a href="katilimci_anasayfa.php">
                <img src="../../images/tuu.png" alt="logo"id="logo">
            </a>
            <ul>
                <li><a href="katilimci_anasayfa.php">Ana Sayfa</a></li>
                <li><a href="">Etkinlikler</a></li>
                <li><a href="">Sertifikalarım</a></li>
            </ul>
            <div>
                <form action="../../includes/i_katilimci/i_anasayfa_katilimci/katilimci_cikis.inc.php" method="POST">
                    <button type="submit" name="katilimci_cikis_submit" id="button">Çıkış yap</button>
                </form>
            </div>
        </nav>
    </header>
</body>
</html>