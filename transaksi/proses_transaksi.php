<?php
	include "../config/conn.php";


$kode_anggota		= $_POST['kode_anggota'];
// SIMPAN
$kode_simpan		= $_POST['kode_simpan'];
$tgl_simpan			= $_POST['tgl_simpan'];
$kode_jenis_simpan	= $_POST['kode_jenis_simpan'];
$nominal			= $_POST['nominal'];
$u_entry			= $_POST['u_entry'];
$tgl_entri			= $_POST['tgl_entri'];
$jenis_transaksi	= $_POST['jenis_transaksi'];

if ($jenis_transaksi == 'pinjam'){
	$kode_jenis_transaksi = 2;
} else {
	$kode_jenis_transaksi = $kode_jenis_simpan;
}

// PINJAM
$kode_pinjam		= $_POST['kode_pinjam'];
$tgl_pinjam			= $_POST['tgl_pinjam'];
$kode_jenis_pinjam	= $_POST['kode_jenis_pinjam'];
$besar_pinjaman		= $_POST['besar_pinjaman'];
$besar_angsuran		= $_POST['besar_angsuran'];
$lama_angsuran		= $_POST['lama_angsuran'];
$u_entry			= $_POST['u_entry'];
$tgl_entri			= $_POST['tgl_entri'];

// ANGSUR
$kode_angsur		= $_POST['kode_angsur'];
$tgl_angsur			= $_POST['tgl_angsur'];
$angsuran_ke		= $_POST['angsuran_ke'];
$sisa_angsuran		= $_POST['sisa_angsuran'];
$sisa_pinjaman		= $_POST['sisa_pinjaman'];
$u_entry			= $_POST['u_entry'];
$tgl_entri			= $_POST['tgl_entri'];

$pros=$_GET['pros'];

