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
	<style type="text/css">
		.login100-more {
  			width: calc(100% - 460px);
  		}
  		.login100-form {
  			width: 460px;
  			background-color: #fff;
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
						<h4>PT.Pelayaran Nasional Indonesia (Persero)</h4>
					</center></p>
					<span class="login100-form-title p-b-25">
						<h3><b>Absensi Pegawai</b></h3>
					</span>
					
					<div class="text-center">
						<table class="table-condensed fixed_header">
							<thead>
								<tr>
									<th width="50px" scope="col">#</th>
					                <!-- <th scope="col">Image</th> -->
					                <th width="200px" scope="col">Nama Lengkap</th>
					                <th width="200px" scope="col"><center>NRP</center></th>
					                <th width="200px" scope="col">Time</th>
								</tr>
							</thead>
							<tbody>
				                <tr>
				                  <th width="50px" scope="row">1</th>
				                  <!-- <td><img src="<?= base_url(THEME_PATH); ?>images/user.png" alt="Image" width="70px"></td> -->
				                  <td width="200px"><small><b>Bagus Navyan Putra</b></small><br><small>(Manager Pengembangan Teknologi Informasi)</small></td>
				                  <td width="200px">xxxxxxx</td>
				                  <td width="200px">07.00</td>
				                </tr>
				                <tr>
				                  <th scope="row">2</th>
				                  <!-- <td><img src="<?= base_url(THEME_PATH); ?>images/user.png" alt="Image" width="70px"></td> -->
				                  <td width="200px"><small><b>Bagus Navyan Putra</b></small><br><small>(Manager Pengembangan Teknologi Informasi)</small></td>
				                  <td width="200px">xxxxxxx</td>
				                  <td width="200px">07.00</td>
				                </tr>
				                <tr>
				                  <th scope="row">3</th>
				                  <!-- <td><img src="<?= base_url(THEME_PATH); ?>images/user.png" alt="Image" width="70px"></td> -->
				                  <td width="200px"><small><b>Bagus Navyan Putra</b></small><br><small>(Manager Pengembangan Teknologi Informasi)</small></td>
				                  <td width="200px">xxxxxxx</td>
				                  <td width="200px">07.00</td>
				                </tr>
				                <tr>
				                  <th scope="row">4</th>
				                  <!-- <td><img src="<?= base_url(THEME_PATH); ?>images/user.png" alt="Image" width="70px"></td> -->
				                  <td width="200px"><small><b>Bagus Navyan Putra</b></small><br><small>(Manager Pengembangan Teknologi Informasi)</small></td>
				                  <td width="200px">xxxxxxx</td>
				                  <td width="200px">07.00</td>
				                </tr>
				                <tr>
				                  <th scope="row">5</th>
				                  <!-- <td><img src="<?= base_url(THEME_PATH); ?>images/user.png" alt="Image" width="70px"></td> -->
				                  <td width="200px"><small><b>Bagus Navyan Putra</b></small><br><small>(Manager Pengembangan Teknologi Informasi)</small></td>
				                  <td width="200px">xxxxxxx</td>
				                  <td width="200px">07.00</td>
				                </tr>
				                <tr>
				                  <th scope="row">6</th>
				                  <!-- <td><img src="<?= base_url(THEME_PATH); ?>images/user.png" alt="Image" width="70px"></td> -->
				                  <td width="200px"><small><b>Bagus Navyan Putra</b></small><br><small>(Manager Pengembangan Teknologi Informasi)</small></td>
				                  <td width="200px">xxxxxxx</td>
				                  <td width="200px">07.00</td>
				                </tr>
				                <tr>
				                  <th scope="row">7</th>
				                  <!-- <td><img src="<?= base_url(THEME_PATH); ?>images/user.png" alt="Image" width="70px"></td> -->
				                  <td width="200px"><small><b>Bagus Navyan Putra</b></small><br><small>(Manager Pengembangan Teknologi Informasi)</small></td>
				                  <td width="200px">xxxxxxx</td>
				                  <td width="200px">07.00</td>
				                </tr>
				                <tr>
				                  <th scope="row">8</th>
				                  <!-- <td><img src="<?= base_url(THEME_PATH); ?>images/user.png" alt="Image" width="70px"></td> -->
				                  <td width="200px"><small><b>Bagus Navyan Putra</b></small><br><small>(Manager Pengembangan Teknologi Informasi)</small></td>
				                  <td width="200px">xxxxxxx</td>
				                  <td width="200px">07.00</td>
				                </tr>
				                <tr>
				                  <th scope="row">9</th>
				                  <!-- <td><img src="<?= base_url(THEME_PATH); ?>images/user.png" alt="Image" width="70px"></td> -->
				                  <td width="200px"><small><b>Bagus Navyan Putra</b></small><br><small>(Manager Pengembangan Teknologi Informasi)</small></td>
				                  <td width="200px">xxxxxxx</td>
				                  <td width="200px">07.00</td>
				                </tr>
				                <tr>
				                  <th scope="row">10</th>
				                  <!-- <td><img src="<?= base_url(THEME_PATH); ?>images/user.png" alt="Image" width="70px"></td> -->
				                  <td width="200px"><small><b>Bagus Navyan Putra</b></small><br><small>(Manager Pengembangan Teknologi Informasi)</small></td>
				                  <td width="200px">xxxxxxx</td>
				                  <td width="200px">07.00</td>
				                </tr>
				              </tbody>
						</table>
					</div>
				</form>

				<div class="login100-more" style="background-image: url('<?= base_url(THEME_PATH); ?>images/5.jpg');">
					<div class="row">&nbsp;</div>
					<span class="login100-form-title p-b-25">
						<h1><b style="color: rgba(255, 255, 255, 0.8); ">
							#DISPLAY NAME#							
						</b></h1>
						<h4 style="color: rgba(255, 255, 255, 0.8); " id="date"></h4>
						<h5 class="col align-self-center">
							<b style="color: rgba(255, 255, 255, 0.8); ">
								<center><h1 id="time"></h1></center>
							</b>
						</h5>
					</span>
					<div class="row">
						</div>
					<!-- <div class="row">&nbsp;</div> -->
					<div class="row">
						<h5 class="col align-self-center">
							<b style="color: rgba(255, 255, 255, 0.8); ">
								<center>(SCAN DISINI UNTUK ABSENSI)</center><br>
							</b>
						</h5></div>
					<div class="row">
						<div class="col align-self-center">
<<<<<<< HEAD
							<center><img src="<?= base_url(THEME_PATH); ?>images/qr-code.png" alt="Image" class="img-fluid" width="50%"></center></div>
=======
							<center>
								<img src="" alt="QR Code" class="img-qr img-fluid" width="55%">
							</center>
>>>>>>> ce0ed2837432b5f6ed79cdd008cc376f95531d1c
						</div>

					</div>
					
				</div>
			</div>
		</div>
	</div>

<<<<<<< HEAD
	<script src="<?= base_url(THEME_PATH); ?>dist/js/pages/absenqr/screen.js"></script>
=======
<script>
		var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
		var days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
		
		var date = new Date();
		var n = date.getDay();
		var day = date.getDate();
		var month = date.getMonth();
		var year = <?php echo date('Y')?>

		document.getElementById("date").innerHTML=days[n-1]+", "+" "+day+" "+months[month]+" "+year;
	</script>
	
<script type="text/javascript">
		function showTime(){
			var a_p = "";
			var today = new Date();
			var curr_hour = today.getHours();
			var curr_minute = today.getMinutes();
			var curr_second = today.getSeconds();

			// if (curr_hour<12) {
			// 	a_p = "AM";
			// }else {
			// 	a_p = "PM";
			// }

			// if (curr_hour == 0) {
			// 	curr_hour=12;
			// }
			// if (curr_hour == 12) {
			// 	curr_hour=curr_hour-12;
			// }
			curr_hour = checkTime(curr_hour);
			curr_minute = checkTime(curr_minute);
			curr_second = checkTime(curr_second);

			document.getElementById('time').innerHTML= curr_hour+":"+curr_minute+":"+curr_second+" "+a_p;
		}

		function checkTime(i){
			if (i<10) {
				i = "0"+i;
			}
			return i;
		}
		setInterval(showTime,500);
	</script>
	<script>var base_url = '<?= base_url() ?>';</script>
>>>>>>> ce0ed2837432b5f6ed79cdd008cc376f95531d1c
	<script src="<?= base_url(THEME_PATH); ?>vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/animsition/js/animsition.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/bootstrap/js/popper.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/select2/select2.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/daterangepicker/daterangepicker.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>vendor/countdowntime/countdowntime.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>dist/js/pages/absenqr/screen.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>js/main.js"></script>
</body>
</html>