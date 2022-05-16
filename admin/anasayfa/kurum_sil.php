<?php
    include_once '../../includes/i_database_handler/dbh.inc.php'; //veritabanı bağlantısı

    if (isset($_POST['svb_sil_submit'])) {
        $id = $_POST['svb_id'];
        $sql = "DELETE FROM sertifika_veren_birim WHERE svb_id = ".$id;
        $result = mysqli_query($conn,$sql);
        if ($result == TRUE) {
            header("Location: kurumlariYonet.php?success=silmeBasarili");
        }
        else {
            header("Location: kurumlariYonet.php?error=silmeBasarisiz");
        }
    }
?>