if($pros=="simpan" || $pros=="pinjam"){
	$q = mysqli_query ($koneksi, "SELECT T.besar_tabungan, A.kode_tabungan
					FROM t_tabungan AS T, t_anggota AS A
					WHERE T.kode_tabungan = A.kode_tabungan
					AND A.kode_anggota = '$kode_anggota'");

	$data = mysqli_fetch_array($q, MYSQLI_ASSOC);
	$tb = new Tabungan($data['besar_tabungan']);

} elseif($pros=="angsur"){
	$q = mysqli_query ($koneksi, "SELECT T.besar_tabungan, A.kode_tabungan
					FROM t_tabungan T, t_anggota A
					WHERE T.kode_tabungan = A.kode_tabungan
					AND A.kode_anggota = '$kode_anggota'");
	$data=mysqli_fetch_array($q, MYSQLI_ASSOC);
	$tb = new Tabungan($data['besar_tabungan']);

	$qu = mysqli_query ($koneksi, "SELECT * FROM t_pinjam WHERE kode_anggota='$kode_anggota' AND kode_pinjam='$kode_pinjam'");
	$data2=mysqli_fetch_array($qu, MYSQLI_ASSOC);

	$sisang = $data2['lama_angsuran'] - $angsuran_ke;
	$sipin	= $data2['sisa_pinjaman'] - $besar_angsuran;
}

	switch($pros){
		case "simpan"	:	$tb->simpan($besar_simpanan);
					  		$saldo_baru = $tb->cek_saldo();

					  		if ($jenis_transaksi == 'pinjam'){
					  			$nominal = 0 - $nominal;
					  		}

					  		$sq = mysqli_query ($koneksi, "SELECT sum(besar_simpanan) AS total_saldo FROM t_simpan WHERE kode_anggota='$kode_anggota' AND status='1'");
						  	$d = mysqli_fetch_array($sq, MYSQLI_ASSOC);
						  	$total_saldo = $d['total_saldo'];

							$qtambah = mysqli_query ($koneksi, "INSERT INTO t_simpan (kode_simpan, kode_jenis_simpan, kode_anggota, tgl_simpan, besar_simpanan, u_entry, tgl_entri) VALUES('','$kode_jenis_transaksi','$kode_anggota','$tgl_simpan','$nominal','$u_entry','$tgl_entri')");

							$q = mysqli_query ($koneksi, "UPDATE t_tabungan SET besar_tabungan = '$saldo_baru'
					  						WHERE kode_tabungan='$data[kode_tabungan]'");

							echo "<script>var txt;var r=confirm('Cetak hasil?');if (r==false){window.location = '../index.php?pilih=2.1';}else{window.location = '../tandabukti/cetak_buku.php?kode_anggota=".$kode_anggota."&jenis_transaksi=simpan&saldo=".$total_saldo."';}</script>";
							break;

		case "pinjam"	:	$sq = mysqli_query ($koneksi, "SELECT sum(sisa_pinjaman) AS total_saldo FROM 					t_pinjam WHERE kode_anggota='$kode_anggota'");
						  	$d = mysqli_fetch_array($sq, MYSQLI_ASSOC);
						  	$total_saldo = $d['total_saldo'];

							$tb->pinjam($besar_pinjaman);
							$saldo_baru = $tb->cek_saldo();
							$qtambah = mysqli_query ($koneksi, "INSERT INTO t_pinjam
							VALUES('','$kode_anggota','$kode_jenis_pinjam','$tgl_pinjam','$besar_pinjaman','$besar_pinjaman','$besar_angsuran','$lama_angsuran','$lama_angsuran','$u_entry','$tgl_entri','0')");
							$q = mysqli_query ($koneksi, "UPDATE t_tabungan SET besar_tabungan = '$saldo_baru'
							 				WHERE kode_tabungan='$data[kode_tabungan]'");

							echo "<script>var txt;var r=confirm('Cetak hasil?');if (r==false){window.location = '../index.php?pilih=2.1';}else{window.location = '../tandabukti/cetak_buku.php?kode_anggota=".$kode_anggota."&jenis_transaksi=pinjam&saldo=".$total_saldo."';}</script>";
							break;

		case "angsur"	:
							$sq = mysqli_query ($koneksi, "SELECT sum(sisa_pinjaman) AS total_saldo FROM t_pinjam WHERE kode_anggota='$kode_anggota'");
						  $d = mysqli_fetch_array($sq, MYSQLI_ASSOC);
						  $total_saldo = $d['total_saldo'];

							$tb = new Tabungan($data['besar_angsuran']);
							$tb->simpan($besar_angsuran);
					  		$saldo_baru = $tb->cek_saldo();

							//INSERT data angsur
							$qtambah = mysqli_query($koneksi, "INSERT INTO t_angsur VALUES('','$kode_pinjam','$kode_anggota','$tgl_angsur','$besar_angsuran','$angsuran_ke','$u_entry','$tgl_entri', '0')");

							$qubah = mysqli_query($koneksi, "UPDATE t_pinjam SET sisa_angsuran = '$sisang', sisa_pinjaman = '$sipin' WHERE kode_pinjam='$kode_pinjam'");
							$q = mysqli_query($koneksi, "UPDATE t_tabungan SET besar_tabungan = '$saldo_baru'
											WHERE kode_tabungan='$data[kode_tabungan]'");

							echo "<script>var txt;var r=confirm('Cetak hasil?');if (r==false){window.location = '../index.php?pilih=2.1';}else{window.location = '../tandabukti/cetak_buku.php?kode_anggota=".$kode_anggota."&jenis_transaksi=angsur&saldo=".$total_saldo."';}</script>";
							break;
		case "hapus" :
			$kode_simpan = $_GET['kode_simpan'];
			$kode_pinjam = $_GET['kode_pinjam'];
			$kode_angsur = $_GET['kode_angsur'];
			if ($kode_simpan != ""){
				$qhapus = mysqli_query ($koneksi, "DELETE FROM t_simpan WHERE kode_simpan='$kode_simpan'");
				if ($qhapus){
					echo "<script>alert('Data Berhasil Dihapus'); self.history.back();</script>";
				} else {
					echo "<script>alert('Data Gagal Dihapus'); self.history.back();</script>";
				}
			} else if ($kode_pinjam != "") {
				$qhapus = mysqli_query ($koneksi, "DELETE FROM t_pinjam WHERE kode_pinjam='$kode_pinjam'");
				if ($qhapus){
					echo "<script>alert('Data Berhasil Dihapus'); self.history.back();</script>";
				} else {
					echo "<script>alert('Data Gagal Dihapus'); self.history.back();</script>";
				}
			} else if ($kode_angsur != "") {
				$qhapus = mysqli_query ($koneksi, "DELETE FROM t_angsur WHERE kode_angsur='$kode_angsur'");
				if ($qhapus){
					echo "<script>alert('Data Berhasil Dihapus'); self.history.back();</script>";
				} else {
					echo "<script>alert('Data Gagal Dihapus'); self.history.back();</script>";
				}
			}

			break;
	}
?>
