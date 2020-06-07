
const intervalAccessChecker = 15000; // 15 detik

$(document).ready(function () {
    $(".datepicker").datepicker({ 
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
    });

    $('.btn-submit').addClass('disabled');
    $('.btn-submit').prop('disabled', true);
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
            Swal.fire('Berhasil Mendaftarkan', 'Form Pendaftaran Anda akan kami review, silakan menuju meja resepsonis untuk mendapatkan akses.', 'success').then(() => {
                // hide form
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