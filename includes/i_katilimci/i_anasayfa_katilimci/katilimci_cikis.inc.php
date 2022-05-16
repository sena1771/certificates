<?php
    session_start();
    session_unset();
    session_destroy();

    header("Location:../../../katilimci/katilimci_giris.php?success=cikisBasarili");

?>