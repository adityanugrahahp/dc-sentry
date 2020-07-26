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
		video {
			/* -webkit-transform: scaleX(2); 
			-moz-transform: scaleX(2); */
			object-fit: fill!important;
		}
	</style>
</head>
<body style="background-color: #666666;">	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form validate-form" style="padding-top:0">
					<div class="row" style="max-height:35vh;">
					<video autoplay loop style="max-height:35vh;min-width:100%">
						<source src="<?= base_url(THEME_PATH) ?>videos/01.mp4" type="video/mp4" />
						Your browser does not support the video tag.
					</video>
					</div>
					<div class="row" style="max-height:59vh;padding-top:10px;">
						<div class="col-lg-12">
							<div class="table-res"><center>Belum Ada Absen Pegawai</center></div>
						</div>
					</div>
				</div>

				<div class="login100-more" style="background-image: url('<?= base_url(THEME_PATH);?>image/background/4.jpg');">
					<div class="card-img-overlay" style="background:rgba(0,0,0,0.6)">
						<div class="container">
							<div class="row">
								<div class="col-lg-6">
									<img src="<?= base_url(THEME_PATH) ?>image/logopelni_white.png" alt="Logo PELNI" class="img-fluid" style="height:80px;">
								</div>
								<div class="col-lg-6 text-right" style="padding-top:10px;">
									<h4 class="clearfix text-white"><b>ABSENSI PEGAWAI</b></h4>
									<b class="text-danger" style="font-size:14pt"><?= $lokasi ?></b>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12 text-center">
									<h1><b style="color: #FFF"><?= $nama ?></b></h1>
									<h4 style="color: #FFF " id="date"></h4>
									<h5 class="col align-self-center">
										<b style="color: #FFF ">
											<center><h1 id="time"></h1></center>
										</b>
									</h5>	
								</div>
							</div>
							<div class="row">
								<b class="col align-self-center" style="color:#FFF;padding-top:10px;padding-bottom:20px;">
									<center>(SCAN DISINI UNTUK ABSENSI)</center>
								</b>
							</div>
							<div class="row">
								<div class="col align-self-center">
									<center><div id="img-qr"></div></center>
								</div>	
							</div>
						</div>
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
</body>
</html>