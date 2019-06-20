$(document).ready(function () {
	
	var months = [
		'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni','Juli','Agustus','September', 'Oktober', 'November', 'Desember'
	];

	var days = [
		'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
	];

	function update(){
		var date 	= new Date();
		var hours 	= date.getHours();
		var minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
	
		var dayOfWeek 	= days[date.getDay()];
		var month 		= months[date.getMonth()];
		var day 		= date.getDate();
		var year 		= date.getFullYear();
		
		// tanggal
		var strTanggal 	= dayOfWeek + ', ' + day + ' ' + month + ' ' + year;
		var strJam 		= hours + ':' + minutes + ' WIB';
		
		$('#d_tanggal').html(strTanggal);
		$('#d_jam').html("<b>" + strJam + "</b>");
	} 

	update();
	window.setInterval(update, 1000);

	function getCurrentAntrian(){
		$.ajax({
			url:base_url + "antrian/get_status_antrian", 
			method:"POST",
			dataType: "JSON",
			data:{
				id_lokasi:1
			},
			success: function(res){
				$('#d_sisa_antrian').html(res.data.sisa_antrian);
			}
		});

		$.ajax({
			url:base_url + "antrian/get_loket_handle", 
			method:"POST",
			dataType: "JSON",
			data:{
				id_lokasi:1
			},
			success: function(res){
				$.each(res.data, function(k, v) {
					var cur = $('#cur_loket_' + v.id_loket).text();
					$('#cur_loket_' + v.id_loket).text(v.no_antrian);
					$('.antrian-no[data-id="'+ v.id_loket +'"]').html(v.no_antrian);

					if(cur != v.no_antrian){
						$('.antrian-no[data-id="'+ v.id_loket +'"]').addClass('animated flash flash_number');
					}
				});
				
			}
		});
	}

	getCurrentAntrian();
	window.setInterval(getCurrentAntrian, 5000);
});

var w = window,
    d = document,
    e = d.documentElement,
    g = $('.main_box')[0],
	y = w.innerHeight|| e.clientHeight|| g.clientHeight;

var box_height 		= y / j_loket,
	header_footer 	= (j_loket * 67),
	elem_height 	= box_height - ((j_loket * 20) + header_footer + 73);

$('.box-antrian').attr('style', 'vertical-align:middle;height:'+elem_height+'px;');