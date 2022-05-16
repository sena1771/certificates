<?php

    if (isset($_POST['k_etkinlik_duzenle_submit'])) {
        session_start(); //session baslangici
        require '../../i_database_handler/dbh.inc.php'; //veritabanı bağlantısı
        date_default_timezone_set('Europe/Istanbul'); //time fonksiyonlari icin server timezone belirleme

        $e_id = $_SESSION['et_id'];
        $e_adi = $_POST['e_adi'];
        $e_aciklama = $_POST['e_aciklama'];
        $e_tarih = str_replace("T", " ",$_POST['e_tarih']).":00"; //MySQL için tarih dönüşümü
        $e_yer = $_POST['e_yer'];
        $konusmacilar_explode = explode(",", $_POST['e_konusmacilar']);
        $konusmacilar_implode = $_POST['e_konusmacilar'];
        $afis_resmi = $_POST['afis_resmi'];
        $kontrol = 1;

        if (empty($e_adi) || empty($e_aciklama) || empty($e_tarih) || empty($e_yer) 
        || (empty($konusmacilar_explode[0]) && (count($konusmacilar_explode) == 1))) { //boş input kontrolü
            header("Location: ../../../kurum/anasayfa/etkinlik_duzenle.php?error=bos&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']."&etkinlik_afis_resmi=".$afis_resmi);
            exit();
        }

        if (strtotime($_POST['e_tarih']) < time()) { //girilen tarih ve zaman uygun mu?
            header("Location: ../../../kurum/anasayfa/etkinlik_duzenle.php?error=yanlisTarihZaman&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_SESSION['etkinlik_tarih']."&etkinlik_afis_resmi=".$afis_resmi);
            exit();
        }

        foreach($konusmacilar_explode as $konusmaci) { //Konuşmacılar doğru girildi mi?
            if (empty($konusmaci)) {
                header("Location: ../../../kurum/anasayfa/etkinlik_duzenle.php?error=konusmaciHatasi&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']."&etkinlik_afis_resmi=".$afis_resmi);
                exit();
            }
        }

        if ($_FILES["afis_resmi_yukle"]["error"] != 4) {
            $exploded_path = array();
            $exploded_path = explode("/", $_POST['afis_resmi']);
            $fp = unlink("../../../images/etkinlik_images/".end($exploded_path));
        
            //afis resmi upload islemi
            $dizin = "http://localhost/certificate_me/images/etkinlik_images/";
            $hedef_dosya = $dizin . basename($_FILES["afis_resmi_yukle"]["name"]); //resim dosya yolu (veritabanına eklenecek)
            $hedef_dosya2 = "../../../images/etkinlik_images/" . basename($_FILES["afis_resmi_yukle"]["name"]);
            $upload_kontrol = 1;
            $dosya_tipi = strtolower(pathinfo($hedef_dosya, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["afis_resmi_yukle"]["tmp_name"]);
            if ($check = false) { //yüklenen dosya resim mi?
                header("Location: ../../../kurum/anasayfa/etkinlik_duzenle.php?error=resimDegil&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']);
                exit();
            }

            if (file_exists($hedef_dosya2)) { //resim halihazırda var mı?
                header("Location: ../../../kurum/anasayfa/etkinlik_duzenle.php?error=resimVar&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']);
                exit();
            }

            if($dosya_tipi != "jpg" && $dosya_tipi != "png" && $dosya_tipi != "jpeg") { //dosya tipi uygun mu? (jpg, png, jpeg)
                header("Location: ../../../kurum/anasayfa/etkinlik_duzenle.php?error=dosyaTipiYanlis&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']);
                exit();
            }

            if (!move_uploaded_file($_FILES["afis_resmi_yukle"]["tmp_name"], $hedef_dosya2)) {  //Dosya yüklerken bir sorun oluştu mu?
                header("Location: ../../../kurum/anasayfa/etkinlik_duzenle.php?error=yuklemeSorunu&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']);
                exit();
            }
        }

        if ($_FILES["afis_resmi_yukle"]["error"] != 4) {
            $afis_resmi_dosya_yolu = $hedef_dosya;
        }
        else {
            $afis_resmi_dosya_yolu = $_POST['afis_resmi'];
        }

        //etkinlik güncelleme islemi
        $sql = "UPDATE etkinlik SET etkinlik_adi=?, e_aciklama=?, tarih=?, yer=?, afis_resmi=? WHERE e_id=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { //SQL uygunluk kontrolü
            header("Location: ../../../kurum/anasayfa/etkinlik_duzenle.php?error=sqlHatasi");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "sssssi",$e_adi, $e_aciklama, $e_tarih, $e_yer, $afis_resmi_dosya_yolu, $e_id);
        mysqli_stmt_execute($stmt); //etkinlik güncellendi

        //konusmaci guncelleme islemi
        $sql = "DELETE FROM `e_konusmacilar` WHERE `e_id`=".$e_id.";";
        mysqli_query($conn, $sql);
        foreach ($konusmacilar_explode as $konusmaci) {
            $sql = "INSERT INTO e_konusmacilar (e_id, konusmaci) VALUES (?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) { //SQL uygunluk kontrolü
                header("Location: ../../../kurum/anasayfa/etkinlik_duzenle.php?error=sqlHatasi");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "is", $e_id, $konusmaci);
            mysqli_stmt_execute($stmt); //konusmaci guncellendi
        }
        
        header("Location: ../../../kurum/anasayfa/etkinlik_duzenle.php?success=etkinlikGuncellemeBasarili?&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']."&etkinlik_afis_resmi=".$afis_resmi_dosya_yolu);
        exit();
    }
    else {
        header("Location: ../../../kurum/anasayfa/etkinlik_duzenle.php");
        exit();
    }
    


    
   
?>