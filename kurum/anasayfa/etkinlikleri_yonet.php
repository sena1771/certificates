<?php
    require "header.php";
    include_once '../../includes/i_database_handler/dbh.inc.php';
    date_default_timezone_set('Europe/Istanbul');
?>
<link rel="stylesheet" href="etkinlikyönet.css?v=<?php echo time(); ?>">

    <main>
        <a href="etkinlik_ekle.php"id="etkinlik">Etkinlik Ekle</a>
        <!-- Burada etkinlikler listelenecek. Etkinlikler üzerinde silme ve düzenleme yapılabilecek -->

        <?php
            if (isset($_GET['success'])) {
                $successCheck = $_GET['success'];
                switch ($successCheck) {
                    case 'silmeBasarili':
                        echo '<p>Silme işlemi başarı ile gerçekleşti.</p>';
                        break;
                }
            }
            else if (isset($_GET['error'])) {
                $errorCheck = $_GET['error'];
                switch ($errorCheck) {
                    case 'silmeBasarisiz':
                        echo '<p>Silme işlemi yapılırken bir sorun oluştu!</p>';
                        break;
                }
            }

           
            $svb_id = $_SESSION['svb_id'];

            $sql = "SELECT e_id FROM svb_etkinlik WHERE svb_id=".$svb_id.";";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                $query = array();
                $i = 0;
                while($row = mysqli_fetch_assoc($result)) {
                    $query[$i] = $row['e_id'];
                    $i++;
                }
                echo '<table style="text-align: center;">';
                echo '<tr>';
                echo '<th>'; echo '</th>';
                echo '<th>'; echo "Etkinlik Adı"; echo '</th>';
                echo '<th>'; echo "Açıklama"; echo '</th>';
                echo '<th>'; echo "Tarih"; echo '</th>';
                echo '<th>'; echo "Yer"; echo '</th>';
                echo '<th>'; echo "Konuşmacılar"; echo '</th>';
                echo '</tr>';
                
                foreach ($query as $e_id) {
                    echo '<tr>';
                    
                   
                    $sql = "SELECT etkinlik_adi, e_aciklama, tarih, yer, afis_resmi, e_guncel_mi FROM etkinlik WHERE e_id=".$e_id.";";
                    $result = mysqli_query($conn, $sql);
                    
                    while($row = mysqli_fetch_assoc($result)){

                        if (strtotime($row['tarih']."+2 day") < time()) {
                            $sql5 = "DELETE FROM etkinlik WHERE e_id=".$e_id; mysqli_query($conn, $sql5);
                            $sql5 = "DELETE FROM svb_etkinlik WHERE e_id=".$e_id; mysqli_query($conn, $sql5);
                            $exploded_path = array();
                            $exploded_path = explode("/", $row['afis_resmi']);
                            $fp = unlink("../../images/etkinlik_images/".end($exploded_path));
                            continue;
                        }
                        
                        if (strtotime($row['tarih']) < time()) {
                            $sql2 = "UPDATE etkinlik SET e_guncel_mi=0 WHERE e_id=".$e_id;
                            mysqli_query($conn, $sql2);
                        }
                        ?>
                        
                        <?php
                            $sql3 = "SELECT konusmaci FROM e_konusmacilar WHERE e_id=".$e_id.";";
                            $result3 = mysqli_query($conn, $sql3);
                            $dizi = array();
                            $count = 0;
                            while($row3 = mysqli_fetch_assoc($result3)) {
                                $dizi[$count] = $row3['konusmaci'];
                                $count++;
                            }
                        ?>

                        <?php
                        echo '<td>';
                        echo '<img src="'.$row['afis_resmi'].'" alt="'.$row['etkinlik_adi'].'" width="200" height="200">';
                        echo '<br>';
                        ?>
                        <table>
                            <tr>
                                <form action="etkinlik_duzenle.php" method="POST">
                                    <input type='hidden' name='etkinlik_id' value="<?php echo $e_id ?>">
                                    <input type='hidden' name='etkinlik_adi' value="<?php echo $row['etkinlik_adi'] ?>">
                                    <input type='hidden' name='etkinlik_aciklama' value="<?php echo $row['e_aciklama'] ?>">
                                    <input type='hidden' name='etkinlik_tarih' value="<?php echo $row['tarih'] ?>">
                                    <input type='hidden' name='etkinlik_yer' value="<?php echo $row['yer'] ?>">
                                    <input type='hidden' name='etkinlik_afis_resmi' value="<?php echo $row['afis_resmi'] ?>">
                                    <input type='hidden' name='etkinlik_guncel_mi' value="<?php echo $row['e_guncel_mi'] ?>">
                                    
                                    <input type='hidden' name='etkinlik_konusmacilar' value="<?php echo implode(",", $dizi) ?>">
                                    <td><button type="submit" name="e_duzenle_submit">Düzenle</button></td>
                                </form>

                                <form action="etkinlik_sil.php" method="POST">
                                    <input type='hidden' name='etkinlik_id' value="<?php echo $e_id ?>">
                                    <td><button type="submit" name="e_sil_submit">Sil</button></td>
                                </form>

                                
                            </tr>
                        </table>
                         

                            
                        

                        
                        
                        

                        <?php
                        echo '</td>';
                        ?>


                        <?php

                        echo '<td>';
                        echo '<textarea cols="30" rows="14" style="resize: none;" readonly>'.$row['etkinlik_adi'].'</textarea>';
                        echo '</td>';

                        echo '<td>';
                        echo '<textarea cols="30" rows="14" style="resize: none;" readonly>'.$row['e_aciklama'].'</textarea>';
                        echo '</td>';

                        echo '<td>';
                        echo '<textarea cols="30" rows="14" style="resize: none;" readonly>'.$row['tarih'].'</textarea>';
                        echo '</td>';

                        echo '<td>';
                        echo '<textarea cols="30" rows="14" style="resize: none;" readonly>'.$row['yer'].'</textarea>';
                        echo '</td>';


                        $sql1 = "SELECT konusmaci FROM e_konusmacilar WHERE e_id=".$e_id;
                        $result1 = mysqli_query($conn, $sql1);
                        $konusmacilar = array();
                        $tmp = 0;
                        while($row1 = mysqli_fetch_assoc($result1)) {
                            $konusmacilar[$tmp] = $row1['konusmaci'];
                            $tmp++;
                        }

                        echo '<td>';
                        echo '<textarea cols="30" rows="14" style="resize: none;" readonly>'.implode("-", $konusmacilar).'</textarea>';
                        echo '</td>';


                        if ($row['e_guncel_mi'] == 1) {
                            echo '<td>';
                            echo '<p style="color: green;">Etkinlik güncel</p>';
                            echo '</td>';
                        }
                        else if ($row['e_guncel_mi'] == 0) {
                            
                            echo '<td>';
                            echo '<p style="color: red;">Etkinlik güncel değil</p>';
                            echo '</td>';
                            
                            echo '<td>'; echo '<sub style="color: red;">--etkinlik saatinden 2 gün sonra otomatik silinecektir--</sub>'; echo '</td>';
                            
                        }

                        
                         
                    }
                    
                    
                    
                    echo '</tr>';
                }
                
                echo '</table>';
                
                
                
                
            }

            echo '<p>Etkinliğiniz bulunmamaktadır. Etkinlik eklemek için Etkinlik ekle butonuna basınız.</p>';

        ?>
    </main>

<?php
    //require "footer.php";
?>