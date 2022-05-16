<?php
    require "header.php";
?>
 
<link rel="stylesheet" href="katilimciana.css?v=<?php echo time(); ?>">

    <main>
        <?php
            if (isset($_SESSION['ka_id'])) {
                echo '<div class="x">';
              echo '<img src=" " id="image">';
              echo  '</div>';
            } 
        ?>
        
      
    </main>

    <script type="text/javascript" src="anasayfa2.js"></script>