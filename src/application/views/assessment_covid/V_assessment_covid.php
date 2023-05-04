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

    <title>Assessment Covid-19</title>
    <link rel="icon" href="<?php echo base_url(THEME_PATH) ?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url(THEME_PATH) ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(THEME_PATH) ?>bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(THEME_PATH) ?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url(THEME_PATH) ?>dist/css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url(THEME_PATH) ?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url(THEME_PATH) ?>dist/css/capture.css">
    <link rel="stylesheet" href="<?php echo base_url(THEME_PATH) ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

    <!-- Bootstrap Core CSS -->
    <!-- <link href="<?=base_url();?>theme/andang/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet"> -->
    <!-- <link href="<?=base_url();?>theme/andang/bower_components/bootstrap/dist/css/bootstrap-reset.css" rel="stylesheet"> -->
    <!-- MetisMenu CSS -->
    <!-- <link href="<?=base_url();?>theme/andang/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet"> -->


    <!-- Custom CSS -->
    <!-- <link href="<?=base_url();?>theme/andang/dist/css/sb-admin-2.css" rel="stylesheet"> -->

    <!-- Custom Fonts -->
    <!-- <link href="<?=base_url();?>theme/dashboard/css/fontawesome-all.min.css" rel="stylesheet" type="text/css"> -->
    <!-- <link rel="stylesheet" href="<?=base_url();?>theme/dashboard/css/converse.css"> -->
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- <script src="<?=base_url();?>theme/red-orange/js/ie-emulation-modes-warning.js"></script> -->

    <!-- jQuery -->
    <!-- <script src="<?=base_url();?>theme/andang/bower_components/jquery/dist/jquery.min.js"></script> -->
    <!-- Bootstrap Core JavaScript -->
    <!-- <script src="<?=base_url();?>theme/andang/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->

    <!-- Metis Menu Plugin JavaScript -->
    <!-- <script src="<?=base_url();?>theme/andang/bower_components/metisMenu/dist/metisMenu.min.js"></script> -->

    <!-- Custom Theme JavaScript -->
    <!-- <script src="<?=base_url();?>theme/andang/dist/js/sb-admin-2.js"></script> -->
    <?//script untuk include extra css dan js?>
    <?if(isset($extraCss)):?>
    <?foreach($extraCss as $key => $css):?>
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/<?=$css;?>" />
    <?endforeach;?>
    <?endif;?>
    <!-- this is extra -->
    <style>
        /* .swal2-popup { font-size: 1.6rem !important; } */
    </style>
    <!-- end this is extra -->
    <script>
        var base_url="<?php echo base_url(); ?>";
    </script>
  
    <script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url();?>assets/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?php echo base_url() ?>assets/bower_components/moment/moment.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/iCheck/icheck.min.js"></script>
    <script src="<?php echo base_url();?>assets/dist/js/adminlte.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script src="<?php echo base_url();?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script>var base_url = "<?php echo base_url();?>";</script>
    <?php if(isset($extraJs)):?>
        <?php foreach($extraJs as $key => $js):?>
            <script type="text/javascript" src="<?php echo base_url();?>assets/js/<?=$js;?>"></script>
        <?php endforeach;?>
    <?php endif;?>

    <style type="text/css">
        /*swal style*/
        .swal2-popup {
        font-size: 1.6rem !important;
        }
        .swal-wide{
        width:500px !important;
        }
        /*end here*/

        label>input {
            /* Menyembunyikan radio button */
            visibility: hidden;
            position: absolute;
        }

        label>input+img {
            /* style gambar */
            -webkit-filter: grayscale(100%);
            cursor: pointer;
            border: 2px solid transparent;
            width:50px;
        }

        label>input:checked+img {
            /* (RADIO CHECKED) style gambar */
            -webkit-filter: grayscale(0%);

        }

        /* Styles go here */
        /** form wizard **/
        .formwizardpopup .modal-content.banner img {
        -webkit-filter: brightness(0) invert(1);
        filter: brightness(0) invert(1);
        }
        .under {
            text-decoration: underline;
        }

        .form_wizard li.disable>a.hidden-xs {
            display: block !important;
        }

        .form_wizard li.disable>a.visible-xs {
            display: block !important;
        }

        .form_wizard .nav-pills.nav-wizard>li {
            position: relative;
            overflow: block;
            border-right: 10px solid #fff;
            border-left: 10px solid #fff;
        }

        .form_wizard .nav-pills.nav-wizard>li:first-child {
            border-left: 0;
        }

        .form_wizard .nav-pills.nav-wizard>li:first-child a {
            border-radius: 5px 0 0 5px;
        }

        .form_wizard .nav-pills.nav-wizard>li:last-child {
            border-right: 0;
        }

        .form_wizard .nav-pills.nav-wizard>li:last-child a {
            border-radius: 0 5px 5px 0;
        }

        .form_wizard .nav-pills.nav-wizard>li a {
            border-radius: 0;
            background-color: #FF0000;
            padding: 10px;
        }

        .form_wizard .nav-pills.nav-wizard>li .nav-arrow {
            position: absolute;
            top: 0px;
            right: -20px;
            width: 0px;
            height: 0px;
            border-style: solid;
            border-width: 20px 0 20px 20px;
            border-color: transparent transparent transparent #eee;
            z-index: 150;
        }

        .form_wizard .nav-pills.nav-wizard>li .nav-wedge {
            position: absolute;
            top: 0px;
            left: -20px;
            width: 0px;
            height: 0px;
            border-style: solid;
            border-width: 20px 0 20px 20px;
            border-color: #eee #eee #eee transparent;
            z-index: 150;
        }

        .form_wizard .nav-pills.nav-wizard>li:hover .nav-arrow {
            border-color: transparent transparent transparent #aaa;
        }

        .form_wizard .nav-pills.nav-wizard>li:hover .nav-wedge {
            border-color: #aaa #aaa #aaa transparent;
        }

        .form_wizard .nav-pills.nav-wizard>li:hover a {
            background-color: #aaa;
            color: #fff;
        }

        .form_wizard .nav-pills.nav-wizard>li.active .nav-arrow {
            border-color: transparent transparent transparent #428bca;
        }

        .form_wizard .nav-pills.nav-wizard>li.active .nav-wedge {
            border-color: #428bca #428bca #428bca transparent;
        }

        .form_wizard .nav-pills.nav-wizard>li.active a {
            background-color: #428bca;
        }


        .form_wizard .data_blk {
            padding: 10px 40px;
        }

        .form_wizard .data_blk h3 {
            font-size: 20px;
            text-align: justify;
            line-height: 32px;
        }

        .form_wizard .data_blk h5 {
            text-align: justify;
            line-height: 20px;
        }

        .form_wizard .data_blk p {
            text-align: justify-all;
            font-size: 12px;
        }

        .form_wizard .data_blk p.lead {
            /* text-align: justify;*/
            font-size: 14px;
        }

        .a_right {
            border: solid #FF0000;
            border-width: 0 1px 1px 0;
            display: inline-block;
            padding: 6px;
            transform: rotate(135deg);
            -webkit-transform: rotate(135deg);
            vertical-align: middle;
            margin-right: -10px;
        }

        .a_left {
            border: solid #FF0000;
            border-width: 0 1px 1px 0;
            display: inline-block;
            padding: 6px;
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            vertical-align: middle;
            margin-left: -5px;
        }

        .form_wizard .back,
        .form_wizard .btn-default.next {
            background: transparent;
            border-color: transparent;
            outline: 0;
            text-transform: unset;
            font-size: 12px;
            padding-left: 0;
            color: #FF0000;
            margin-left: 10px;
        }

        .form_wizard .btn-default.next {
            color: #ffff;
        }

        .form_wizard .back:hover,
        .form_wizard .back:focus {
            background: transparent;
            border-color: transparent;

        }

        .form_wizard .btn-primary {
            background: #FF0000;
            border-radius: 3px;
            border-color: #FF0000;
            text-transform: unset;
        }

        .form_wizard .btn-secondary {
            background: #000080;
            border-radius: 3px;
            border-color: #000080;
            text-transform: unset;
            color: #ffff;
        }


        .form_wizard .form_blk {
            margin-bottom: 20px;
            margin-right: -15px;
            margin-left: -15px;
        }

        .formwizardpopup .modal-body {
            padding-top: 40px;
        }

        .formwizardpopup .modal-content {
            border-radius: 3px;
            background: #ffff;
        }

        .form_wizard .form_blk .other input[type="text"] {
            display: block;
            vertical-align: middle;
            width: 100%;
            height: 35px;
            padding: 5px;
            border: 1px solid #d4d4d4;
            border-radius: 3px;
        }


        .form_wizard .sm_text {
            font-size: 12px;
            padding: 0 100px 40px;
            text-align: center;
        }

        .form_wizard .col-sm-6 .sm_text {
            padding: 0;
        }

        @media (min-width: 700px) {
            .formwizardpopup .modal-dialog {
                width: 450px;
            }
        }
        .form_wizard .progress {
        height: 8px;
        margin: 0 60px;
        }

        .form_wizard .progress-bar-info {
        background: transparent;
        text-align: center;
        padding: 10px 0;
        font-size: 15px;
        }

        .formwizardpopup .modal-content.banner .progress,
        .formwizardpopup .modal-content.banner .progress-bar-info {
            display: none;
        }

        .formwizardpopup .modal-content.banner .modal-body {
            padding-top: 20px;
            background: #203047;
            color: #fff;
        }

        .formwizardpopup .modal-content.banner .modal-body h3 {
            text-align: left;
            font-size: 3rem;
            margin-bottom: 30px;
        }

        .formwizardpopup .modal-content.banner .a_left {
            border-color: #fff;
        }

        .formwizardpopup .modal-content.banner {
            background: #203047;
        }

        .formwizardpopup .modal-content.banner {
            text-align: center;
        }


        html,
        body,
        #wrapper {
            height: 100%;
            margin: 0;
        }

        #content-wrapper {
            position: inherit;
            margin: 0;
            padding: 0 30px;
            border-left: 1px solid #e7e7e7;
            background: #fff;
            height: 100%;
            overflow-y: auto;
        }

        #info-browser {
            margin-top: 50px;
        }

        #menu-group {
            float: right;
        }

        .image-sehat{
            width: 120px;
            height: 120px;
            background-position: center center;
            background-repeat: no-repeat;
            overflow: hidden
        }
    </style>

	</head>

	<body>

    <div class="row" style="background: white">
        <div class="col-md-12 col-lg-12">
                <h4 class="text-right" style="float:right; padding: 10px 10px 10px" id="time"></h4>
                <img class="text-left" src='<?= base_url(THEME_PATH);?>image/logo_head.jpg' style ="height:75px;float:left; padding: 10px 0 10px 10px">
        </div>
    </div>
    <div class ="row">
        <div class="modal fade formwizardpopup" id="myModal" role="dialog" style="background-image: url('<?= base_url(THEME_PATH);?>image/background/5.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: cover;">
            <div class="modal-dialog">
                <form role="form" id="health-form" action="<?php echo base_url().'Assessment_covid19/insert_health_log'?>" method="POST">
                    <div class="modal-content banner">
                        <div class="modal-body">
                            <div class="form_wizard" id="myWizard">
                                <div class="navbar hidden">
                                    <div class="navbar-inner">
                                        <ul class="nav nav-pills nav-wizard">
                                        <li class="active">
                                            <a class="hidden-xs" href="#step1" data-toggle="tab" data-step="1">1. welcome</a>
                                            <a class="visible-xs" href="#step1" data-toggle="tab" data-step="1">1.</a>
                                            <div class="nav-arrow"></div>
                                        </li>
                                        <li class="disabled">
                                            <div class="nav-wedge"></div>
                                            <a class="hidden-xs" href="#step2" data-toggle="tab" data-step="2">2. kesehatan</a>
                                            <a class="visible-xs" href="#step2" data-toggle="tab" data-step="2">2.</a>
                                            <div class="nav-arrow"></div>
                                        </li>
                                        <li class="disabled">
                                            <div class="nav-wedge"></div>
                                            <a class="hidden-xs" href="#step3" data-toggle="tab" data-step="3">3. Mood</a>
                                            <a class="visible-xs" href="#step3" data-toggle="tab" data-step="3">3.</a>
                                            <div class="nav-arrow"></div>
                                        </li>
                                        <li class="disabled">
                                            <div class="nav-wedge"></div>
                                            <a class="hidden-xs" href="#step4" data-toggle="tab" data-step="4">4. Self-Assement</a>
                                            <a class="visible-xs" href="#step4" data-toggle="tab" data-step="4">5.</a>
                                        </li>
                                        <li class="disabled">
                                            <div class="nav-wedge"></div>
                                            <a class="hidden-xs" href="#step5" data-toggle="tab" data-step="5">5. Self-Assement</a>
                                            <a class="visible-xs" href="#step5" data-toggle="tab" data-step="5">6.</a>
                                        </li>
                                        <li class="disabled">
                                            <div class="nav-wedge"></div>
                                            <a class="hidden-xs" href="#step6" data-toggle="tab" data-step="6">6.Self-Assement</a>
                                            <a class="visible-xs" href="#step6" data-toggle="tab" data-step="6">6.</a>
                                        </li>
                                        <li class="disabled">
                                            <div class="nav-wedge"></div>
                                            <a class="hidden-xs" href="#step7" data-toggle="tab" data-step="7">7.WFO</a>
                                            <a class="visible-xs" href="#step7" data-toggle="tab" data-step="7">7.</a>
                                        </li>
                                        <li class="disabled">
                                            <div class="nav-wedge"></div>
                                            <a class="hidden-xs" href="#step8" data-toggle="tab" data-step="8">8.WFO</a>
                                            <a class="visible-xs" href="#step8" data-toggle="tab" data-step="8">8.</a>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="step1">
                                        <div class="data_blk">
                                            <img src= "<?= base_url(THEME_PATH);?>image/popup/logo-pelni.svg" style="height:90px;margin:0 auto;" alt="">
                                            <br>
                                            <br>
                                            <div class="row text-center">
                                                <h4 style="color: white;">AKHLAK CORE VALUES SDM BUMN</h4>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <strong></strong><p class="text-left" style="color: white; margin: 0"><span style="color: #009ea9; font-weight: 900; font-size:20px;">A</span><span style="font-size: 15px">MANAH</span></p></strong>
                                            </div>
                                            <div class="row text-left">
                                                <span class="text-left">
                                                    <small>Memegang teguh kepercayaan yang telah diberikan</small>
                                                </span>
                                            </div>
                                            <div class="row">
                                                <strong></strong><p class="text-left" style="color: white; margin: 0"><span style="color: #009ea9; font-weight: 900; font-size:20px;">K</span><span style="font-size: 15px">OMPETEN</span></p></strong>
                                            </div>
                                            <div class="row text-left">
                                                <span class="text-left">
                                                    <small>Terus belajar dan mengembangkan kapasitas</small>
                                                </span>
                                            </div>
                                            <div class="row">
                                            <strong></strong><p class="text-left" style="color: white; margin: 0"><span style="color: #009ea9; font-weight: 900; font-size:20px;">H</span><span style="font-size: 15px">ARMONIS</span></p></strong>
                                            </div>
                                            <div class="row text-left">
                                                <span class="text-left">
                                                    <small>Saling peduli dan menghargai perbedaan</small>
                                                </span>
                                            </div>
                                            <div class="row">
                                                <strong></strong><p class="text-left" style="color: white; margin: 0"><span style="color: #009ea9; font-weight: 900; font-size:20px;">L</span><span style="font-size: 15px">OYAL</span></p></strong>
                                            </div>
                                            <div class="row text-left">
                                                <span class="text-left">
                                                    <small>Berdedikasi dan mengutamakan kepentingan bangsa dan negara</small>
                                                </span>
                                            </div>
                                            <div class="row">
                                                <strong></strong><p class="text-left" style="color: white; margin: 0"><span style="color: #009ea9; font-weight: 900; font-size:20px;">A</span><span style="font-size: 15px">DAPTIF</span></p></strong>
                                            </div>
                                            <div class="row text-left">
                                                <span class="text-left">
                                                    <small>Terus berinovasi dan antusias dalam menggerakan ataupun menghadapai perubahan</small>
                                                </span>
                                            </div>
                                            <div class="row">
                                                <strong></strong><p class="text-left" style="color: white; margin: 0"><span style="color: #009ea9; font-weight: 900; font-size:20px;">K</span><span style="font-size: 15px">OLABORATIF</span></p></strong>
                                            </div>
                                            <div class="row text-left">
                                                <span class="text-left">
                                                    <small>Membangun kerja sama yang sinergi</small>
                                                </span>
                                            </div>       
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <button class="btn btn-default next" type="submit">Mulai Assessment &nbsp; <i class="a_left"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="step2">
                                        <div class="form-group">
                                            <div class="data_blk">
                                                <div class="justify">
                                                    <h3>Mohon lengkapi data berikut untuk memulai assessment:
                                                    </h3>
                                                    <select class="form-control" name="nrp" id="nrp" style="width:100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-xs-6 text-left">
                                                    <button class="btn btn-default back" type="button">< kembali</button>
                                                </div>
                                                <div class="col-sm-6 col-xs-6 text-right">
                                                    <button class="btn btn-primary btn-lg  next" type="submit">Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade in" id="step3">
                                        <div class="data_blk">
                                            <div class="form-group">
                                                <div class="text-center">
                                                    <h3 style="text-align: center">Apakah Anda Sehat Hari ini?</h3>
                                                    <div class="text-center">
                                                        <div class="col-xs-6 col-md-6 text-right">
                                                            <label>
                                                                <input type="radio" class="form-radio" name="healthy" value="sehat">
                                                                <img class="image-sehat" src="<?= base_url(THEME_PATH);?>image/popup/sehatlah.png">
                                                            </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </div>
                                                        <div class="col-xs-6 col-md-6 text-left">
                                                            <label>
                                                            <input type="radio" class="form-radio" name="healthy" value="sakit">
                                                            <img class="image-sehat" src="<?= base_url(THEME_PATH);?>image/popup/tidaksehatlah.png">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b></b>&nbsp;&nbsp;
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    <button class="btn btn-default back" type="button">< kembali</button>
                                                    </div>
                                                    <div class="col-sm-6 text-right">
                                                    <button class="btn btn-primary btn-lg  next" >Next</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="step4">
                                        <div class="form-group">
                                            <div class="form_blk">  
                                                <div class="text-center"><h3> Bagaimana Perasaan Anda Hari ini? </h3>
                                                    <label>
                                                    <input type="radio" name="mood" value="sangat baik">
                                                    <img src="<?= base_url(THEME_PATH);?>image/popup/v-good.png">
                                                    </label>
                                                    <label>
                                                    <input type="radio" name="mood" value="baik"><img src="<?= base_url(THEME_PATH);?>image/popup/good.png"></label>
                                                    <label>
                                                    <input type="radio" name="mood" value="biasa" ?><img src="<?= base_url(THEME_PATH);?>image/popup/moderate.png">
                                                    </label>
                                                    <label>
                                                    <input type="radio" name="mood" value="tidak baik"><img src="<?= base_url(THEME_PATH);?>image/popup/bad.png">
                                                    </label>
                                                    <label>
                                                    <input type="radio" name="mood" value="buruk"><img src="<?= base_url(THEME_PATH);?>image/popup/v-bad.png">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-xs-6 text-left">
                                                    <button class="btn btn-default back" type="button">< kembali</button>
                                                </div>
                                                <div class="col-sm-6 col-xs-6 text-right">
                                                    <button class="btn btn-primary btn-lg  next" type="submit">Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="step5">
                                        <div class="form-group">
                                            <div class="data_blk">
                                                <div class="justify">
                                                    <h5>1. Apakah anda memiliki riwayat kesehatan pernafasan atau riwayat penyakit lain (comorbid hypertensi, jantung, diabetes dan stroke?
                                                    </h5>
                                                </div>
                                                <input type="radio" name="q1" value="1">&nbsp;Ya &nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="q1" value="2">&nbsp;Tidak
                                                <div class="justify">
                                                    <h5>2. Apakah anda pernah keluar rumah atau tempat umum (pasar, fasyankes, mall, supermarket dan lain lain) dalam 7 hari terakhir?</h5>
                                                    <input type="radio"  name="q2" value="1">&nbsp;Ya &nbsp;&nbsp;&nbsp;
                                                    <input type="radio"  name="q2" value="2">&nbsp;Tidak
                                                    <div class="justify">
                                                        <h5>3. Apakah anda menggunakan transportasi umum (krl, busway, taxi dan lain lain) dari dan menuju kantor? 
                                                        </h5>
                                                        <input type="radio"  name="q3" value="1">&nbsp;Ya &nbsp;&nbsp;&nbsp;
                                                        <input type="radio"  name="q3" value="2">&nbsp;Tidak
                                                        &nbsp;&nbsp;&nbsp;
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-xs-6 text-left">
                                                    <button class="btn btn-default back" type="button">< kembali</button>
                                                </div>
                                                <div class="col-sm-6 col-xs-6 text-right">
                                                    <button class="btn btn-primary btn-lg  next" type="submit">Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="step6">
                                        <div class="form-group">
                                            <div class="data_blk">
                                                <div class="justify">
                                                    <h5>4. Apakah anda mengikuti kegiatan yang melibatkan banyak orang dalam 7 hari terakhir? 
                                                    </h5>
                                                    <input type="radio" name="q4" value="1">&nbsp;Ya &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="q4" value="2">&nbsp;Tidak
                                                    <h5>5. Apakah anda memiliki riwayat kontak erat dengan orang yang dinyatakan ODP, PDP atau konfrim COVID-19 (berjabat tangan, berbicara, berada dalam satu ruangan/satu rumah)?
                                                    </h5>
                                                    <input type="radio" name="q6" value="1">&nbsp;Ya &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="q6" value="2">&nbsp;Tidak
                                                    <h5>6. Apakah anda pernah melakukan perjalanan dinas keluar kota/internasional dalam 7 hari terakhir? </h5>
                                                    <input type="radio" name="q5" value="1">&nbsp;Ya &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="q5" value="2">&nbsp;Tidak
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-xs-6 text-left">
                                                    <button class="btn btn-default back" type="button">< kembali</button>
                                                </div>
                                                <div class="col-sm-6 col-xs-6 text-right">
                                                    <button class="btn btn-primary btn-lg  next" type="submit">Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="step7">
                                        <div class="form-group">
                                            <div class="data_blk">
                                                <div class="justify">
                                                    <h5>7. Apakah pernah mengalami demam/ batuk/ pilek/ sakit tenggorokan/ sesak dalam 14 hari terakhir? </h5>
                                                    <input type="radio" name="q7" value="1">&nbsp;&nbsp;Ya &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="q7" value="2">&nbsp;Tidak
                                                    <h5>8. Apakah anda pernah ditetapkan sebagai ODP/PDP/positif COVID-19? (dalam 4 bulan terakhir), jika iya isi pertanyaan berikutnya </h5>
                                                    <input type="radio" name="q8" value="1">&nbsp;Ya &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="q8" value="2">&nbsp;Tidak
                                                    <div id="q9" style="display: none;">
                                                        <h5>9. Apakah anda sudah dinyatakan sembuh? <br><small>*Pilih Ya jika anda bukan ODP/PDP/positif COVID-19</small></small><br></h5>
                                                        <input type="radio" name="q9" value="1" checked id="q91">&nbsp;Ya &nbsp;&nbsp;&nbsp;
                                                        <input type="radio" name="q9" value="2" id="q92">&nbsp;Tidak
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-xs-6 text-left">
                                                    <button class="btn btn-danger back" type="button">< kembali</button>
                                                </div>
                                                <div class="col-sm-6 col-xs-6 text-right">
                                                    <button class="btn btn-primary btn-lg btn-success next" type="submit" id="butsave">Selesai</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function() {

    
    // potret_perusahaan();
    startTime();    
    $("#nrp").select2({
        tags: false,
        multiple: false,
        placeholder: "Masukkan nrp/nama anda",
        value: true,
        minimumInputLength: 3,
        width: 'resolve',
        ajax: {
            url: base_url + 'Assessment_covid19/select2_pegawai',
            dataType: "json",
            type: "POST",
            data: function (params) {
                var queryParameters = {
                    param: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            }
        }
    });

    var d         = new Date();
    var dd        = d.getDay();
    var nd        = d.setDate(d.getDate() + 7);


   
    var assesment_status    = '1';
 

    var required_daily_health = 1;
    var required_assessment   = 1;      
    var win_height = $( window ).height();
    var next;
    var day;
    var month;
    var year;
    var modal_height = $('#health-form').height();
    var form       = $("#health-form");
    var url_health = "Assessment_covid19/insert_health_log";
    
    form.validate({
    focusInvalid: false,
    rules:{
      mood : "required",
      nrp : "required",
      healthy : "required",
      q1 : "required",
      q2 : "required",
      q3 : "required",
      q4 : "required",
      q5 : "required",
      q6 : "required",
      q7 : "required",
      q8 : "required",
      q9 : "required",
      },
    errorPlacement: function(error,element) {
      return true;
    }
    
    });


    $('#myModal').css('margin-top',((win_height/9)-(modal_height/12)));
        // if((required_daily_health==1 && input_health_status==1))
        // {
          next = new Date(nd);
          day  = new Array();
          day[0] = "Minggu";
          day[1] = "Senin";
          day[2] = "Selasa";
          day[3] = "Rabu";
          day[4] = "Kamis";
          day[5] = "Jumat";
          day[6] = "Sabtu";
            
          month = new Array();
          month[0] = "Januari";
          month[1] = "Februari";
          month[2] = "Maret";
          month[3] = "April";
          month[4] = "Mei";
          month[5] = "Juni";
          month[6] = "July";
          month[7] = "Agustus";
          month[8] = "September";
          month[9] = "Oktober";
          month[10] = "November";
          month[11] = "Desember"; 

          $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false
            });
          $('#myModal').modal('show');
          $('.modal-backdrop').css('opacity', 0);
        // }

        function startTime() {
            month = new Array();
          month[0] = "Januari";
          month[1] = "Februari";
          month[2] = "Maret";
          month[3] = "April";
          month[4] = "Mei";
          month[5] = "Juni";
          month[6] = "July";
          month[7] = "Agustus";
          month[8] = "September";
          month[9] = "Oktober";
          month[10] = "November";
          month[11] = "Desember"; 
    var today = new Date();
    var d = today.getDate();
    var mon = today.getMonth();
    var y = today.getFullYear();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time').innerHTML =
    h + ":" + m + ":" + s + "<br><small>" + d + " " + month[mon] + " " + y+ "</small> ";
    var t = setTimeout(startTime, 500);
    }
    function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
    }
    $("#butsave").on('click', function (e) {
            e.preventDefault();
            var nrp = $('#nrp').val();
            var data_kirim = $("#health-form").serializeArray();
            data_kirim.push({ name: "nrp", value: nrp });

            if(assesment_status != 1)
            {
                data_kirim.push({ name: "act", value: "update" });
                data_kirim.push({ name: "id_log_health", value: assesment_status });
            }
            else
            {
                data_kirim.push({ name: "act", value: "insert" });
            }
            
            if(form.valid())
            {
                var nama = $('#nrp').text();
                $.ajax({
                method: "post",
                url: base_url+url_health,
                data: data_kirim,
                beforeSend: function(){
                    $.blockUI({
                        message: '<img src="' + base_url + '/assets/image/loading.gif" height="80px" style="image-rendering: auto;"/>',
                        css: { border: 'none', backgroundColor: 'none', color: '#fff', 'z-index': 1055 }
                    });
                },
                dataType: "json",
                success: function (response) {
                    if(response.status=="success" && response.data < 5)
                    {
                    // Assesment selanjutnya: <b>'+  day[next.getDay()]+', '+next.getDate()+ ' '+month[next.getMonth()]+' '+next.getFullYear() +'</b>

                    Swal.fire({
                        html: '<span class="text-success"><p>Anda Termasuk:</p><h4>'+response.status_message+'</h4><br><i class="fa fa-check-circle fa-fw"></i></span><b>Selamat '+  'Datang' +'</b><br><b>'+ nama +'</b><br/><br/>' + '<small class="clearfix">Selamat bekerja <b>The New Normal Way</b>, gunakan selalu <b class="text-primary">masker</b> selama di kantor, sering <b class="text-primary">mencuci tangan</b> dan <b class="text-primary">menjaga jarak</b> aman.<br/><br/><span class="text-danger">#CovidSafeBUMN</span></small>',
                        imageUrl: base_url + 'assets/image/new_normal/working.png',
                        imageWidth: 250,
                        imageAlt: 'Banner Image',
                        onClose: potret_perusahaan
                    })
                    }
                    else if(response.status=="success" && response.data >= 5)
                    {
                    Swal.fire({
                        html: '<span class="text-danger"><p>Anda Termasuk:</p><b><h4>'+response.status_message+'</h4><i class="fa fa-times-circle fa-fw"></i><br></span>Sdr/sdri kami <br><b>'+ nama +'</b><br/><br/><p>Anda Dianjurkan Untuk Beristirahat Hingga Kondisi Anda Optimal</p><span class="text-danger">#CovidSafeBUMN</span>',
                        imageUrl: base_url + 'assets/image/new_normal/stop_wfo.png',
                        imageWidth: 150,
                        imageAlt: 'Banner Image',
                        onClose: potret_perusahaan
                    })
                    }
                    else
                    {
                    Swal.fire("Error!", response.status_message, "error"); 
                    }
                    $('#myModal').modal('hide');
                    $.unblockUI();
                }
                });
            }
            else
            {
                Swal.fire("Data belum lengkap!", "Silahkan isi data yang belum lengkap", "error"); 
            } 
            });

        function potret_perusahaan()
        {
        var imgUrl = "<?=$img_potret;?>";
        Swal.fire({
                        imageUrl: imgUrl,
                        // imageWidth: 750,
                        imageAlt: 'Banner Image',
                        showConfirmButton: false,
                        background: 'transparent',
                        padding: '0',
                        showCloseButton: true,
                        showClass: {
                        popup: 'animate__animated animate__bounceInRight'
                        },
                        hideClass: {
                        popup: 'animate__animated animate__bounceOutLeft'
                        },
                        customClass: "<?php $swal_class;?>",
                        closeButtonHtml: '<button class="btn btn-danger"><i class="fa fa-times"></i></button>',
                        onClose: refresh,
                    })
        }
        $("#nrp").on('change', function (e){
            var nrp = $(this).val();
            $.ajax({
                url: base_url+'Assessment_covid19/cek_score',
                type: 'POST',
                data: {'nrp':nrp},
                dataType: 'JSON',
                success: function(d)
                {
                    if(d!==false)
                    {
                        Swal.fire({
                            icon: 'success',
                            title: "Assessment Telah Lengkap!",
                            text: "Data Assessment sudah dilengkapi untuk hari ini, assessment selanjutnya akan dilakukan esok hari",
                            showConfirmButton: true,
                            onClose: refresh
                        }); 
                        
                    }
                }

            })
        })

        function refresh()
        {
            window.location.reload();
        }
    $('input[type=radio][name=q8]').change(function(){
    if(this.value == '1')
    {
        $('#q9').show();
    }
    else
    {
        $('#q91').prop("checked", true);
        $('#q9').hide();
    }
    })
    $('.next').click(function(){
    if(form.valid())
    {
        var nextId = $(this).parents('.tab-pane').next().attr("id");
        $('[href="#'+nextId+'"]').tab('show');
        $('.formwizardpopup .modal-content').removeClass('banner');  
    }    
    return false;
    })
    $('.back').click(function(){
        var prevId = $(this).parents('.tab-pane').prev().attr("id");
        if(prevId == "step1"){  
            $('.formwizardpopup .modal-content').addClass('banner');
        }
        
        $('[href="#'+prevId+'"]').tab('show'); 
        
    return false;
    })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    //update progress
    var step = $(e.target).data('step');
    var percent = ((parseInt(step) / 6) * 100).toFixed(2);
    
    $('.progress-bar').css({width: percent + '%'});
    $('.progress-bar-info').text("" + percent + "% complete");
    
    //e.relatedTarget // previous tab
    
    })
    $('.first').click(function(){
    $('#myWizard a:first').tab('show')
    })
    })
</script>

</body>
</html> 