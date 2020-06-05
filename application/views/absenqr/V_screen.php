<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo (isset($page_title)) ? $page_title.' - '.APP_NAME : APP_NAME ?></title>

	<link rel="icon" href="<?php echo base_url(THEME_PATH) ?>favicon.ico">
	<link rel="stylesheet" type="text/css" href="<?= base_url(THEME_PATH); ?>vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(THEME_PATH); ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(THEME_PATH); ?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(THEME_PATH); ?>vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(THEME_PATH); ?>vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(THEME_PATH); ?>vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(THEME_PATH); ?>vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(THEME_PATH); ?>vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(THEME_PATH); ?>css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(THEME_PATH); ?>css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

	<style type="text/css">
		.login100-more {
  			width: calc(100% - 460px);
  		}
  		.login100-form {
  			width: 460px;
  			background-color: #fff;
			padding: 20px 15px 5px 15px;
  		}
		#img-qr img {
			padding: 10px;
			background: #FFF;
		}
	</style>
</head>
<body style="background-color: #666666;">	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form">
					<p><center>
						<img src="<?= base_url(THEME_PATH); ?>images/logo_head.png" alt="Image" width="70px">
						<h5>PT. Pelayaran Nasional Indonesia (Persero)</h5>
					</center></p>
					<span class="login100-form-title p-b-15 p-t-10">
						<h4><b>Absensi Pegawai</b></h4>
						<hr style="padding:0;margin-top:20px">
					</span>
					<div class="table-res"><center>Belum Ada Absen Pegawai</center></div>
				</form>

				<div class="login100-more" style="background-image: url('<?= base_url(THEME_PATH);?>images/background/4.jpg');">
					<div class="row">&nbsp;</div>
					<span class="login100-form-title p-b-25">
						<h1><b style="color: rgba(255, 255, 255, 5.8);"><?= $nama ?></b></h1>
						<h4 style="color: rgba(255, 255, 255, 5.8); " id="date"></h4>
						<h5 class="col align-self-center">
							<b style="color: rgba(255, 255, 255, 5.8); ">
								<center><h1 id="time"></h1></center>
							</b>
						</h5>
					</span>
					<div class="row">
						</div>
					<!-- <div class="row">&nbsp;</div> -->
					<div class="row">
						<h5 class="col align-self-center">
							<b style="color: rgba(255, 255, 255, 5.8); ">
								<center>(SCAN DISINI UNTUK ABSENSI)</center><br>
							</b>
						</h5>
					</div>
					<div class="row">
						<div class="col align-self-center">
							<center><div id="img-qr"></div></center>
						</div>	
						<? if($pesan){ ?>
						<div id="footer">
							<marquee><b style="font-size:14px"><?= $pesan ?></b></marquee>
						</div>
						<? } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		var base_url 	= '<?= base_url() ?>';
		var screen_id	= '<?= $screen_id ?>';
		var token 		= '<?= WS_AUTH_KEY ?>';
		var url_trigger = '<?= WS_URL.'ws_absenqr/get_status_change' ?>';
		var url_qr 		= '<?= WS_URL.'ws_absenqr/get_new_qr' ?>';
	</script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/animsition/js/animsition.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/bootstrap/js/popper.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/select2/select2.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/daterangepicker/daterangepicker.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/countdowntime/countdowntime.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>dist/js/pages/absenqr/qrcode.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>dist/js/pages/absenqr/screen.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>js/main.js"></script>
	<script>
		var i = 0;
		var img = ['4.jpg','5.jpg','6.jpg','7.jpg','8.jpg','9.jpg'];
		var opacity = 1;
		var incOpacity = 1; 
		var delay = 1000;

		// fungsi ganti gambar
		function changeBg() {
			opacity = 1;
			incOpacity = 1;

		    $('#FadeInOut').css("opacity", opacity);
		    $('#FadeInOut').css("background-image", "url(<?= base_url(THEME_PATH); ?>images/background/" + img[i] + " )");

		    i++;
		    // cek if i = max
		    if(i == img.length) {
		        i = 0;
		    }

		    fadeIn();

		    setTimeout(changeBg, 5000);
		}
		// fungsi effek fade 
		function fadeIn() { 
			opacity = incOpacity / delay; 
			if(incOpacity <= delay) {
				$('.header').css("opacity", opacity); 
			    setTimeout(fadeIn, 100);
			    incOpacity++; 
			} 
		}
		        // inisialisai fungsi gambar
		changeBg();
	</script>
</body>
</html>