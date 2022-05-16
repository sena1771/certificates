<?php
    include_once '../../includes/i_database_handler/dbh.inc.php'; //veritabanı bağlantısı

    if (isset($_POST['e_sil_submit'])) {
        $id = $_POST['etkinlik_id'];

        $sql = "SELECT afis_resmi FROM etkinlik WHERE e_id = ".$id;
        $result = mysqli_query($conn,$sql);
        $temp;
        while ($row = mysqli_fetch_assoc($result)) {
            $temp = $row['afis_resmi'];
        }
        $exploded_path = array();
        $exploded_path = explode("/", $temp);
        unlink("../../images/etkinlik_images/".end($exploded_path));

        $sql = "DELETE FROM etkinlik WHERE e_id = ".$id;
        mysqli_query($conn,$sql);
        
        $sql = "DELETE FROM svb_etkinlik WHERE e_id = ".$id;
        mysqli_query($conn,$sql);

        header("Location: etkinlikleri_yonet.php?success=silmeBasarili");
            
        
        
    }
?>