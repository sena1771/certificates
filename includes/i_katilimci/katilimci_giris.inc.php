<?php
    if (isset($_POST['k_giris_submit'])) {
        require '../i_database_handler/dbh.inc.php';

        $eposta_kullaniciAdi = $_POST['k_eposta_kullaniciAdi'];
        $sifre = $_POST['k_sifre'];

        if (empty($eposta_kullaniciAdi) || empty($sifre)) {
            header("Location: ../../katilimci/katilimci_giris.php?error=bos");
            exit();
        }
        else {
            $sql = "SELECT * from katilimci WHERE k_kullanici_adi=? OR eposta=?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../../katilimci/katilimci_giris.php?error=sqlHatasi");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $eposta_kullaniciAdi, $eposta_kullaniciAdi);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    $sifreKontrol = password_verify($sifre, $row['k_sifre']);
                    if ($sifreKontrol == FALSE) {
                        header("Location: ../../katilimci/katilimci_giris.php?error=yanlisSifre");
                        exit();
                    }
                    else if($sifreKontrol == TRUE) {
                        session_start();
                        $_SESSION['ka_id'] = $row['k_id'];
                        $_SESSION['ka_ad'] = $row['ad'];
                        $_SESSION['ka_soyad'] = $row['soyad'];
                        $_SESSION['ka_telefon'] = $row['telefon'];
                        $_SESSION['ka_eposta'] = $row['eposta'];
                        $_SESSION['ka_universite'] = $row['universite'];
                        $_SESSION['ka_fakulte'] = $row['fakulte'];
                        $_SESSION['ka_bolum'] = $row['bolum'];
                        $_SESSION['ka_sinif'] = $row['sinif'];
                        $_SESSION['ka_kullanici_adi'] = $row['k_kullanici_adi'];

                        header("Location: ../../katilimci/anasayfa/katilimci_anasayfa.php?success=girisBasarili");
                        exit();

                    }
                    else {
                        header("Location: ../../katilimci/katilimci_giris.php?error=yanlisSifre");
                        exit();
                    }
                }
                else {
                    header("Location: ../../katilimci/katilimci_giris.php?error=kullaniciYok");
                    exit();
                }
            }
        }
    }
    else {
        header("Location: ../../katilimci/katilimci_giris.php");
        exit();
    }