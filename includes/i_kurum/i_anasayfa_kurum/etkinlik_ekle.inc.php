<?php

    if (isset($_POST['etkinlik_ekle_submit'])) {
        session_start(); //session baslangici
        require '../../i_database_handler/dbh.inc.php'; //veritabanı bağlantısı
        date_default_timezone_set('Europe/Istanbul'); //time fonksiyonlari icin server timezone belirleme

        $e_adi = $_POST['e_adi'];
        $e_aciklama = $_POST['e_aciklama'];
        $e_tarih = str_replace("T", " ",$_POST['e_tarih']).":00"; //MySQL için tarih dönüşümü
        $e_yer = $_POST['e_yer'];
        $konusmacilar_explode = explode(",", $_POST['konusmacilar']);
        $konusmacilar_implode = implode(",", $konusmacilar_explode);
        $kontrol = 1;

        if (empty($e_adi) || empty($e_aciklama) || empty($e_tarih) || empty($e_yer) 
        || (empty($konusmacilar_explode[0]) && (count($konusmacilar_explode) == 1)) 
        || empty($_FILES["afis_resmi"]['name'])) { //boş input kontrolü
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=bos&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']);
            exit();
        }
        
        $sql = "SELECT * FROM etkinlik WHERE etkinlik_adi=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { //SQL uygunluk kontrolü
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=sqlHatasi");
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "s", $e_adi);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) { //etkinlik halihazırda var mı?
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=etkinlikVar&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']);
            exit();
        }

        if (strtotime($e_tarih) < time()) { //girilen tarih ve zaman uygun mu?
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=yanlisTarihZaman&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode);
            exit();
        }

        $sql = "SELECT * FROM etkinlik WHERE tarih=? AND yer=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { //SQL uygunluk kontrolü
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=sqlHatasi");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss",$e_tarih, $e_yer);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) { //Aynı yerde ve aynı zamanda etkinlik var mı?
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=yerZamanAyni&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&konusmacilar_implode=".$konusmacilar_implode);
            exit();
        }

        foreach($konusmacilar_explode as $konusmaci) { //Konuşmacılar doğru girildi mi?
            if (empty($konusmaci)) {
                header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=konusmaciHatasi&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']);
                exit();
            }
        }

        //afis resmi upload islemi
        $dizin = "http://localhost/certificate_me/images/etkinlik_images/"; 
        $hedef_dosya = $dizin . basename($_FILES["afis_resmi"]["name"]); //resim dosya yolu (veritabanına eklenecek)
        $hedef_dosya2 = "../../../images/etkinlik_images/" . basename($_FILES["afis_resmi"]["name"]);
        $upload_kontrol = 1;
        $dosya_tipi = strtolower(pathinfo($hedef_dosya, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["afis_resmi"]["tmp_name"]);
        if ($check = false) { //yüklenen dosya resim mi?
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=resimDegil&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']);
            exit();
        }
        
        if (file_exists($hedef_dosya2)) { //resim halihazırda var mı?
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=resimVar&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']);
            exit();
        }
        
        if($dosya_tipi != "jpg" && $dosya_tipi != "png" && $dosya_tipi != "jpeg") { //dosya tipi uygun mu? (jpg, png, jpeg)
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=dosyaTipiYanlis&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']);
            exit();
        }

        if (!move_uploaded_file($_FILES["afis_resmi"]["tmp_name"], $hedef_dosya2)) {  //Dosya yüklerken bir sorun oluştu mu?
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=yuklemeSorunu&e_adi=".$e_adi."&e_aciklama=".$e_aciklama."&e_yer=".$e_yer."&konusmacilar_implode=".$konusmacilar_implode."&e_tarih=".$_POST['e_tarih']);
            exit();
        }

        //etkinlik ekleme islemi
        $sql = "INSERT INTO etkinlik (etkinlik_adi, e_aciklama, tarih, yer, afis_resmi, e_guncel_mi) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { //SQL uygunluk kontrolü
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=sqlHatasi");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "sssssi",$e_adi, $e_aciklama, $e_tarih, $e_yer, $hedef_dosya, $kontrol);
        mysqli_stmt_execute($stmt); //etkinlik eklendi

        $sql = "SELECT * FROM etkinlik WHERE etkinlik_adi=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { //SQL uygunluk kontrolü
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=sqlHatasi");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $e_adi); 
        mysqli_stmt_execute($stmt); //etkinlik döndürüldü
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        $e_id = $row['e_id']; //eklenen etkinliğin "etkinlik ID" si alındı

        //konusmaci ekleme islemi
        foreach ($konusmacilar_explode as $konusmaci) {
            $sql = "INSERT INTO e_konusmacilar (e_id, konusmaci) VALUES (?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) { //SQL uygunluk kontrolü
                header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=sqlHatasi");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "is", $e_id, $konusmaci);
            mysqli_stmt_execute($stmt); //konusmaci eklendi
        }
        
        //kurum ile etkinliği bağlama işlemi
        $kurum_id = $_SESSION['svb_id'];
        $sql = "INSERT INTO svb_etkinlik (svb_id, e_id) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { //SQL uygunluk kontrolü
            header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=sqlHatasi");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ii", $kurum_id, $e_id);
        mysqli_stmt_execute($stmt); //kurum-etkinlik bağlantısı yapıldı

        //Diger kurumlar ile etkinliği bağlama işlemi
        if (isset($_POST['diger_kurumlar'])) {
            $diger_kurumlar = $_POST['diger_kurumlar'];
            foreach ($diger_kurumlar as $diger_kurum) {
                $sql = "INSERT INTO svb_etkinlik (svb_id, e_id) VALUES (?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) { //SQL uygunluk kontrolü
                    header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?error=sqlHatasi");
                    exit();
                }
                mysqli_stmt_bind_param($stmt, "ii", $diger_kurum, $e_id);
                mysqli_stmt_execute($stmt); //diğer kurumlar-etkinlik bağlantısı yapıldı
            }
        }


        header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php?success=etkinlikEklemeBasarili");
        exit();
    }
    else {
        header("Location: ../../../kurum/anasayfa/etkinlik_ekle.php");
        exit();
    }
    


    
   
?>








