<?php
    require "header.php";
?>
 <link href="adminana.css" rel="stylesheet" type="text/css"/>
    <main>
        <?php
            if (isset($_SESSION['ad_id'])) {
               
                echo '<div class="x">';
                echo '<img src=" " id="image">';
                echo  '</div>';
            }
        ?>
        <script src="admin.js" ></script> 

    </main>

<?php
    require "footer.php";
?>