<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Registrasi Visitor - PT. PELNI</title>

    <link rel="shortcut icon" href="<?php base_url('') ?>assets/favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="<?php base_url(''); ?>assets/css/dist/bootstrap.css" rel="stylesheet">
    <link href="<?php base_url(''); ?>assets/css/dist/boxicons/css/boxicons.min.css"  rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

    <style>

      body {
        background: url('<?php base_url('') ?>assets/images/background/6.jpg') no-repeat;
        background-size: 100% 100%;
        background-attachment:fixed;
        }

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      body {
            min-height: 0rem;
            padding-top: 4.5rem;
          }
      main > .container {
            padding: 60px 15px 0;
          }    
      .footer {
            background-color: #f5f5f5;
          }

          .footer > .container {
            padding-right: 15px;
            padding-left: 15px;
          }

          code {
            font-size: 80%;
          }
    </style>
    <!-- Custom styles for this template -->
    <!-- <link href="<?php base_url('') ?>assets/css/navbar-top-fixed.css" rel="stylesheet"> -->
  </head>
  <body>
    <div class="container"> 
        <nav class="navbar fixed-top navbar-light bg-light">
            <a class="navbar-brand" href="#">
              <img src="<?php base_url('') ;?>assets/favicon.ico" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
              PT. Pelayaran Nasional Indonesia (Persero)
            </a>
          </nav>
    </div>

<main role="main" class="container">
  <div class="row">
    <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="jumbotron">
          <h1>Form Registrasi Pengunjung</h1><hr class="my-4">
          <div class="alert alert-info alert-dismissible fade show" role="alert">
              <b>Silakan lengkapi identitas tamu pada form di bawah ini.</b>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <form method="post" action="#" id="Daftar">
            <div class="form-group">
              <div class="row">
                <div class="col">
                  <label><b>NIK </b><span style="color:red">*</span></label>
                <input type="text" name="ISI_DISINI" class="form-control" placeholder="Masukan NIK anda" required>
                </div>
                <div class="col">
                  <label><b>Nama Lengkap </b><span style="color:red">*</span></label>
                <input type="text" name="ISI_DISINI" class="form-control" placeholder="Masukan Nama Lengkap anda" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label><b>Alamat </b><span style="color:red">*</span></label>
              <textarea class="form-control" name="ISI_DISINI" aria-label="With textarea" placeholder="Masukan Alamat anda" required></textarea>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col">
                  <label><b>No. Hp </b><span style="color:red">*</span></label>
                <input type="text" name="ISI_DISINI" class="form-control" placeholder="Masukan No. Hp anda" required>
                </div>
                <div class="col">
                  <label><b>Jenis Kelamin </b><span style="color:red">*</span></label>
                    <select required class="form-control" name="ISI_DISINI" required>
                      <option value="L">Laki-laki</option>
                      <option value="P">Perempuan</option>
                    </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <div class="col">
                  <label><b>Lantai </b><span style="color:red">*</span></label>
                  <?php echo form_dropdown('tujuan', $tujuan, null, 'class="form-control"') ?>
                </div>
                <div class="col">
                  <label><b>Keperluan </b><span style="color:red">*</span></label>
                    <textarea class="form-control" name="ISI_DISINI" aria-label="With textarea" placeholder="Masukan Keperluan anda" required></textarea>
                </div>
              </div>
            </div>

            <hr>
            <div class="form-group">
              <label><b>Apakah ada riwayat sakit 1 minggu terakhir? <span style="color:red">*</span></b></label>
              <input type="text" class="form-control" name="pertanyaan_1" value="Apakah ada riwayat sakit 1 minggu terakhir?" hidden="">
              <input type="text" name="ISI_DISINI" class="form-control" placeholder="(Demam, Batuk, Sesak, lemas, Diare)">
            </div>


            <div class="form-group">
              <label><b>Apakah sudah pernah melakukan raid test/SWAB? <span style="color:red">*</span></b></label><br>
              <input type="text" class="form-control" name="pertanyaan_2" value="Apakah sudah pernah melakukan raid test/SWAB?" hidden="">
              <div class="row">
                <div class="col-md-2">
                  <input type="radio" name="rad" id="rad1" value="1" class="rad"/>Ya
                </div>
                <div class="col-md-2">
                  <input type="radio" name="rad" id="rad2" value="2" class="rad"/> Tidak
                </div>
              </div>
              <div id="form1" style="display:none">
                <div class="row">
                  <div class="col">
                    <label><b>Kapan rapid test/SWAB? <span style="color:red">*</span></b></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class='bx bx-calendar'></i></span>
                      </div>
                      <input type="text" name="ISI_DISINI" class="form-control datepicker" placeholder="MM-DD-YYYY">
                    </div>
                  </div>
                  <div class="col">
                    <label><b>Hasil </b><span style="color:red">*</span></label>
                    <input type="text" name="ISI_DISINI" class="form-control" placeholder="(Positif / Negatif)">
                  </div>
                </div>
              </div>

              <div id="form2" style="display:none">
                <input type="text" class="form-control" hidden="">
              </div>
            </div>

            <div class="form-group">
              <label><b>Apakah pernah ada penetapan status anda ODP/PDP/Covid? <span style="color:red">*</span></b></label><br>
              <input type="text" class="form-control" name="pertanyaan_3" value="Apakah pernah ada penetapan status anda ODP/PDP/Covid?" hidden="">
              <div class="row">
                <div class="col-md-2">
                  <input type="radio" name="radstatus" id="radstatus1" value="1" class="radstatus"/>Ya
                </div>
                <div class="col-md-2">
                  <input type="radio" name="radstatus" id="radstatus2" value="2" class="radstatus"/> Tidak
                </div>
              </div>
              <div id="formstatus1" style="display:none">
                <div class="row">
                  <div class="col">
                    <label><b>Dari <span style="color:red">*</span></b></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class='bx bx-calendar'></i></span>
                      </div>
                      <input type="text" name="ISI_DISINI" class="form-control datepicker" placeholder="MM-DD-YYYY">
                    </div>
                  </div>
                  <div class="col">
                    <label><b>Sampai </b><span style="color:red">*</span></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class='bx bx-calendar'></i></span>
                      </div>
                      <input type="text" name="ISI_DISINI" class="form-control datepicker" placeholder="MM-DD-YYYY">
                    </div>
                  </div>
                </div>
              </div>

              <div id="formstatus2" style="display:none">
                <input type="text" class="form-control" hidden="">
              </div>
            </div>

            <div class="form-group">
              <label><b>Apakah ada riwayat perjalanan ke/dari luar negeri dalam 1 minggu terakhir? <span style="color:red">*</span></b></label><br>
              <input type="text" class="form-control" name="pertanyaan_4" value="Apakah ada riwayat perjalanan ke/dari luar negeri dalam 1 minggu terakhir?" hidden="">
              <div class="row">
                <div class="col-md-2">
                  <input type="radio" name="radperjalanan" id="radperjalanan1" value="1" class="radperjalanan"/>Ya
                </div>
                <div class="col-md-2">
                  <input type="radio" name="radperjalanan" id="radperjalanan2" value="2" class="radperjalanan"/> Tidak
                </div>
              </div>
              <div id="formperjalanan1" style="display:none">
                    <label><b>Dari </b><span style="color:red">*</span></label>
                    <input type="text" name="ISI_DISINI" class="form-control" placeholder="(Malaysia, Singapura, Thailand, China, USA)">
              </div>

              <div id="formperjalanan2" style="display:none">
                <input type="text" class="form-control" hidden="">
              </div>
            </div><hr>



            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" required>
              <label class="form-check-label"><b>Pernyataan mengisi dengan benar. Jika ada kesalahan bersedia dituntut sesuai hukum yang berlaku? <span style="color:red">*</span></b></label>
            </div>

            <br><button type="submit" class="btn btn-primary btn-lg btn-block">Daftar</button>
          </form>
        </div>
      </div>
    </main>
  </div>

