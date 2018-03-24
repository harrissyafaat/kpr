<?php
	include "config/conn.php";
	include "fungsi/fungsi.php";

	$aksi=$_GET['aksi'];
	$kategori = ($kategori=$_POST['kategori'])?$kategori : $_GET['kategori'];
	$cari = ($cari = $_POST['input_cari'])? $cari: $_GET['input_cari'];
?>

<head>
<script language="JavaScript">
	$(document).ready(function(){
		$(function() {
			$( '#tanggal' ).datepicker({
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				changeYear: true
			});
			$( '#tgl_masuk' ).datepicker({
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				changeYear: true
			});
		});
	});
</script>
</head>

<?php
	if(empty($aksi)){
?>
<body>
	<div class="card mb-3" style="width: 970px; margin-top: 10px;">
	        <div class="card-header">
	          <i class="fa fa-table"></i> Data Petugas
			<a style="float: right;" href="?pilih=1.2&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
	      </div>
	        <div class="card-body">
	<div class="table-responsive">
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
			<tr>
       <th>No</th>
       <th>Kode Anggota</th>
       <th>Nama Anggota</th>
       <th>Pekerjaan</th>
       <th>Tanggal Masuk</th>
       <th>Aksi</th>
       </tr>
    </thead>
		<tfoot>
			<tr>
       <th>No</th>
       <th>Kode Anggota</th>
       <th>Nama Anggota</th>
       <th>Pekerjaan</th>
       <th>Tanggal Masuk</th>
       <th>Aksi</th>
       </tr>
    </tfoot>
		<tbody>
<?php

			$query=mysqli_query($koneksi, "SELECT * FROM t_anggota
								ORDER BY kode_anggota ASC");
		$no=1;

	while($data=mysqli_fetch_array($query, MYSQLI_ASSOC)){
?>

    	<tr>
			<td><?php echo $no++;?></td>
            <td><?php echo $data['kode_anggota'];?></td>
            <td><?php echo $data['nama_anggota'];?></td>
            <td><?php echo $data['pekerjaan'];?></td>
            <td><?php echo Tgl($data['tgl_masuk']);?></td>
            <td>
	<a class="btn btn-primary" href=index.php?pilih=1.2&aksi=ubah&kode_anggota=<?php echo $data['kode_anggota'];?>><i class="fa fa-edit"></i></a>
  <a class="btn btn-danger" href=index.php?pilih=1.2&aksi=hapus&kode_anggota=<?php echo $data['kode_anggota'];?>><i class="fa fa-trash"></i></a>
	<a class="btn btn-success" href=index.php?pilih=1.2&aksi=cetak&kode_anggota=<?php echo $data['kode_anggota'];?>><i class="fa fa-print"></i></a>
			</td>
        </tr>

<?php
	} //tutup while
?>
</tbody>
</table>
</div>
</div>
</div>


<?php
	}elseif($aksi=='tambah'){
		$query=mysqli_query($koneksi, "SELECT * FROM t_jenis_simpan WHERE kode_jenis_simpan='S0001'");
		$data=mysqli_fetch_array($query, MYSQLI_ASSOC);
?>

<div class="row">
  <div class="col-12">
<div class="card mb-3" style="width: 970px; margin-top: 10px;">
  <div class="card-header">
    <i class="fa fa-plus"></i> Tambah Data Anggota</div>
  <div class="card-body">
<form action="anggota/proses_anggota.php?pros=tambah" method="post" id="form" enctype="multipart/form-data">
<fieldset>
	<div class="form-group row">
		<label for="kode_anggota" class="col-sm-3 col-form-label">Kode Anggota </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="kode_anggota" size="54" value="<?php echo nomer("A","kode_anggota","t_anggota	");?>" readonly title="Kode harus diisi"/>
	</div>
	</div>
    <?php
    	$kode = nomer("A","kode_anggota","t_anggota	");
    ?>
		<div class="form-group row">
			<label for="tgl_masuk" class="col-sm-3 col-form-label">Tanggal Masuk </label>
	<div class="col-sm-7">
			<input class="form-control" type="text" name="tgl_masuk" size="54" id="tgl_masuk" class="required" title="Tanggal Masuk harus diisi">
	</div>
		</div>
		<div class="form-group row">
			<label for="simpanan_pokok" class="col-sm-3 col-form-label">Simpanan Pokok </label>
	<div class="col-sm-7">
			<input class="form-control" type="text" name="simpanan_pokok" size="54" id="simpanan_pokok" class="required" readonly="" value="<?php echo $data['besar_simpanan'];?>">
	</div>
		</div>
		<div class="form-group row">
			<label for="nama_anggota" class="col-sm-3 col-form-label">Nama Lengkap </label>
	<div class="col-sm-7">
			<input class="form-control" type="text" name="nama_anggota" size="54" class="required" title="Nama harus diisi"/>
	</div>
		</div>
		<div class="form-group row">
			<label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin </label>
	<div class="col-sm-7">
			<input type="radio" name="jenis_kelamin" value="Laki-laki" class="col-form-label required" title="Jenis Kelamin harus diisi"/> Laki-laki
			<input type="radio" name="jenis_kelamin" value="Perempuan" class="col-form-label required" title="Jenis Kelamin harus diisi"/> Perempuan
	</div>
		</div>
		<div class="form-group row">
			<label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat / Tgl Lahir </label>
	<div class="col-sm-4">
			<input class="form-control" type="text" name="tempat_lahir" class="required" title="Tempat Lahir harus diisi" /> 
	</div>
	<div class="col-form-label">/
	</div>	
	<div class="col-sm-3">
			<input class="form-control" type="text" name="tgl_lahir" id="tanggal" class="required" title="Tanggal Lahir harus diisi">
	</div>
		</div>
		<div class="form-group row">
			<label for="alamat_anggota" class="col-sm-3 col-form-label">Alamat Anggota </label>
	<div class="col-sm-7">
			<textarea class="form-control" name="alamat_anggota" id="alamat_anggota" rows="5" cols="41" class="required" title="Alamat harus diisi"></textarea>
	</div>
		</div>
		<div class="form-group row">
			<label for="no_identitas" class="col-sm-3 col-form-label">No KTP/SIM </label>
	<div class="col-sm-7">
			<input class="form-control" type="text" name="no_identitas" size="54" class="required" title="No Identitas harus diisi"/>
	</div>
		</div>
		<div class="form-group row">
			<label for="telp" class="col-sm-3 col-form-label">Telepon </label>
	<div class="col-sm-7">
			<input class="form-control" type="text" name="telp" size="54" class="required" title="Telepon harus diisi"/>
	</div>
		</div>
		<div class="form-group row">
			<label for="pekerjaan" class="col-sm-3 col-form-label">Pekerjaan </label>
	<div class="col-sm-7">
			<input class="form-control" type="text" name="pekerjaan" size="54" class="required" title="Pekerjaan harus diisi" />
	</div>
		</div>
		<div class="form-group row">
			<label for="user_entri" class="col-sm-3 col-form-label">User Entri </label>
	<div class="col-sm-7">
			<input class="form-control" type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly >
	</div>
		</div>
		<div class="form-group row">
			<label for="tgl_entri" class="col-sm-3 col-form-label">Tanggal Entri </label>
	<div class="col-sm-7">
			<input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/>
	</div>
		</div>
		<div class="form-group row text-center">
	<div class="col-sm-7">
			<input class="btn btn-primary" type="submit" name="daftar" id="button1" value="Daftar" onClick="cetak_baru();" />
			<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
		</div>
</fieldset>
</form>
</div>
</div>
</div>

<?php
	}elseif($aksi=='ubah'){
		$kode=$_GET['kode_anggota'];
		$qubah=mysqli_query($koneksi, "SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data2=mysqli_fetch_array($qubah, MYSQLI_ASSOC);
?>

<div class="row">
  <div class="col-12">
<div class="card mb-3" style="width: 970px; margin-top: 10px;">
  <div class="card-header">
    <i class="fa fa-plus"></i> Ubah Data Anggota</div>
  <div class="card-body">
<form action="anggota/proses_anggota.php?pros=ubah" method="post" id="form" enctype="multipart/form-data">
<fieldset>
	<div class="form-group row">
		<label for="kode_anggota" class="col-sm-3 col-form-label">Kode Anggota </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="kode_anggota" size="54" value="<?php echo $data2['kode_anggota'];?>" readonly=""/>
	</div>
	</div>
	<div class="form-group row">
		<label for="tgl_masuk" class="col-sm-3 col-form-label">Tanggal Masuk </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="tgl_masuk" size="54" id="tgl_masuk" value="<?php echo $data2['tgl_masuk'];?>">
	</div>
	</div>
	<div class="form-group row">
		<label for="nama_anggota" class="col-sm-3 col-form-label">Nama Lengkap </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="nama_anggota" size="54" value="<?php echo $data2['nama_anggota'];?>"/>
	</div>
	</div>
	<div class="form-group row">
		<label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin </label>
	<div class="col-sm-7">
		<?php
			if ($data2['jenis_kelamin'] == "Laki-laki"){
				echo "<input type='radio' name='jenis_kelamin' value='Laki-laki' checked>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan'>Perempuan";
			}else if ($data2['jenis_kelamin'] == "Perempuan"){
				echo "<input type='radio' name='jenis_kelamin' value='Laki-laki'>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' checked>Perempuan";
			}
		?>
	</div>
	</div>
	<div class="form-group row">
		<label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat / Tanggal Lahir </label>
	<div class="col-sm-4">
		<input class="form-control" type="text" name="tempat_lahir" size="26" value="<?php echo $data2['tempat_lahir'];?>"/>
	</div>
	<div class="col-form-label">
	 / 
	</div>
	<div class="col-sm-3">
	<input class="form-control" type="text" name="tgl_lahir" size="21" value="<?php echo $data2['tgl_lahir'];?>">
	</div>
	</div>
	
	<div class="form-group row">
		<label for="alamat_anggota" class="col-sm-3 col-form-label">Alamat Anggota </label>
	<div class="col-sm-7">
		<textarea class="form-control" name="alamat_anggota" id="alamat_anggota" rows="5" cols="41"><?php echo $data2['alamat_anggota'];?></textarea>
	</div>
	</div>
	<div class="form-group row">
		<label for="no_identitas" class="col-sm-3 col-form-label">No KTP/SIM </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="no_identitas" size="54" value="<?php echo $data2['no_identitas'];?>"/>
	</div>
	</div>
	<div class="form-group row">
		<label for="telp" class="col-sm-3 col-form-label">Telepon </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="telp" size="54" value="<?php echo $data2['telp'];?>"/>
	</div>
	</div>
	<div class="form-group row">
		<label for="pekerjaan" class="col-sm-3 col-form-label">Pekerjaan </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="pekerjaan" size="54" value="<?php echo $data2['pekerjaan'];?>"/>
	</div>
	</div>
	<div class="form-group row">
		<label for="photo" class="col-sm-3 col-form-label">Foto </label>
	<div class="col-sm-7">
		<input class="form-control" type="file" name="photo" value="<?php echo $data2['photo'];?>"/>
	</div>
	</div>
	<div class="form-group row">
		<label for="user_entri" class="col-sm-3 col-form-label">User Entri </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="user_entri" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly >
	</div>
	</div>
	<div class="form-group row">
		<label for="tgl_entri" class="col-sm-3 col-form-label">Tanggal Entri </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly />
	</div>
	</div>
	<div class="form-group row text-center">
	<div class="col-sm-7">
		<input class="btn btn-primary" type="submit" name="ubah" id="button1" value="Ubah" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
	</div>
</fieldset>
</form>
</div>
</div>
</div>

<?php
	}

	elseif($aksi=='hapus'){
		$kode = $_GET['kode_anggota'];
		$qhapus=mysqli_query($koneksi, "SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data2=mysqli_fetch_array($qhapus, MYSQLI_ASSOC);
?>

<div class="row">
  <div class="col-12">
<div class="card mb-3" style="width: 970px; margin-top: 10px;">
  <div class="card-header">
    <i class="fa fa-plus"></i> Hapus Data Anggota</div>
  <div class="card-body">
<form action="anggota/proses_anggota.php?pros=hapus" method="post" id="form">
<h4 id="adduser">Data Pribadi</h4>
<fieldset>
	<div class="form-group row">
		<label for="kode_anggota" class="col-sm-3 col-form-label">Kode Anggota </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="kode_anggota" size="54" value="<?php echo $data2['kode_anggota'];?>" readonly=""/>
	</div>
	</div>
	<div class="form-group row">
		<label for="tgl_masuk" class="col-sm-3 col-form-label">Tanggal Masuk </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="tgl_masuk" size="54" id="tgl_masuk" value="<?php echo $data2['tgl_masuk'];?>" readonly>
	</div>
	</div>
	<div class="form-group row">
		<label for="nama_anggota" class="col-sm-3 col-form-label">Nama Lengkap </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="nama_anggota" size="54" value="<?php echo $data2['nama_anggota'];?>" readonly/>
	</div>
	</div>
	<div class="form-group row">
		<label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin </label>
	<div class="col-sm-7">
		<?php
			if ($data2['jenis_kelamin'] == "Laki-laki"){
				echo "<input type='radio' name='jenis_kelamin' value='Laki-laki' checked>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' readonly>Perempuan";
			}else if ($data2['jenis_kelamin'] == "Perempuan"){
				echo "<input type='radio' name='jenis_kelamin' value='Laki-laki'>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' checked readonly>Perempuan";
			}
		?>
	</div>
	</div>
	<div class="form-group row">
		<label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat / Tanggal Lahir </label>
	<div class="col-sm-3">
		<input class="form-control" type="text" name="tempat_lahir" size="26" value="<?php echo $data2['tempat_lahir'];?>" readonly/> 
	</div>
	<div class="col-form-label">
		/ 
	</div>
	<div class="col-sm-3">
	<input class="form-control" type="text" name="tgl_lahir" size="21" value="<?php echo $data2['tgl_lahir'];?>" readonly>
	</div>
	</div>
	<div class="form-group row">
		<label for="alamat_anggota" class="col-sm-3 col-form-label">Alamat Anggota </label>
	<div class="col-sm-7">
		<textarea class="form-control" name="alamat_anggota" id="alamat_anggota" rows="5" cols="41" readonly><?php echo $data2['alamat_anggota'];?></textarea>
	</div>
	</div>
	<div class="form-group row">
		<label for="no_identitas" class="col-sm-3 col-form-label">No KTP/SIM </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="no_identitas" size="54" value="<?php echo $data2['no_identitas'];?>" readonly/>
	</div>
	</div>
	<div class="form-group row">
		<label for="telp" class="col-sm-3 col-form-label">Telepon </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="telp" size="54" value="<?php echo $data2['telp'];?>" readonly/>
	</div>
	</div>
	<div class="form-group row">
		<label for="pekerjaan" class="col-sm-3 col-form-label">Pekerjaan </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="pekerjaan" size="54" value="<?php echo $data2['pekerjaan'];?>" readonly/>
	</div>
	</div>
	<div class="form-group row">
		<label for="user_entri" class="col-sm-3 col-form-label">User Entri </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="user_entri" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly >
	</div>
	</div>
	<div class="form-group row">
		<label for="tgl_entri" class="col-sm-3 col-form-label">Tanggal Entri </label>
	<div class="col-sm-7">
		<input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly />
	</div>
	</div>
	<div class="form-group row text-center">
	<div class="col-sm-7">
		<input class="btn btn-primary" type="submit" name="hapus" id="button1" value="Hapus" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
	</div>
</fieldset>
</form>
</div>
</div>
</div>

<?php
}elseif($aksi=='cetak'){
$kode=$_GET['kode_anggota'];
$query=mysqli_query($koneksi, "SELECT *
					FROM t_anggota
					WHERE kode_anggota = '$kode'");
$data=mysqli_fetch_array($query, MYSQLI_ASSOC);
?>
<table>
	<tr>
		<td rowspan="2" align="center"><img src="logo_kop.gif" width="50" height="45" /></td>
		<td colspan="3">Jam'iyah Waqi'ah "Sunan Kalijogo"</td>
	</tr>
	<tr>
		<td colspan="3">Jln. Puspogiwangan Dalam I No. 20 Semarang</td>
	</tr>
	 <tr>
		<td colspan="4"><hr /><hr /></td>
	</tr>
	<tr>
		<td>No Anggota</td>
		<td>:</td>
		<td><?php echo $data['kode_anggota'];?></td>
		<td rowspan="4"><?php echo $data['photo'];?></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><?php echo $data['nama_anggota'];?></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><?php echo $data['alamat_anggota'];?></td>
	</tr>
	<tr>
		<td>Tanggal Masuk</td>
		<td>:</td>
		<td><?php echo $data['tgl_masuk'];?></td>
	</tr>
</table><br />
<input type="button" value="Cetak Kartu Anggota" onclick="cetak();" title="cetak kartu anggota" name="" style="float: right; margin-right: 100px; width: 200px; height: 30px;">
<?php
	}
?>
<script type="text/javascript">
	function cetak(){
		controlWindow=window.open("anggota/kartuAnggota.php?kode_anggota=<?php echo $kode ?>","","toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,width=650,height=550");
	}
	function cetak_baru(){
		controlWindow=window.open("anggota/kartuAnggota.php?kode_anggota=<?php echo nomer("A","kode_anggota","t_anggota	"); ?>","","toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,width=650,height=550");
	}
</script>
