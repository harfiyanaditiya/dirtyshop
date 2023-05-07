<?php 
include '../../koneksi/koneksi.php';
$inv = $_GET['inv'];
$tolak = mysqli_query($conn, "UPDATE produksi set terima = '1', tolak='2' WHERE invoice = '$inv'");

if($tolak){
	echo "
	<script>
	alert('PESANAN DITERIMA');
	window.location = '../produksi.php';
	</script>
	";
}

?>