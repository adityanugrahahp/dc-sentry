var qrcode;
var video_index     = 0;
var news_index      = 0;
var video_list      = [];
var news_list       = [];
var default_table   = null;
var time_offset     = 7;
var module_url      = base_url + 'absenqr';
var next_update     = null;
var months          = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
var days            = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
var display_lat     = 10;
var display_lon     = 10;

const refreshQRInterval         = 1000; // 1 detik
const checkNewScanInterval      = 3000; // 3 detik
const attendanceListInterval    = 4000; // 4 detik
const newsListInterval          = 7200000; // 2 jam
const slideShowNewsInterval     = 5000; // 5 detik untuk slideshow berita

$(document).ready(function () {
    // get current position
    // _getGeoLocationDisplay();
    
    // default html bila table pegawai kosong
    default_table = $('.table-res').html();

    // daftar nama-nama video
    video_list = [
      '00.mp4',
    ];

    video_index = 0;
    news_index = 0;

    // bila next_update masih kosong, maka update jadi +5 detik
    if(next_update == null){
        next_update = new Date();
        next_update.setDate(next_update.getSeconds() + 5);
    }

    // set to fullscreen
    _switchFullScreen();

    // initial qr request
    _get_new_qr();
    _fetchNewsList();

    // initialize qr code renderer
    qrcode = new QRCode(document.getElementById("img-qr"), {
        width : 370,
        height : 370
    });

    try {
      // tampilkan qr pedulilindungi
      qrcode_pl = new QRCode(document.getElementById("img-qr-pl"), {
          width : 210,
          height : 210
      });
      qrcode_pl.makeCode('checkin:614a66914386fd008e3a898f');
    } catch (error) {
      console.log(error);
    }

    // load video pertama
    _play_video(video_index);

    // untuk slideshow berita
    _change_news_slideshow(news_index);

    setInterval(() => {
      if(news_index != (news_list.length - 1)){
        news_index++;
      }else{
        news_index = 0;
      }

      _change_news_slideshow(news_index);
    }, slideShowNewsInterval);

    // standard time & attendance
    setInterval(function(){
        _showDateTime();
    }, 1000);

    // fetch news data
    setInterval(() => {
      _fetchNewsList();
    }, newsListInterval);

    // generate QR
    setInterval(function(){
        date_now = new Date();
        console.log('NOW: ' + date_now);
        console.log('NEXT: ' + next_update);
        
        if(date_now >= next_update){
            _get_new_qr();
        }
    }, refreshQRInterval);

    // data pengabsen
    setInterval(function(){
        _get_attendances(false);
    }, attendanceListInterval);

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

// news list
function _fetchNewsList(){
  $.ajax({
    url: url_news,
    dataType: 'json',
    success: function(d){
      if(d.error_code == 0){
        news_list = d.data;
      }
    }
});
}

// geolocation
function _getGeoLocationDisplay(){
  if (navigator.geolocation) {
    try {
      navigator.geolocation.getCurrentPosition(function(p){
        
        display_lat = p.coords.latitude;
        display_lon = p.coords.longitude;

      }, function(error){
        if(error.PERMISSION_DENIED){
          alert("ERROR: Mohon izinkan akses lokasi pada display absensi");
        }
      });
    } catch (error) {
      alert(`ERROR: ${error.message}`);
    }
  } else { 
    alert("Geolocation is not supported by this browser.");
  }
}

// update qr secara berkala (tanpa aktivitas pegawai)
function _get_new_qr(){
    
    $.ajax({
        url: url_qr + '?token=' + token + '&lat_lon=' + [display_lat, display_lon].join(':'),
        dataType: 'json',
        data: { 
            id_display: screen_id,
            time_offset: time_offset,
            timestamp: Math.round(+new Date()/1000)
        },
        success: function(d){
            if(d.status){
                // update tampilan qrcode di screen
                if(display_lat != 0 && display_lon != 0){
                  qrcode.makeCode(d.data.qr);
                  $('#img-qr').show();
                  $('#user-no-location').hide();
                }else{
                  $('#img-qr').hide();
                  $('#user-no-location b').html('Terjadi Kesalahan');
                  $('#user-no-location p').html('Mohon ijinkan akses lokasi pada display ini untuk dapat menampilkan QR Code');
                  $('#user-no-location').show();
                }

                next_update = new Date(d.data.next_request);
            }
        }
    });
}

// fetch data user yang sudah melakukan absensi
function _get_attendances(is_table = true){
    if(is_table){
        endpoint_url = url_ws + '/get_latest_attendance_table' + '?token=' + token;
    }else{
        endpoint_url = url_ws + '/get_latest_attendance' + '?token=' + token;
    }

    $.post(endpoint_url, {display_id:screen_id}, function(d){
        if(d.status){
          var _temp_component = '';

          if(d.data.length > 0){
            // render tabel
            $('.table-res').empty();
  
            // buat list card untuk pegawai yang sudah absen
            $.each(d.data, function(_i, v){
              _temp_component += `
                <div class="col-lg-4">
                  <div class="card" style="box-shadow: rgba(1, 1, 0.5, 0.4) 0px 7px 29px 0px;">
                    <div class="card-body p-2">
                      <div class="container" style="height:50px;">
                        <div class="row align-items-center h-100">
                          <div class="col-lg-12" style="overflow:hidden; max-width:340px;white-space:nowrap">
                            <h6><b>${v.nama_lengkap}</b></h6>
                            <h6 class="small text-danger">
                              <b>${v.unit_kerja}</b>
                            </h6>
                            <h6 class="small">
                              NRP: ${v.nrp}
                              &middot;
                              <b>${v.waktu_absen}</b>
                            </h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              `;
            });
  
            $('.table-res').html(`<div class="row pr-2">${_temp_component}</div>`);
          }
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

function _change_news_slideshow(index = 0){
  try {
    if(news_list.length > 0){
      // parse tanggal
      const date = moment(news_list[index].date, 'YYYY-MM-DD');
      moment.updateLocale('id', {
        weekdays: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        months: [
          'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ],
        monthsShort: [
          'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
          'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ]
      });

      // looping data berita untuk ditampilkan pada halaman berita
      $('.news-list-item').eq(0).attr('style', `background: url('${news_list[index].cover}') center;background-size:cover;`)
      $('.news-list-item-title').eq(0).html(news_list[index].title);
      $('.news-list-item-date').eq(0).html(date.format('dddd, DD MMMM YYYY'));
    }
  } catch (error) {
    console.log(error);
  }
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

    $('#time').html(curr_hour + ":" + curr_minute + ':' + curr_second + ' ' + suffix);
    $("#date").html(days[n]+", " + " " + _addZero(day) + " " + months[month] + " " + year);	

    // dapatkan waktunya, bila di bawah jam 13.00 maka tampilkan pesan selamat datang, bila tidak tampilkan selamat jalan
    if(curr_hour < 13){
      $('#greeter').text("Selamat Datang");
    }else{
      $('#greeter').text("Terima Kasih");
    }
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
