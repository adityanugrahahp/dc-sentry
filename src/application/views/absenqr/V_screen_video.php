<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo (isset($page_title)) ? $page_title.' - '.APP_NAME : APP_NAME ?></title>

  <link rel="icon" href="https://static.pelni.co.id/file/logo/new2023/logogram.png">
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

    .btn-primary, .skin-blue .main-header .navbar {
      background: #34438a!important;
    }

    .text-primary {
      color: #34438a!important;
    }
	</style>
</head>
<body>	
	<div class="row" style="max-width:100%">
		<div class="col-md-6 box-absen" style="height:100vh">
			<div class="card-img-overlay" style="background:rgba(52,67,138,0.9)">
				<div class="container">
					<div class="row" style="z-index:999;">
						<div class="col-lg-6" style="padding-top:10px;">
							<h5 class="clearfix text-white" style="font-size:15pt!important;"><b>ABSENSI PEGAWAI</b></h5>
							<b class="text-warning" style="font-size:13pt"><?= $lokasi ?></b>
						</div>
            <div class="col-lg-6 text-right">
              <img src="<?= base_url(THEME_PATH) ?>image/logopelni_white.png" alt="Logo PELNI" class="img-fluid" style="height:60px;">
            </div>
					</div>
          <div style="padding-top:5%"></div>
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
							<center>
                <div id="user-no-location" class="text-white" style="display:none;padding-top:100px">
                  <b style="padding-top:300px">Mohon Tunggu</b>
                  <p class="text-white"></p>
                </div>
              </center>
						</div>	
					</div>
          <div class="fixed-bottom" style="padding-bottom:100px;">
            <div class="col-lg-12">
            </div>
          </div>
          <div class="fixed-bottom bg-white row" style="padding:0px;">
            <div class="col-lg-2 pt-4" style="background-color:#72BCE8!important;">
              <h4 class="text-white" style="padding-left:10px;padding-top:10px;font-size:15pt">
                <center>
                  <b id="greeter">-</b>
                </center>
              </h4>
						</div>
            <div class="col-lg-10 py-2 px-4 table-res" style="background:#eee">
              <center style="height:65px;padding-top:18px">
                <h6><b class="clearfix"><i class="fa fa-users fa-fw"></i> Belum Ada Absen Pegawai</b></h6>
                <h6 class="small">Lakukan absen dengan menggunakan Portal PELNI atau Aplikasi PELNI One</h6>
              </center>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6" style="padding-right:0;">
			<div class="row" style="max-height:calc(50vh - 30.25px);">
				<video muted id="promo-video" style="max-height:calc(50vh - 30.25px);min-width:100%">
					<source src="<?= base_url(THEME_PATH) ?>videos/00.mp4"/>
				</video>
			</div>
      <? if($lokasi == 'KANTOR PUSAT'){ ?>
      <div class="row align-items-center">
        <div class="col news-list-item text-center text-white p-0 m-0" style="height:calc(50vh - 30.25px);">
          <div class="p-0 m-0">
            <div style="background: rgba(0,0,0,0.4);margin-top:calc(40vh - 30.25px);padding:15px;">
              <b class="news-list-item-title clearfix" style="color:#FFF;">#NEWSFEED_TITLE#</b>
              <small><b class="news-list-item-date" style="color:#FFF;">#NEWSFEED_DATE#</b></small>
            </div>
          </div>
        </div>
			</div>
      <? } ?>
		</div>
	</div>

	<script>
		var base_url 	  = '<?= base_url() ?>';
		var screen_id	  = '<?= $screen_id ?>';
		var token 		  = '<?= WS_AUTH_KEY ?>';
		var url_ws 		  = '<?= WS_URL.'v1/attendance' ?>';
		var url_trigger = '<?= WS_URL.'v1/attendance/get_status_change' ?>';
		var url_qr 		  = '<?= WS_URL.'v1/attendance/get_new_qr' ?>';
		var url_news    = 'https://ms-website-content.pelni.co.id/news/lang/id';
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
	<script src="<?= base_url(THEME_PATH); ?>dist/js/pages/absenqr/screen.js?_u="<?= rand(0,99) ?>></script>
	<script src="<?= base_url(THEME_PATH); ?>js/main.js"></script>
</body>
</html>
