<?php
    session_start();
    session_unset();
    session_destroy();

    header("Location:../../../admin/admin_giris.php?success=cikisBasarili");

?>