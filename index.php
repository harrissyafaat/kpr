<?php 
	session_start();
	error_reporting( error_reporting() & ~E_NOTICE );

// Proses Login
$breadcrum = "<li class='breadcrumb-item'>Home</li>";
	if(empty($_SESSION['kopname'])){
		header("location:login/login.php");
	}else{
		$pilih=$_GET['pilih'];
			switch($pilih){
				default 	: $tampil = "mst_isi.php"; break;
				case "1.1"	:
					$tampil = "petugas/mst_petugas.php";
					$breadcrum = "<li class='breadcrumb-item'>Master Data</li><li class='breadcrumb-item active'>Data Petugas</li>";
					break;
				case "1.2" 	:
					$tampil = "anggota/mst_anggota.php";
					$breadcrum = "<li class='breadcrumb-item'>Master Data</li><li class='breadcrumb-item active'>Data Anggota</li>";
					break;
				case "1.3" 	:
					$tampil = "anggota/mst_tabungan.php";
					$breadcrum = "<li class='breadcrumb-item'>Master Data</li><li class='breadcrumb-item active'>Data Tabungan</li>";
					break;
				case "2.1"	:
					$tampil = "transaksi/transaksi.php";
					$breadcrum = "<li class='breadcrumb-item'>Transaksi</li>";
					break;
				case "3.1" 	:
					$tampil = "laporan/laporan_anggota.php";
					$breadcrum = "<li class='breadcrumb-item'>Laporan</li><li class='breadcrumb-item active'>Data Anggota</li>";
					break;
				case "3.2" 	:
					$tampil = "laporan/laporan_simpanan.php";
					$breadcrum = "<li class='breadcrumb-item'>Laporan</li><li class='breadcrumb-item active'>Data Simpanan</li>";
					break;
				case "3.3" 	:
					$tampil = "laporan/laporan_pinjaman.php";
					$breadcrum = "<li class='breadcrumb-item'>Laporan</li><li class='breadcrumb-item active'>Data Pinjaman</li>";
					break;
				case "4.1"	:
					$tampil = "setting/setting_simpanan.php";
					$breadcrum = "<li class='breadcrumb-item'>Setting</li><li class='breadcrumb-item active'>Simpanan</li>";
					break;
				case "4.2"	:
					$tampil = "setting/setting_pinjaman.php";
					$breadcrum = "<li class='breadcrumb-item'>Setting</li><li class='breadcrumb-item active'>Pinjaman</li>";
					break;
				case "4.3"	:
					$tampil = "setting/setting_user.php";
					$breadcrum = "<li class='breadcrumb-item'>Setting</li><li class='breadcrumb-item active'>User</li>";
					break;
			} //tutup switch

			// Hitung Period Tampilan Set Hitung Bunga
			$conn = new mysqli("localhost", "root", "", "kpr");
			$tgl_sekarang = date('Y-m-d');
			$qt = mysqli_query ($conn, "SELECT DATEDIFF('$tgl_sekarang', tgl_hitung) AS tgl_hitung FROM t_bagihasil ORDER BY id DESC LIMIT 1");
			$rt = mysqli_fetch_array($qt, MYSQLI_ASSOC);
			$sel_tgl_hitung = $rt['tgl_hitung'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Jamaah Waqiah | Sunan Kalijogo Kediri</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- <link href="css/sb-admin.css" rel="stylesheet"> -->
	<link rel="shortcut icon" href="images/logo_kop.gif" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.1/themes/base/jquery-ui.css">	

  	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>	
  	<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

	<!-- <script src="vendor/jquery/jquery.js"></script> -->
	<script type="text/javascript" src="js/ddaccordion.js"></script>
	<script type="text/javascript" src="js/validasi.js"></script>
	<script type="text/javascript">
	ddaccordion.init({
		headerclass: "submenuheader", //Shared CSS class name of headers group
		contentclass: "submenu", //Shared CSS class name of contents group
		revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
		mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
		collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
		defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
		onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
		animatedefault: false, //Should contents open by default be animated into view?
		persiststate: true, //persist state of opened contents within browser session?
		toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
		togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
		animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
		oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
			//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})

	<!--jam-->
	window.setTimeout("waktu()",1000);   
    function waktu() {    
        var tanggal = new Date();   
        setTimeout("waktu()",1000);   
		document.getElementById("output").innerHTML = tanggal.getHours()+":"+tanggal.getMinutes()+":"+tanggal.getSeconds(); 
   }
</script>
</head>
<style type="text/css">
/* Firefox old*/
@-moz-keyframes blink {
    0% {
        opacity:1;
    }
    50% {
        opacity:0;
    }
    100% {
        opacity:1;
    }
} 

@-webkit-keyframes blink {
    0% {
        opacity:1;
    }
    50% {
        opacity:0;
    }
    100% {
        opacity:1;
    }
}
/* IE */
@-ms-keyframes blink {
    0% {
        opacity:1;
    }
    50% {
        opacity:0;
    }
    100% {
        opacity:1;
    }
} 
/* Opera and prob css3 final iteration */
@keyframes blink {
    0% {
        opacity:1;
    }
    50% {
        opacity:0;
    }
    100% {
        opacity:1;
    }
} 
.blink-image {
    -moz-animation: blink normal 0.7s infinite ease-in-out; /* Firefox */
    -webkit-animation: blink normal 0.7s infinite ease-in-out; /* Webkit */
    -ms-animation: blink normal 0.7s infinite ease-in-out; /* IE */
    animation: blink normal 0.7s infinite ease-in-out; /* Opera and prob css3 final iteration */
}
</style>
</head>

<body class="fixed-nav sticky-footer" id="page-top">

	<div class="header">
	<div style=" padding-left: 25px;">
		<img style="width: 50px; float: left;" src="images/logo.png">
		<div style="float: left; padding-top: 5px; padding-left: 10px;">
		Jam'iyah Waqi'ah<br> 
		<h4>Sunan Kalijogo</h4>

		</div>
			<?php
				$conn = new mysqli("localhost", "root", "", "kpr");
				$tgl_sekarang = date('Y-m-d');
				$qt = mysqli_query ($conn, "SELECT DATEDIFF('$tgl_sekarang', tgl_hitung) AS tgl_hitung FROM t_bagihasil ORDER BY id DESC LIMIT 1");
				$rt = mysqli_fetch_array($qt, MYSQLI_ASSOC);
				$sel_tgl_hitung = $rt['tgl_hitung'];

				if ($sel_tgl_hitung >= 30){
					echo "<a href=\"fungsi/hitung_bunga.php\" style=\" float: right; padding-right: 25px; \">";
					echo "<img style=\" margin-left: 13px;\" class=\"blink-image\" width=\"45px\" src=\"images/push.png\"><div style=\"font-size: 10px; color: white; margin-top: -5px;\">Hitung bunga</div>";
					// echo "string";
					echo "</a>";
				}

			?>
	</div>
	</div>
	<div class="sidebarmenu"></div>
	<div id="menutbar">
		<div class="satu">
 				<span class="label">Selamat Datang : </span> <?php echo $_SESSION['kopname'];?> &nbsp;&nbsp;
			</div>
			<div class="dua">

			<div id="output"></div></div>
	</div>

	<div class="main-content" style="min-height: 575px;">
		<div class="left-content">
			<?php include "kiri.php";?>
		</div>
		
		<div class="right-content"><?php include("$tampil");?></div>  
	</div>              
	<div class="footer"><a>@ 2017 Jam'iyah Waqi'ah Sunan Kalijogo Kediri.</a></div>

<?php
}
?>


<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="js/sb-admin.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.js"></script>
<script src="js/sb-admin-datatables.min.js"></script>

</body>
</html>
