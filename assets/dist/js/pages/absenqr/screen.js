var qrcode;
var video_index     = 0;
var video_list      = [];
var default_table   = null;
var time_offset     = 7;
var module_url      = base_url + 'absenqr';
var next_update     = null;
var months          = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
var days            = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

const refreshQRInterval     = 1000; // 1 detik
const checkNewScanInterval  = 1000; // 1 detik

$(document).ready(function () {
    // default html bila table pegawai kosong
    default_table = $('.table-res').html();

    // daftar nama-nama video
    video_list = [
        '01.mp4',
        '02.mp4',
        '03.mp4'
    ];

    video_index = 0;

    // set to fullscreen
    _switchFullScreen();

    // initial qr request
    _get_new_qr();

    // initialize qr code renderer
    qrcode = new QRCode(document.getElementById("img-qr"), {
        width : 370,
        height : 370
    });

    // load video pertama
    _play_video(video_index);

    // standard time & attendance
    setInterval(function(){
        _showDateTime();
    }, 1000);

    // generate QR
	setInterval(function(){
        date_now = new Date();
        
        if(date_now >= next_update || next_update == null){
            _get_new_qr();
        }

        // _get_attendances();
    }, refreshQRInterval);

    // trigger checker
    setInterval(function(){
        _get_trigger();
    }, checkNewScanInterval);
});

$('#promo-video').on('ended', function(){
    if(video_index == (video_list.length - 1)){
        video_index = 0;
        _play_video(video_index);
    }else{
        video_index++;
        _play_video(video_index);
    }
});

$(document).on('mouseover', '#img-qr', function(){
    $(this).removeAttr('title');
});

// update qr secara berkala (tanpa aktivitas pegawai)
function _get_new_qr(){
    
    $.ajax({
        url: url_qr + '?token=' + token,
        dataType: 'json',
        data: { 
            id_display: screen_id,
            time_offset: time_offset
        },
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
        }else{
            $('.table-res').html(default_table);
        }
    });
}

// mendapatkan trigger apabila qr code sudah direfresh
function _get_trigger(){
    $.ajax({
        url: url_trigger + '?token=' + token,
        dataType: 'json',
        data: { id_display: screen_id },
        success: function(d){
            if(d.status){
                _get_new_qr();
                console.info('Someone has scanned');
            }
        }
    });
}

function _play_video(index = 0){
    $('#promo-video').attr('src', url_video + video_list[index]);
    $('#promo-video').get(0).play();
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

    // dapatkan suffix keterangan waktu
    var suffix  = 'LT';
    switch(getTimezoneOffset()){
        case '+0700':
            suffix = 'WIB';
            time_offset = 7;
            break;
        case '+0800':
            suffix = 'WITA';
            time_offset = 8;
            break;
        case '+0900':
            suffix = 'WIT';
            time_offset = 9;
            break;
    }

    $('#time').html(curr_hour + ":" + curr_minute + ' ' + suffix);
    $("#date").html(days[n]+", " + " " + _addZero(day) + " " + months[month] + " " + year);	
}

function _addZero(i){
    if (i < 10) { i = "0" + i; }

    return i;
}

function getTimezoneOffset() {
    function z(n){
        return (n<10? '0' : '') + n
    }

    var offset = new Date().getTimezoneOffset();
    var sign = offset < 0 ? '+' : '-';
    offset = Math.abs(offset);
    return sign + z(offset/60 | 0) + z(offset%60);
}
// END NON CORE FEATURES
