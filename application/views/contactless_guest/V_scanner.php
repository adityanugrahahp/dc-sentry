<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="none" />
    <meta name="googlebot" content="none">
    <meta name="googlebot-news" content="none">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>Scan QR Code - PT. PELNI</title>
    <link rel="shortcut icon" href="<?= base_url(THEME_PATH); ?>favicon.ico">
    <link href="<?=base_url();?>assets/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">    
    <link href="<?=base_url();?>assets/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Roboto', sans-serif; }
</style>
<div class="row" style="margin: 10px;">
    <div class="col-xs-8 visible-xs hidden-md">
        <a href="<?= base_url() ?>" class="btn btn-default"><i class="fa fa-arrow-left fa-fw"></i></a>
    </div>
    <div class="col-xs-4 text-right visible-xs hidden-md">
        <h3 style="margin:0;">
            <img src="<?=base_url();?>assets/image/logo_head.jpg" alt="Logo Pelni" height="35">
        </h3>
    </div>
    <div class="col-xs-12 text-center visible-xs hidden-md" style="padding-top: 12px;">
        <hr style="margin-top:0px;margin-bottom:5px;">
        <h3 style="margin:0px;"><strong>Absensi QR</strong></h3>
        <small>
            New Normal Life PT. PELNI (Persero) &middot; 
            <span class="text-danger">#CovidSafeBUMN</span>
        </small>
    </div>
    <div class="col-sm-8 hidden-xs">
        <a href="<?= base_url() ?>" class="btn btn-default"><i class="fa fa-arrow-left fa-fw"></i></a>
    </div>
    <div class="col-sm-4 text-right hidden-xs">
        <h3 style="margin:0;">
            <img src="<?=base_url();?>assets/image/logo_head.jpg" alt="Logo Pelni" height="35">
        </h3>
    </div>
    <div class="col-sm-12 text-center hidden-xs" style="padding-top:12px;padding-left: 20px;">
        <h3 style="margin:0px;"><strong>Absensi QR</strong></h3>
        <small>
            New Normal Life PT. PELNI (Persero) &middot; 
            <span class="text-danger">#CovidSafeBUMN</span>
        </small>
    </div>
</div>
<div class="row" style="margin:0px;position:relative;">
    <div id="scanner" style="width:100vw;"></div>
</div>
<div class="row" style="margin:0px;">
    <div class="col-lg-12 navbar-fixed-bottom" style="background:#FFF;padding:20px">
        <div class="row">
            <div class="col-xs-9" style="margin-top:3px">
                <small>Waktu Saat Ini:</small><br>
                <b id="time">Loading...</b>
            </div>
        </div>
    </div>
</div>

    
    <script src="<?= base_url(THEME_PATH); ?>bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url(THEME_PATH); ?>dist/js/pages/contactless_guest/qr_scanner.js"></script>
    <script src="<?= base_url(THEME_PATH); ?>dist/js/pages/contactless_guest/html5-qrcode.min.js"></script>
    <script src="<?= base_url(THEME_PATH); ?>vendor/bootstrap/js/popper.js"></script>
    <script src="<?= base_url(THEME_PATH); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url(THEME_PATH); ?>vendor/daterangepicker/moment.min.js"></script>

    <script type="text/javascript">
        function onScanSuccess(qrCodeMessage) {
            // handle on success condition with the decoded message
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "scanner", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    </script>

<!--     / This method will trigger user permissions
Html5Qrcode.getCameras().then(devices => { -->


    
    
    

    <!-- <script src="<?= base_url(THEME_PATH); ?>js/main.js"></script> -->
    <!-- <script src="<?= base_url(THEME_PATH); ?>vendor/jquery/jquery-3.2.1.min.js"></script> -->
    <!-- <script src="<?= base_url(THEME_PATH); ?>vendor/animsition/js/animsition.min.js"></script> -->
    <!-- <script src="<?= base_url(THEME_PATH); ?>dist/js/pages/contactless_guest/contactless_guest.js"></script> -->
    <!-- <script src="<?= base_url(THEME_PATH); ?>vendor/select2/select2.min.js"></script> -->
    <!-- <script src="<?= base_url(THEME_PATH); ?>vendor/countdowntime/countdowntime.js"></script>  -->   
    <!-- <script src="<?= base_url(THEME_PATH); ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script> -->
    <!-- <script src="<?= base_url(THEME_PATH); ?>vendor/daterangepicker/daterangepicker.js"></script> -->