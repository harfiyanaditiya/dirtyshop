<?php 
include 'header.php';
$sortage = mysqli_query($conn, "SELECT * FROM produksi where cek = '1'");
$tanggal = date("Y-m-d H:i:s");
?>

<div class="container">

	<h5 class="bg-success" style="padding: 7px; width: 710px; font-weight: bold;"><marquee>Reload every time you enter this page, to avoid data and information errors</marquee></h5>

	<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col">No</th>
				<th scope="col">Invoice</th>
				<th scope="col">Customer Code</th>
				<th scope="col">Status</th>
				<th scope="col">Date</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>

			<?php 
                    $kode_cs = $_SESSION['kd_cs'];
                    $result = mysqli_query($conn, "SELECT * FROM produksi WHERE kode_customer='$kode_cs'");
                    $no = 1;
                    $array = 0;
                    while($row = mysqli_fetch_assoc($result)){
                        $kodep = $row['kode_produk'];
                        $inv = $row['invoice'];
				?>

				<tr>
					<td><?= $no; ?></td>
					<td><?= $row['invoice']; ?></td>
					<td><?= $row['kode_customer']; ?></td>
					<?php if($row['terima'] == 1){ ?>
						<td style="color: green;font-weight: bold;">Pesanan Diterima (Siap Kirim)
							<?php
						}else if($row['tolak'] == 1){
							?>
							<td style="color: red;font-weight: bold;">Pesanan Ditolak
								<?php 
							}
							if($row['terima'] == 0 && $row['tolak'] == 0){
								?>
								<td style="color: orange;font-weight: bold;"><?= $row['status']; ?>
								<?php 
							}
							$t_bom = mysqli_query($conn, "SELECT * FROM bom_produk WHERE kode_produk = '$kodep'");

							while($row1 = mysqli_fetch_assoc($t_bom)){
								$kodebk = $row1['kode_bk'];

								$inventory = mysqli_query($conn, "SELECT * FROM inventory WHERE kode_bk = '$kodebk'");
								$r_inv = mysqli_fetch_assoc($inventory);

								$kebutuhan = $row1['kebutuhan'];	
								$qtyorder = $row['qty'];
								$inventory = $r_inv['qty'];

								$bom = ($kebutuhan * $qtyorder);
								$hasil = $inventory - $bom;
								if($hasil < 0 && $row['tolak'] == 0){
									$nama_material[] = $r_inv['nama'];
									mysqli_query($conn, "UPDATE produksi SET cek = '1' where invoice = '$inv'");
									?>
									<?php 
								}
							}
							?>
						</td>
						<td><?= $row['tanggal']; ?></td>
						<td>
							<a href="detailorder.php?inv=<?= $row['invoice']; ?>&cs=<?= $row['kode_customer']; ?>" type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-eye-open"></i> Order Details</a>
						</td>
					</tr>
					<?php
					$no++; 
				}
				?>

			</tbody>
		</table>