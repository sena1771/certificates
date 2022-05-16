<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="header2.css?v=<?php echo time(); ?>">
    <title>Kurum</title>
</head>
<body>
    <header>
        <nav>
            <a href="kurum_anasayfa.php">
                <img src="../../images/tuu.png" alt="logo" width="130" height="130">
            </a>
            <ul>
                <li><a href="kurum_anasayfa.php">Ana Sayfa</a></li>
                <li><a href="etkinlikleri_yonet.php">Etkinlikleri Yönet</a></li>
            </ul>
            </nav>
            <div>
                <form action="../../includes/i_kurum/i_anasayfa_kurum/kurum_cikis.inc.php" method="POST">
                    <button type="submit" name="kurum_cikis_submit"id="çıkış2">Çıkış yap</button>
                </form>
            </div>
       
    </header>
</body>
</html>