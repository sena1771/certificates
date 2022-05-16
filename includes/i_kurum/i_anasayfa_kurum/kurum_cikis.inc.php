<?php
    session_start();
    session_unset();
    session_destroy();

    header("Location:../../../kurum/kurum_giris.php?success=cikisBasarili");

?>