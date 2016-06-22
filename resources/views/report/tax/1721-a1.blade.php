<<!DOCTYPE html>
<html>
<head>
	<title>Form 1721-A1</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href='assets/css/stylePdf.css' rel='stylesheet' type='text/css'>
	<style type="text/css">
		div {
			position:fixed;
			font-size: 12px;
		}
	</style>
</head>
	<body class="pad-20 pad-t-none">
	    <img src="assets/images/tax/1721-a1.png" width="102%" style="position: fixed;top:30px;left:10px;">
	    <div style="top:160px;left:395px;width:70px">12</div>
	    <div style="top:160px;left:435px;width:70px">16</div>
	    <div style="top:160px;left:485px;width:70px">0000001</div>

	    <!-- NPWP PEMOTONG -->
	    <div style="top:195px;left:135px;width:70px">34.071.709.7 </div>
	    <div style="top:195px;left:345px;width:70px">497</div>
		<div style="top:195px;left:405px;width:70px">000</div>

		<!-- NAMA PEMOTONG -->
		<div style="top:220px;left:135px;width:650px">PT. Lorem ipsum dolor</div>

		<!-- =========================================
						BAGIAN A 
		============================================-->
		<!-- NPWP -->
		<div style="top:290px;left:115px;width:70px">00.000.000.0</div>
		<div style="top:290px;left:315px;width:70px">000</div>
		<div style="top:290px;left:385px;width:70px">000</div>

		<!-- NIK -->
		<div style="top:315px;left:115px;width:70px">3174041206920002</div>

		<!-- NAMA -->
		<div style="top:340px;left:115px;width:300px">Lorem ipsum dolor sit amet</div>

		<!-- ALAMAT -->
		<div style="top:360px;left:115px;width:300px;line-height: 25px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum voluptate.</div>

		<!-- JENIS KELAMIN -->
		<div style="top:420px;left:165px;width:70px;">X</div>
		<div style="top:420px;left:265px;width:70px;">X</div>

		<!-- STATUS/JUMLAH TANGGUNGAN -->
		<div style="top:315px;right:265px;width:70px;">05</div>
		<div style="top:315px;right:180px;width:70px;">05</div>
		<div style="top:315px;right:95px;width:70px;">05</div>

		<!-- NAMA JABATAN -->
		<div style="top:340px;left:565px;width:200px;text-align:left">Lorem ipsum dolor sit amet</div>

		<!-- KARYAWAN ASING -->
		<div style="top:367px;right:140px;width:70px;">X</div>

		<!-- KODE NEGARA DOMISILI -->
		<div style="top:390px;right:140px;width:70px;">IN</div>


		<!-- =========================================
						BAGIAN B
		============================================-->
		<!-- KODE OBJEK PAJAK -->
		<div style="top:495px;left:155px;width:70px;">X</div>
		<div style="top:495px;left:235px;width:70px;">X</div>

		<!-- 1 s.d 20 -->
		<?php
			$top = 537; 
			for ($i=1; $i<=20;$i++) {
		?>
			<div style="top:<?=$top?>px;right:50px;width:100px;text-align:right;">12.000.000.000.000</div>
		<?php
				if ($i==8 || $i==11) {
					$top+=40.2;
				}
				else {
					$top+=20.2;
				}
			}
		?>

		<!-- =========================================
						BAGIAN C
		============================================-->
		<!-- NPWP -->
		<div style="bottom:230px;left:125px;width:70px">34.071.709.7 </div>
	    <div style="bottom:230px;left:325px;width:70px">497</div>
		<div style="bottom:230px;left:395px;width:70px">000</div>

		<!-- NAMA -->
		<div style="bottom:200px;left:125px;width:300px">Lorem ipsum dolor.</div>

		<!-- TANGGAL -->
		<div style="bottom:200px;left:465px;width:70px">dd</div>
		<div style="bottom:200px;left:515px;width:70px">dd</div>
		<div style="bottom:200px;left:565px;width:70px">yyyy</div>
	</body>
</html>
