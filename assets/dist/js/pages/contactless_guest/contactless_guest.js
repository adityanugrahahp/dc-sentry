var qrcode;
var is_first        = true;
var is_confirmed    = false;
var access_id       = null;
var refeshInterval  = null;

const intervalAccessChecker = 10000; // 10 detik

$(document).ready(function () {
    $(".datepicker").datepicker({ 
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
    });

    $('.btn-submit').addClass('disabled');
    $('.btn-submit').prop('disabled', true);

    $('.sel-pertanyaan-1').change();

    // initialize qr code renderer
    qrcode = new QRCode(document.getElementById("img-qr"), {
        width : 200,
        height : 200
    });
});

$(window).on('beforeunload', function(){
    if(is_confirmed){
        return 'Anda masih berada dalam gedung, QR ini akan digunakan untuk checkout. Tinggalkan Halaman?';
    }
});

$(document).on('change', '.sel-pertanyaan-1', function(){
    var value = $(this).val();

    if(value == 'Y'){
        $('.box-detail-penyakit').show();
        $('input[name="jawaban_1"]').val('');
    }else{
        $('.box-detail-penyakit').hide();
        $('input[name="jawaban_1"]').val('Tidak Ada');
    }
});

$(document).on('change', 'input[name="is_agreed"]', function(){
    if($(this).is(':checked')){
        $('.btn-submit').removeClass('disabled');
        $('.btn-submit').prop('disabled', false);
    }else{
        $('.btn-submit').addClass('disabled');
        $('.btn-submit').prop('disabled', true);
    }
});

$(document).on('click', '.btn-submit', function(){
    var url     = $('#form-daftar').attr('action');
    var data    = $('#form-daftar').serializeArray();

    // hide tombol submit
    $('.btn-submit').hide();

	$.post(url, data, function(d){
        if(d.status){
            Swal.fire('Berhasil Mendaftarkan', 'Form Pendaftaran Anda telah kami terima.', 'success').then(() => {
                // hide form
                $('.card-form').hide();
                $('.card-qr').show();

                is_confirmed    = true;
                access_id       = d.access;

                // start setInterval
                refeshInterval = setInterval(function(){
                    _check_status();
                }, intervalAccessChecker);
            });
        }else{
            Swal.fire('Terjadi Kesalahan', d.msg, 'error').then(() => {
                $('.btn-submit').show();
            });
        }
    });
});

$(document).on('click', '.rad', function(){
    if($(this).val() == 'Ya'){
        $("#form1").show();
    }else{
        $("#form1").hide();
    }
});

$(document).on('click', '.radperjalanan', function(){
    if($(this).val() == 'Ya'){
        $("#formperjalanan1").show();
    }else{
        $("#formperjalanan1").hide();
    }
});

$(document).on('click', '.radstatus', function(){
    if($(this).val() == 'Ya'){
        $("#formstatus1").show();
    }else{
        $("#formstatus1").hide();
    }
});

function _check_status(){
    $.post(url_cheker, {id: access_id}, function(d){
        if(d.status){
            if(d.kategori == 'checkin'){
                $('.box-waiting, .box-thanks').hide();
                $('.box-qr').show();

                // generate qrcode
                qrcode.makeCode(d.data.kode);

                // tampilkan konfirmasi saat akan menutup halaman
                is_confirmed = true;

                $('.visitor-detail').eq(0).text(d.data.kode);
                $('.visitor-detail').eq(1).text(d.data.nama + ' - ' + d.data.since);

                // download box qr untuk user saat pertama kali qr muncul
                if(is_first){
                    _screenshot();
                    is_first = false;

                    $('.btn-download').show();
                }
            }
        }else{
            if(d.kategori == 'checkout'){
                is_confirmed = false;

                // masukkan tanggal saat ini
                now = new Date();
                date_text = _addZero(now.getDate()) + '/' + _addZero(now.getMonth()) + '/' + now.getFullYear() + ' ' + _addZero(now.getHours()) + ':' + _addZero(now.getMinutes());
                $('#checkout-detail').text(date_text);

                $('.box-waiting, .box-qr').hide();
                $('.box-thanks').show();
                
                // stop interval
                clearInterval(refeshInterval);
            }
        }
    });
}

function _addZero(i){
    if (i < 10) { i = "0" + i; }

    return i;
}

function _screenshot(){
    html2canvas(document.getElementById('screenshot-wrapper')).then(function(canvas) {
        return Canvas2Image.saveAsPNG(canvas);
    });
}