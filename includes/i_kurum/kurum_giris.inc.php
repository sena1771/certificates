<?php
    if (isset($_POST['svb_giris_submit'])) {
        require '../i_database_handler/dbh.inc.php';

        $kullaniciAdi = $_POST['svb_kullaniciAdi'];
        $sifre = $_POST['svb_sifre'];
        if (empty($kullaniciAdi) || empty($sifre)) {
            header("Location: ../../kurum/kurum_giris.php?error=bos");
            exit();
        }
        else {
            $sql = "SELECT * FROM sertifika_veren_birim WHERE svb_kullanici_adi=?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../../kurum/kurum_giris.php?error=sqlHatasi");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $kullaniciAdi);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    $sifreKontrol = password_verify($sifre, $row['svb_sifre']);
                    if ($sifreKontrol == FALSE) {
                        header("Location: ../../kurum/kurum_giris.php?error=yanlisSifre");
                        exit();
                    }
                    else if($sifreKontrol == TRUE) {
                        session_start();
                        $_SESSION['svb_id'] = $row['svb_id'];
                        $_SESSION['birim_adi'] = $row['birim_adi'];
                        $_SESSION['svb_aciklama'] = $row['svb_aciklama'];
                        $_SESSION['adres'] = $row['adres'];
                        $_SESSION['y_adi'] = $row['y_adi'];
                        $_SESSION['y_soyadi'] = $row['y_soyadi'];
                        $_SESSION['y_eposta'] = $row['y_eposta'];
                        $_SESSION['svb_kullanici_adi'] = $row['svb_kullanici_adi'];
                        header("Location: ../../kurum/anasayfa/kurum_anasayfa.php?success=girisBasarili");
                        exit();

                    }
                    else {
                        header("Location: ../../kurum/kurum_giris.php?error=yanlisSifre");
                        exit();
                    }
                }
                else {
                    header("Location: ../../kurum/kurum_giris.php?error=kullaniciYok");
                    exit();
                }
            }
        }
    }
    else {
        header("Location: ../../kurum/kurum_giris.php");
        exit();
    }