<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistem Antrian</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../Antrian/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../Antrian/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../Antrian/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../Antrian/AdminLTE.min.css">
  <link rel="stylesheet" href="../Antrian/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../Antrian/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="row" style="background-color: white;">
  <div class="col-md-6" style="float:left;">
  <h2 style="padding-left: 50px">Lokasi: Kantor Pusat</h1>
</div>
  <div class="col-md-6" style="text-align: right;">
    <a href="#">
    <h2 style="padding-right:50px">Login<h1>  
    </a>
  </div>
</div>
<div class="row">
  <div class="col-md-4" style="background-color:;">
  </div>
  <div class="col-md-4  ">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><img style="height:100px" src="logo_head.png"></img></a>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body"  style="font-size: 100px;width: 210px;border-radius: 100%;/* text-align: center; *//* right: auto; */margin: 0 auto;">
    	    <p class="" style="text-align: center">10</p>
      </div>
    <div class="body-antrian">
    	   <div class="row"> 
              <div style=" text-align:center">
                <span style="font-size:24px;">Jumlah Antrian: 9</span>
              </div>
    	   </div>
      </div>
    </div>
    <div style="width: 360px; margin:4% auto;">
        <button class="btn btn-primary btn-block btn-flat" style="
        height: 100px;
        font-size: 32px;
        width: 50%;
        background-color: gray;
        border-color: gray; 
        /* text-align: center; */
        margin: 0 auto;
    ">Cetak Tiket</button>
    </div>
  </div>
</div>

<!-- jQuery 3 -->
<script src="../Antrian/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../Antrian/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../Antrian/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
