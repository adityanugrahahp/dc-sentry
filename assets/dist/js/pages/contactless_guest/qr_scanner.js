var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
var days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        
var date = new Date();
var n = date.getDay();
var day = date.getDate();
var month = date.getMonth();

function showTime(){
    var a_p = "";
    var today = new Date();
    var year    = today.getFullYear();
    var curr_hour = today.getHours();
    var curr_minute = today.getMinutes();
    var curr_second = today.getSeconds();
    curr_hour = checkTime(curr_hour);
    curr_minute = checkTime(curr_minute);
    curr_second = checkTime(curr_second);

    document.getElementById('time').innerHTML=days[n]+", "+" "+day+" "+months[month]+" "+year+" -"+curr_hour+":"+curr_minute+":"+curr_second+" "+a_p+" WIB";
}

function checkTime(i){
    if (i<10) {
        i = "0"+i;
    }
    return i;
}
setInterval(showTime,500);
