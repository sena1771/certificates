<?php
    require "header.php";
?>
<link rel="stylesheet" href="kurumanasayfa.css">
    <main>
        <?php
            if (isset($_SESSION['svb_id'])) {
               
                    echo '<div class="x">';
                  echo '<img src=" " id="image">';
                  echo  '</div>';
            }
        ?>
        <script src="kurumanasayfa.js" ></script>
    </main>

