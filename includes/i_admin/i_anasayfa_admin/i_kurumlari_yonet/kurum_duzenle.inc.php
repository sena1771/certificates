<?php
    if (isset($_POST['a_kurum_duzenle_submit'])) {
        require '../../../i_database_handler/dbh.inc.php';
        session_start();

        $birimAdi = $_POST['svb_adi'];
        $birimAciklamasi = $_POST['svb_aciklama'];
        $adres = $_POST['svb_adres'];
        $yetkiliAdi = $_POST['y_adi'];
        $yetkiliSoyadi = $_POST['y_soyadi'];
        $yetkiliEposta = $_POST['y_eposta'];

        //Error Handlers
        if (empty($birimAdi) || empty($birimAciklamasi) || empty($adres) || empty($yetkiliAdi) || empty($yetkiliSoyadi) || empty($yetkiliEposta)) {     //boş input kontrolü
            header("Location: ../../../../admin/anasayfa/kurum_duzenle.php?error=bos&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi."&y_eposta=".$yetkiliEposta);
            exit();
        }
        else if(!filter_var($yetkiliEposta,FILTER_VALIDATE_EMAIL)) {       //email kontrolü
            header("Location: ../../../../admin/anasayfa/kurum_duzenle.php?error=gecersizEposta&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi);
            exit();
        }
        else {
            $sql = "UPDATE sertifika_veren_birim SET birim_adi=?, svb_aciklama=?, adres=?, y_adi=?, y_soyadi=?, y_eposta=? WHERE svb_id=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../../../../admin/anasayfa/kurum_duzenle.php?error=sqlHatasi&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi."&y_eposta=".$yetkiliEposta);
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ssssssi", $birimAdi, $birimAciklamasi, $adres, $yetkiliAdi, $yetkiliSoyadi, $yetkiliEposta, $_SESSION['svbir_id']);
                mysqli_stmt_execute($stmt);
                //session_unset();
                //session_destroy();
                header("Location: ../../../../admin/anasayfa/kurum_duzenle.php?success=duzenlemeBasarili&svb_adi=".$birimAdi."&svb_aciklama=".$birimAciklamasi."&svb_adres=".$adres."&y_adi=".$yetkiliAdi."&y_soyadi=".$yetkiliSoyadi."&y_eposta=".$yetkiliEposta);
                exit();
            }
        }
    }
    else {
        header("Location: ../../../../admin/anasayfa/kurum_duzenle.php");
        exit();
    }
?>