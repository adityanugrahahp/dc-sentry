var module_url  = base_url + 'absenqr';
var next_update = null;

const refreshQRInterval = 1000; // 1 detik

$(document).ready(function () {
	setInterval(function(){
        date_now = new Date();
        if(date_now >= next_update || next_update == null){
            _get_new_qr();

            console.info('Next Update:', next_update);
        }
    }, refreshQRInterval);
});

// update qr secara berkala (tanpa aktivitas pegawai)
function _get_new_qr(){
    $.get(module_url + '/ajax_generate_qr/1', function(d){
        if(d.status){
            // update tampilan qrcode di screen
            $('.img-qr').attr('src', d.data.qr);
            next_update = new Date(d.data.next_request);
        }
    });
}