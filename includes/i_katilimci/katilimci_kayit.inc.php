<?php
    if (isset($_POST['k_kayit_submit'])) {
        require '../i_database_handler/dbh.inc.php';

        $ad = $_POST['k_adi'];
        $soyad = $_POST['k_soyadi'];
        $telefon = $_POST['k_telefon'];
        $eposta = $_POST['k_eposta'];

        $universite = $_POST['k_universite'];
        /*$sql1 = "SELECT name FROM yok_universiteler WHERE id = '$universite';";
        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($result1);
        $universite = $row1['name'];*/

        $fakulte = $_POST['k_fakulte'];
        /*$sql2 = "SELECT name FROM yok_fakulteler WHERE id = '$fakulte';";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $fakulte = $row2['name'];*/

        $bolum = $_POST['k_bolum'];
        /*$sql3 = "SELECT name FROM yok_bolumler WHERE id = '$fakulte';";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
        $bolum = $row3['name'];*/

        $sinif = $_POST['k_sinif'];
        /*$sql4 = "SELECT name FROM yok_bolumler WHERE id = '$sinif';";
        $result4 = mysqli_query($conn, $sql4);
        $row4 = mysqli_fetch_assoc($result4);
        $sinif = $row4['name'];*/

        $kullaniciAdi = $_POST['k_kullanici_adi'];
        $sifre = $_POST['k_sifre'];
        $sifreTekrar = $_POST['k_sifre_tekrar'];
        
        //Error Handlers
        if (empty($ad) || empty($soyad) || empty($telefon) || empty($eposta) || empty($universite) || empty($fakulte)  
         || empty($bolum) || empty($sinif) || empty($kullaniciAdi) || empty($sifre) || empty($sifreTekrar)) {     //boş input kontrolü
            header("Location: ../../katilimci/katilimci_kayit.php?error=bos&k_adi=".$ad."&k_soyadi=".$soyad."&k_telefon=".$telefon."&k_kullanici_adi=".$kullaniciAdi."&k_eposta=".$eposta);
            exit();
        }
        else if(!filter_var($eposta,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$kullaniciAdi)) {      //email & kullanıcı adı kontrolü
            header("Location: ../../katilimci/katilimci_kayit.php?error=gecersizEpostaVeKullaniciAdi&k_adi=".$ad."&k_soyadi=".$soyad."&k_telefon=".$telefon);
            exit();
        }
        else if(!filter_var($eposta,FILTER_VALIDATE_EMAIL)) {       //email kontrolü
            header("Location: ../../katilimci/katilimci_kayit.php?error=gecersizEposta&k_adi=".$ad."&k_soyadi=".$soyad."&k_telefon=".$telefon."&k_kullanici_adi=".$kullaniciAdi);
            exit();
        }
        else if(!preg_match("/^[a-zA-Z0-9]*$/",$kullaniciAdi)) {    //kullanıcı adı kontrolü
            header("Location: ../../katilimci/katilimci_kayit.php?error=gecersizKullaniciAdi&k_adi=".$ad."&k_soyadi=".$soyad."&k_telefon=".$telefon."&k_eposta=".$eposta);
            exit();
        }
        else if ($sifre !== $sifreTekrar) {
            header("Location: ../../katilimci/katilimci_kayit.php?error=sifreFarkli&k_adi=".$ad."&k_soyadi=".$soyad."&k_telefon=".$telefon."&k_kullanici_adi=".$kullaniciAdi."&k_eposta=".$eposta);
            exit();
        }
        else {
            $sql = "SELECT k_kullanici_adi FROM katilimci WHERE k_kullanici_adi=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {    //SQL uygunluk kontrolü?
                header("Location: ../../katilimci/katilimci_kayit.php?error=sqlHatasi");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $kullaniciAdi);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0) {         //kullanıcı adı alınmış mı?
                    header("Location: ../../katilimci/katilimci_kayit.php?error=kullaniciAdiMevcut&k_adi=".$ad."&k_soyadi=".$soyad."&k_telefon=".$telefon."&k_eposta=".$eposta);
                    exit();
                }
                else {
                    $sql = "INSERT INTO katilimci (ad, soyad, telefon, eposta, universite, fakulte, bolum, sinif, k_kullanici_adi, k_sifre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt,$sql)) {     //SQL uygunluk kontrolü?
                        header("Location: ../../katilimci/katilimci_kayit.php?error=sqlHatasi");
                        exit();
                    }
                    else {
                        $hashli_sifre = password_hash($sifre, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "ssssssssss", $ad, $soyad, $telefon, $eposta, $universite, $fakulte, $bolum, $sinif ,$kullaniciAdi, $hashli_sifre);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../../katilimci/katilimci_giris.php?success=kayitBasarili");
                        exit();
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else {
        header("Location: ../../katilimci/katilimci_kayit.php");
        exit();
    }
?>

