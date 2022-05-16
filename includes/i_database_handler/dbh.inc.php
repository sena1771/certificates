<?php
    //local veritabanı bağlantısı
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "certificate_me";

    $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

    if (!$conn) {
        die("Veritabani ile baglanti kurulamadi\nError code: ".mysqli_connect_error());
    }

    
    //Heroku ClearDB bağlantı bilgilerini al
    /*$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $cleardb_server = $cleardb_url["host"];
    $cleardb_username = $cleardb_url["user"];
    $cleardb_password = $cleardb_url["pass"];
    $cleardb_db = substr($cleardb_url["path"],1);
    $active_group = 'default';
    $query_builder = TRUE;
    // veritabanına bağlan
    $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);*/
    
    //karakter setini düzenle
    mysqli_set_charset($conn, "utf8");


?>

