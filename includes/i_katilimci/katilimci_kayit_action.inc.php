<?php

include '../i_database_handler/dbh.inc.php'; //veritabanı bağlantısı

if (isset($_POST['universiteId']) && !empty($_POST['universiteId'])) {

	
	$query = "SELECT * FROM yok_fakulteler WHERE universiteid = ".$_POST['universiteId'];
	$result = mysqli_query($conn, $query);

	
		echo '<option value="">Fakülte seciniz</option>'; 
		while ($row=mysqli_fetch_assoc($result)) {
			echo '<option value="'.$row['id'].'">'.$row['name'].'</option>'; 
		}
	
} elseif(isset($_POST['fakulteId']) && !empty($_POST['fakulteId'])) {

	
	$query2 = "SELECT * FROM yok_bolumler WHERE fakulteid = ".$_POST['fakulteId'];
	$result2 = mysqli_query($conn, $query2);

	
		echo '<option value="">Bölüm seciniz</option>'; 
		while ($row2=mysqli_fetch_assoc($result2)) {
			echo '<option value="'.$row2['id'].'">'.$row2['name'].'</option>'; 
		}
	
}
?>