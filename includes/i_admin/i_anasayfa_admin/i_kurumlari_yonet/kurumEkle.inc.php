<?php
    if (isset($_POST['a_kurumEkle_submit'])) {
        require '../../../i_database_handler/dbh.inc.php';

        $birimAdi = $_POST['svb_adi'];
        $birimAciklamasi = $_POST['svb_aciklama'];
        $adres = $_POST['svb_adres'];
        $yetkiliAdi = $_POST['y_adi'];
        $yetkiliSoyadi = $_POST['y_soyadi'];
        $yetkiliEposta = $_POST['y_eposta'];
        $kullaniciAdi = $_POST['svb_kullaniciAdi'];
        $sifre = $_POST['svb_sifre'];
        $sifreTekrar = $_POST['svb_sifre_tekrar'];

        //Error Handlers
        if (empty($birimAdi) || empty($birimAciklamasi) || empty($adres) || empty($yetkiliAdi) || empty($yetkiliSoyadi) || empty($yetkiliEposta)  
         || empty($kullaniciAdi) || empty($sifre)) {     //boş input kontrolü
            header("Location: ../../../../admin/anasayfa/kurumEkle.php?error=bos&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi."&y_eposta=".$yetkiliEposta);
            exit();
        }
        else if(!filter_var($yetkiliEposta,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$kullaniciAdi)) {      //email & kullanıcı adı kontrolü
            header("Location: ../../../../admin/anasayfa/kurumEkle.php?error=gecersizEpostaVeKullaniciAdi&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi);
            exit();
        }
        else if(!filter_var($yetkiliEposta,FILTER_VALIDATE_EMAIL)) {       //email kontrolü
            header("Location: ../../../../admin/anasayfa/kurumEkle.php?error=gecersizEposta&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi);
            exit();
        }
        else if(!preg_match("/^[a-zA-Z0-9]*$/",$kullaniciAdi)) {    //kullanıcı adı kontrolü
            header("Location: ../../../../admin/anasayfa/kurumEkle.php?error=gecersizKullaniciAdi&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi."&y_eposta=".$yetkiliEposta);
            exit();
        }
        else if ($sifre !== $sifreTekrar) {
            header("Location: ../../../../admin/anasayfa/kurumEkle.php?error=sifreFarkli&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi."&y_eposta=".$yetkiliEposta);
            exit();
        }
        else {
            $sql = "SELECT svb_kullanici_adi FROM sertifika_veren_birim WHERE svb_kullanici_adi=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {    //MariaDB Syntax SQL uygunluk kontrolü?
                header("Location: ../../../../admin/anasayfa/kurumEkle.php?error=sqlHatasi&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi."&y_eposta=".$yetkiliEposta);
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $kullaniciAdi);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0) {         //kullanıcı adı alınmış mı?
                    header("Location: ../../../../admin/anasayfa/kurumEkle.php?error=kullaniciAdiMevcut&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi."&y_eposta=".$yetkiliEposta);
                    exit();
                }
                else {
                    $sql = "INSERT INTO sertifika_veren_birim (birim_adi, svb_aciklama, adres, y_adi, y_soyadi, y_eposta, svb_kullanici_adi, svb_sifre) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt,$sql)) {     //MariaDB Syntax SQL uygunluk kontrolü?
                        header("Location: ../../../../admin/anasayfa/kurumEkle.php?error=sqlHatasi&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi."&y_eposta=".$yetkiliEposta);
                        exit();
                    }
                    else {
                        $hashli_sifre = password_hash($sifre, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "ssssssss", $birimAdi, $birimAciklamasi, $adres, $yetkiliAdi, $yetkiliSoyadi, $yetkiliEposta, $kullaniciAdi, $hashli_sifre);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../../../../admin/anasayfa/kurumEkle.php?success=kayitBasarili");
                        exit();
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else {
        header("Location: ../../../../admin/anasayfa/kurumEkle.php");
        exit();
    }
?>