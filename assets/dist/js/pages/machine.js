$(document).ready(function(){
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

  $.ajax({
        url:"antrian/get_status_antrian", 
        method:"POST",
        dataType: "JSON",
        data:{id_lokasi:1},
        success: function(res)
        {
          // var total_antri = parseInt(res.data.total_antrian) + 1;
          // var antri_sekarang = ("00" + total_antri).slice(-3);
          // $('#no_antrian').text(antri_sekarang);
          $('#no_antrian').text(res.data.total_antrian);
        }
  });

});
  $("#cetak_antrian").click(function(event) 
  {
      $.ajax({
        url:"antrian/request_antrian", 
        method:"POST",
        dataType: "JSON",
        data:{id_lokasi:1},
        success: function(data)
        {
          // console.log(data);
          var clone = $('#modal_detail_tiket').clone();
          var antrian = data; 
          // var lokasi= "<p style='text-align:center;'>PELNI KANTOR PUSAT</p>";
          // var alamat= "<p style='text-align:center;'>Jl. Gadjah Mada No.14, Jakarta Pusat,</p><br><p style='text-align:center;'>DKI JAKARTA, Indonesia</p>";
          var tes = clone.find('#print')
          var cur_antrian = antrian.data.no_urut;
          // var tot_antrian = antrian.data.total_antrian;
          tes.find("#nomor-print").text(cur_antrian);
          var today = new Date();
          var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
          var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
          var dateTime = date+' '+time;
          tes.find("#tgl-print").text(dateTime);
          tes.printThis({
            importCSS: true,// import page CSS
              importStyle: true,
              header: null,
              printContainer: true,// prefix to html
              footer: null
            
          });
          $('#no_antrian').text(antrian.data.no_urut);
        },
        error:function(e) {
          console.log(e);
        }
      });
  });
  
</script>

<style>
.logo-print
{
  text-align :center;
}