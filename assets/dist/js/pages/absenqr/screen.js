var module_url  = base_url + 'absenqr';
var next_update = null;
var months      = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
var days        = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];

const refreshQRInterval = 1000; // 1 detik

$(document).ready(function () {
    // set to fullscreen
    _switchFullScreen();

    // standard time
    setInterval(_showDateTime, 1000);

    // generate QR
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
    $.get(module_url + '/ajax_generate_qr/' + screen_id, function(d){
        if(d.status){
            // update tampilan qrcode di screen
            $('.img-qr').attr('src', d.data.qr);
            next_update = new Date(d.data.next_request);
        }
    });
}

function _switchFullScreen() {
    var elem = document.documentElement;

    if(elem.requestFullscreen) {
        elem.requestFullscreen();
    }else if (elem.mozRequestFullScreen) { /* Firefox */
        elem.mozRequestFullScreen();
    }else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
        elem.webkitRequestFullscreen();
    }else if (elem.msRequestFullscreen) { /* IE/Edge */
        elem.msRequestFullscreen();
    }
}

function _showDateTime(){
    
    var today       = new Date();
    var curr_hour   = today.getHours();
    var curr_minute = today.getMinutes();
    var curr_second = today.getSeconds();

    var n       = today.getDay();
    var day     = today.getDate();
    var month   = today.getMonth();
    var year    = today.getFullYear();

    curr_hour   = _addZero(curr_hour);
    curr_minute = _addZero(curr_minute);
    curr_second = _addZero(curr_second);

    $('#time').html(curr_hour + ":" + curr_minute + ":" + curr_second);
    $("#date").html(days[n-1]+", " + " " + _addZero(day) + " " + months[month] + " " + year);	
}

function _addZero(i){
    if (i < 10) { i = "0" + i; }

    return i;
}
