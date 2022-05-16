<?php
    if (isset($_POST['a_giris_submit'])) {
        require '../i_database_handler/dbh.inc.php';

        $kullaniciAdi = $_POST['a_kullaniciAdi'];
        $sifre = $_POST['a_sifre'];

        if (empty($kullaniciAdi) || empty($sifre)) {
            header("Location: ../../admin/admin_giris.php?error=bos");
            exit();
        }
        else {
            $sql = "SELECT * FROM admin WHERE a_kullanici_adi=?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../../admin/admin_giris.php?error=sqlHatasi");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $kullaniciAdi);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    $sifreKontrol = password_verify($sifre, $row['a_sifre']);
                    if ($sifreKontrol == FALSE) {
                        header("Location: ../../admin/admin_giris.php?error=yanlisSifre");
                        exit();
                    }
                    else if($sifreKontrol == TRUE) {
                        session_start();
                        $_SESSION['ad_id'] = $row['a_id'];
                        header("Location: ../../admin/anasayfa/admin_anasayfa.php?success=girisBasarili");
                        exit();

                    }
                    else {
                        header("Location: ../../admin/admin_giris.php?error=yanlisSifre");
                        exit();
                    }
                }
                else {
                    header("Location: ../../admin/admin_giris.php?error=kullaniciYok");
                    exit();
                }
            }
        }
    }
    else {
        header("Location: ../../admin/admin_giris.php?");
        exit();
    }