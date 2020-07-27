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
		#img-qr img {
			padding: 10px;
			background: #FFF;
		}
		
		video {
			object-fit: fill!important;
		}

		.box-absen {
			background-image: url('<?= base_url(THEME_PATH);?>image/background/4.jpg');
			background-size: cover;
		}
	</style>
</head>
<body>	
	<div class="row" style="max-width:100%">
		<div class="col-md-6 box-absen" style="height:100vh">
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
		<div class="col-md-6" style="padding-right:0;">
			<div class="row" style="max-height:50vh;">
				<video autoplay id="promo-video" style="max-height:50vh;min-width:100%">
					<source src="<?= base_url(THEME_PATH) ?>videos/01.mp4"/>
					<source src="<?= base_url(THEME_PATH) ?>videos/02.mp4"/>
					<source src="<?= base_url(THEME_PATH) ?>videos/03.mp4"/>
				</video>
			</div>
			<div class="row" style="max-height:50vh;padding-top:10px;overflow:hidden;">
				<div class="col-lg-12" style="z-index:-999">
					<div class="table-res">
						<center style="padding-top:18%">
							<i class="fa fa-users fa-fw fa-2x"></i><br>
							<b class="clearfix">Belum Ada Absen Pegawai</b>
							<small class="clearfix">Lakukan absen dengan menggunakan Portal PELNI atau Aplikasi PELNI One</small>
							<img src="<?= base_url(THEME_PATH) ?>image/logo/playstore.png" alt="Playstore" height="50">
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		var base_url 	= '<?= base_url() ?>';
		var screen_id	= '<?= $screen_id ?>';
		var token 		= '<?= WS_AUTH_KEY ?>';
		var url_ws 		= '<?= WS_URL.'ws_absenqr' ?>';
		var url_trigger = '<?= WS_URL.'ws_absenqr/get_status_change' ?>';
		var url_qr 		= '<?= WS_URL.'ws_absenqr/get_new_qr' ?>';
		var url_video 	= '<?= base_url(THEME_PATH) ?>videos/';
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