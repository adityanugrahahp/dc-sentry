<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registrasi Visitor - PT. PELNI</title>
    <link rel="shortcut icon" href="<?= base_url(THEME_PATH); ?>favicon.ico">
    <link href="<?= base_url(THEME_PATH); ?>css/dist/bootstrap.css" rel="stylesheet">
    <link href="<?= base_url(THEME_PATH); ?>css/dist/boxicons/css/boxicons.min.css"  rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    
    <style>
        body {
            background: url('<?= base_url(THEME_PATH); ?>image/background/6.jpg') no-repeat;
            background-size: cover;
            background-attachment:fixed;
            min-height: 0rem;
            padding-top: 4.5rem;
            font-family: 'Roboto';
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
</head>
<body>
    <div class="container"> 
        <nav class="fixed-top navbar-light bg-light py-2">
            <center>
                <a class="navbar-brand" href="<?= current_url() ?>">
                    <img src="<?= base_url(THEME_PATH); ?>favicon.ico" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                    <b>Admittance Center</b>
                </a>
            </center>
        </nav>
    </div>

    <main role="main" class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-form" style="margin-bottom: 50px;">
                    <div class="card-header">
                        <h5 class="pt-2"><b>Form Registrasi Pengunjung</b></h5>
                    </div>
                    <form id="form-daftar" action="<?= base_url('contactless_guest/ajax_post_form')?> ">
                        <div class="card-body">
                            <div id="formhide">
                                <!-- FORM DATA DIRI -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam vero necessitatibus aliquam, blanditiis totam rerum quod ea ab labore non amet est dolores minus voluptatem nisi et veritatis quos doloremque?</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label><b>NIK </b><span style="color:red">*</span></label>
                                            <input type="hidden" name="id_petugas" value="<?= $id_petugas ?>">
                                            <input type="text" name="nik" class="form-control" placeholder="Masukan NIK anda">
                                            <?= form_error('nik', '<small class="text-danger pl-3">','</small>'); ?>
                                        </div>
                                        <div class="col">
                                            <label><b>Nama Lengkap </b><span style="color:red">*</span></label>
                                            <input type="text" name="nama" class="form-control" placeholder="Masukan Nama Lengkap anda" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><b>Alamat </b><span style="color:red">*</span></label>
                                    <textarea class="form-control" name="alamat" aria-label="With textarea" placeholder="Masukan Alamat anda" ></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label><b>No. Hp </b><span style="color:red">*</span></label>
                                            <input type="text" name="no_hp" class="form-control" placeholder="Masukan No. Hp anda" >
                                        </div>
                                        <div class="col">
                                            <label><b>Jenis Kelamin </b><span style="color:red">*</span></label>
                                            <select required class="form-control" name="jenis_kelamin" >
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
                                            <textarea class="form-control" name="keperluan" rows="1" aria-label="With textarea" placeholder="Masukan Keperluan anda" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- END FORM DATA DIRI -->
                                <hr>
                                <!-- FORM DEKLARASI KESEHATAN -->
                                <div class="form-group">
                                    <label><b>Apakah ada riwayat sakit 1 minggu terakhir? <span style="color:red">*</span></b></label>
                                    <input type="text" class="form-control" name="pertanyaan_1" value="Apakah ada riwayat sakit 1 minggu terakhir?" hidden="">
                                    <input type="text" name="jawaban_1" class="form-control" placeholder="(Demam, Batuk, Sesak, lemas, Diare)">
                                </div>
                                <div class="form-group">
                                    <label><b>Apakah sudah pernah melakukan Rapid Test / SWAB Test terkait COVID-19? <span style="color:red">*</span></b></label><br>
                                    <input type="text" class="form-control" name="pertanyaan_2" value="Apakah sudah pernah melakukan Rapid Test / SWAB Test terkait COVID-19?" hidden="">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="radio" name="jawaban_2" value="Ya" class="rad" /> Ya
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" name="jawaban_2" value="Tidak" class="rad" /> Tidak
                                        </div>
                                    </div>
                                    <div id="form1" style="display:none">
                                        <div class="row">
                                            <div class="col">
                                                <label><b>Kapan Rapid Test / SWAB Test dilakukan? <span style="color:red">*</span></b></label>
                                                <input type="hidden" name="keterangan_2[]" value="Kapan Rapid Test / SWAB Test dilakukan?">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class='bx bx-calendar'></i></span>
                                                    </div>
                                                    <input type="text" name="jawaban_keterangan_2[]" class="form-control datepicker" placeholder="MM-DD-YYYY">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label><b>Hasil </b><span style="color:red">*</span></label>
                                                <input type="hidden" name="keterangan_2[]" value="Hasil">
                                                <?= form_dropdown('jawaban_keterangan_2[]', ['Negatif' => 'Negatif', 'Positif' => 'Positif'], null, 'class="form-control"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><b>Apakah pernah ada penetapan status anda ODP/PDP/Covid? <span style="color:red">*</span></b></label><br>
                                    <input type="text" class="form-control" name="pertanyaan_3" value="Apakah pernah ada penetapan status anda ODP/PDP/Covid?" hidden="">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="radio" name="jawaban_3" value="Ya" class="radstatus"/> Ya
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" name="jawaban_3" value="Tidak" class="radstatus"/> Tidak
                                        </div>
                                    </div>
                                    <div id="formstatus1" style="display:none">
                                        <div class="row">
                                            <div class="col">
                                                <label><b>Dari <span style="color:red">*</span></b></label>
                                                <input type="hidden" name="keterangan_3[]" value="Dari">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class='bx bx-calendar'></i></span>
                                                    </div>
                                                    <input type="text" name="jawaban_keterangan_3[]" class="form-control datepicker" placeholder="MM-DD-YYYY">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label><b>Sampai </b><span style="color:red">*</span></label>
                                                <input type="hidden" name="keterangan_3[]" value="Sampai">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class='bx bx-calendar'></i></span>
                                                    </div>
                                                    <input type="text" name="jawaban_keterangan_3[]" class="form-control datepicker" placeholder="MM-DD-YYYY">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><b>Apakah ada riwayat perjalanan ke/dari luar negeri dalam 1 minggu terakhir? <span style="color:red">*</span></b></label><br>
                                    <input type="text" class="form-control" name="pertanyaan_4" value="Apakah ada riwayat perjalanan ke/dari luar negeri dalam 1 minggu terakhir?" hidden="">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="radio" name="jawaban_4" value="Ya" class="radperjalanan"/> Ya
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" name="jawaban_4" value="Tidak" class="radperjalanan"/> Tidak
                                        </div>
                                    </div>
                                    <div id="formperjalanan1" style="display:none">
                                        <label><b>Dari </b><span style="color:red">*</span></label>
                                        <input type="hidden" name="keterangan_4[]" value="Dari">
                                        <input type="text" name="jawaban_keterangan_4[]" class="form-control" placeholder="(Malaysia, Singapura, Thailand, China, USA)">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group form-check">
                                    <input type="checkbox" name="is_agreed" class="form-check-input" >
                                    <label class="form-check-label"><b>Pernyataan mengisi dengan benar. Jika ada kesalahan bersedia dituntut sesuai hukum yang berlaku? <span style="color:red">*</span></b></label>
                                </div>
                                <!-- FORM DEKLARASI KESEHATAN -->
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="javascript:void(0)" class="btn btn-primary btn-lg btn-block btn-submit" disabled>Daftar</a>
                        </div>
                    </form>
                </div>
                <div class="card card-qr" style="margin-bottom: 50px;display:none;">
                    <div class="card-body box-waiting text-center">
                        <h5><b>Silakan Menunggu</b></h5>
                        <hr>
                        <span class="clearfix">
                            Resepsionis kami akan memanggil Anda ketika form pendaftaran Anda telah disetujui, siapkan tanda pengenal Anda (KTP / SIM / Passpor / ID Lainnya). Anda akan mendapatkan <b>Virtual Visitor Card</b> berupa QR Code yang digunakan untuk checkout.
                        </span>
                        <div class="row">
                            <div class="col-lg-12">
                                <img src="<?= base_url(THEME_PATH); ?>image/alertbox/waiting.png" class="img-fluid" alt="Waiting" height="150px" loading="lazy">
                            </div>
                            <div class="col-lg-12">
                                <span>
                                    <i class="fa fa-refresh fa-fw fa-spin fa-2x text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body box-qr text-center" style="display:none;">
                        <h5><b>Virtual Visitor Card</b></h5>
                        <hr>
                        <span class="clearfix">
                            <b>PERHATIAN: </b>
                            Untuk memudahkan proses checkout, jangan menutup halaman ini selama berada di dalam gedung. QR yang Anda miliki akan digunakan untuk checkout.
                        </span>
                        <div class="row">
                            <div class="col-lg-12 py-2">
                                <center>
                                    <div id="img-qr"></div>
                                    <br>
                                    <b class="visitor-detail"></b>
                                    <br>
                                    <small class="visitor-detail"></small>
                                </center>
                            </div>
                            <div class="col-lg-12">
                                <small class="text-primary">Selalu gunakan masker, menjaga jarak aman dan mencuci tangan selama berada di dalam gedung ini.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer fixed-bottom py-1 mt-auto" >
        <div class="container">
            <center><strong>&copy; <?= date('Y') ?> - <a href="https://www.pelni.co.id">PT. Pelayaran Nasional Indonesia (Persero)</a></strong></center>
        </div>
    </footer>

    <script>
        var url_cheker = '<?= base_url('contactless_guest/ajax_check_status') ?>';
    </script>
    <script src="<?= base_url(THEME_PATH); ?>js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url(THEME_PATH); ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url(THEME_PATH); ?>js/dist/js/moment.js"></script>
    <script src="<?= base_url(THEME_PATH); ?>js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
	<script src="<?= base_url(THEME_PATH); ?>dist/js/pages/absenqr/qrcode.min.js"></script>
    <script src="<?= base_url(THEME_PATH); ?>dist/js/pages/contactless_guest/contactless_guest.js"></script>
</body>
</html>