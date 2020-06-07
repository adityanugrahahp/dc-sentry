var qrcode;
var module_url  = base_url + 'absenqr';
var next_update = null;
var months      = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
var days        = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

const refreshQRInterval     = 1000; // 1 detik
const checkNewScanInterval  = 1000; // 1 detik

$(document).ready(function () {
    // set to fullscreen
    _switchFullScreen();

    // initial qr request
    _get_new_qr_self();

    // initialize qr code renderer
    qrcode = new QRCode(document.getElementById("img-qr"), {
        width : 400,
        height : 400
    });

    // standard time & attendance
    setInterval(function(){
        _showDateTime();
    }, 1000);

    // generate QR
	setInterval(function(){
        date_now = new Date();
        if(date_now >= next_update || next_update == null){
            _get_new_qr_self();
            _get_attendances();
        }
    }, refreshQRInterval);

    // trigger checker
    setInterval(function(){
        _get_trigger_self();
    }, checkNewScanInterval);
});

// update qr secara berkala (tanpa aktivitas pegawai)
function _get_new_qr(){
    
    $.ajax({
        url: url_qr,
        crossDomain: true,
        headers: { 
            'Token': token,
            'Access-Control-Allow-Origin':'*',
            'Access-Control-Allow-Methods':'GET',
            'Access-Control-Allow-Headers':'application/json'
        },
        dataType: 'json',
        data: { id_display: screen_id },
        success: function(d){
            if(d.status){
                // update tampilan qrcode di screen
                qrcode.makeCode(d.data.qr);
                next_update = new Date(d.data.next_request);
            }
        }
    });
}

// fetch data user yang sudah melakukan absensi
function _get_attendances(){
    $.post(module_url + '/ajax_get_latest_attendee', {display_id:screen_id}, function(d){
        if(d.status){
            // render tabel
            $('.table-res').html(d.data);
        }
    });
}

// mendapatkan trigger apabila qr code sudah direfresh
function _get_trigger(){
    $.ajax({
        url: url_trigger,
        headers: { 
            'Token': token,
            'Access-Control-Allow-Origin':'*',
            'Access-Control-Allow-Methods':'GET',
            'Access-Control-Allow-Headers':'application/json'
        },
        dataType: 'json', // Notice! JSONP <-- P (lowercase)
        data: { id_display: screen_id },
        success: function(d){
            if(d.status){
                _get_new_qr();
                console.info('Someone has scanned');
            }
        }
    });
}

// SELF FUNCTIONS
function _get_new_qr_self(){
    $.get(module_url + '/ajax_generate_qr/' + screen_id, function(d){
        if(d.status){
            // update tampilan qrcode di screen
            qrcode.makeCode(d.data.qr);
            next_update = new Date(d.data.next_request);
        }
    });
}

function _get_trigger_self(){
    $.get(module_url + '/ajax_get_trigger/' + screen_id, function(d){
        if(d.status){
            _get_new_qr_self();
            console.info('Someone has scanned');
        }
    });
}
// END SELF FUNCTIONS

// NON CORE FEATURES
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

    $('#time').html(curr_hour + ":" + curr_minute + ":" + curr_second + ' WIB');
    $("#date").html(days[n]+", " + " " + _addZero(day) + " " + months[month] + " " + year);	
}

function _addZero(i){
    if (i < 10) { i = "0" + i; }

    return i;
}
// END NON CORE FEATURES
