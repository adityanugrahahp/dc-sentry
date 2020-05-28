<<<<<<< HEAD
var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
		var days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
		
		var date = new Date();
		var n = date.getDay();
		var day = date.getDate();
		var month = date.getMonth();
		var year = new Date().getFullYear();

// $(document).ready(function () {
	document.getElementById("date").innerHTML=days[n-1]+", "+" "+day+" "+months[month]+" "+year;	
// });



function showTime(){
			var a_p = "";
			var today = new Date();
			var curr_hour = today.getHours();
			var curr_minute = today.getMinutes();
			var curr_second = today.getSeconds();

			// if (curr_hour<12) {
			// 	a_p = "AM";
			// }else {
			// 	a_p = "PM";
			// }

			// if (curr_hour == 0) {
			// 	curr_hour=12;
			// }
			// if (curr_hour == 12) {
			// 	curr_hour=curr_hour-12;
			// }
			curr_hour = checkTime(curr_hour);
			curr_minute = checkTime(curr_minute);
			curr_second = checkTime(curr_second);

			document.getElementById('time').innerHTML= curr_hour+":"+curr_minute+":"+curr_second+" "+a_p;
		}

function checkTime(i){
		if (i<10) {
			i = "0"+i;
		}
		return i;
		}
setInterval(showTime,500);
=======
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
>>>>>>> ce0ed2837432b5f6ed79cdd008cc376f95531d1c