<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted"><strong>&copy; <?php echo date('Y') ?> - <a href="http://pelni.co.id">PT. Pelayaran Nasional Indonesia (Persero))</a></strong></span>
  </div>
</footer>

      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="<?php base_url('') ?>assets/js/dist/jquery.slim.min.js"><\/script>')</script><script src="<?php base_url('') ?>assets/js/dist/js/bootstrap.bundle.js"></script>

      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
      <script src="<?= base_url(THEME_PATH); ?>dist/js/pages/contactless_guest/contactless_guest.js"></script>
      <script src="<?php base_url('') ?>assets/js/dist/js/moment.js"></script>
      <script src="<?php base_url('') ?>assets/js/jquery-3.3.1.min.js"></script>
      <script src="<?php base_url('') ?>assets/js/bootstrap.min.js"></script>
      <script src="<?php base_url('') ?>assets/js/bootstrap-datepicker.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <!-- <script type="text/javascript">
      $(function(){
        $(".rad").click(function(){
          $("#form1, #form2").hide()
          if($(this).val() == "1"){
            $("#form1").show();
          }else{
            $("#form2").show();
          }
        });
      });
    </script> -->

    <!-- <script type="text/javascript">
      $(function(){
        $(".radstatus").click(function(){
          $("#formstatus1, #formstatus2").hide()
          if($(this).val() == "1"){
            $("#formstatus1").show();
          }else{
            $("#formstatus2").show();
          }
        });
      });
    </script> -->

    <!-- <script type="text/javascript">
      $(function(){
        $(".radperjalanan").click(function(){
          $("#formperjalanan1, #formperjalanan2").hide()
          if($(this).val() == "1"){
            $("#formperjalanan1").show();
          }else{
            $("#formperjalanan2").show();
          }
        });
      });
    </script> -->
    <!-- <script type="text/javascript">
      $(document).ready(function () {
      // datetimepicker initialization
      $(".datepicker").datetimepicker({ format: 'MM-DD-YYYY' });
      });
    </script> -->
</body>
</html>
