var menu_history 	= 0;
var table_history 	= null;

$(document).ready(function () {
	
});

$(document).on('click', '.btn-save', function (){
	url 	= base_url + 'home/ajax_new_visitor';
	data 	= $('#form-visitor').serialize();

	$.post(url, data).done(function(e){
		if(e.status == false){
			$('.form-error').html(e.msg);
		}else{
			alert("Pengunjung Berhasil Didaftarkan!");
			formReset();
			$('#visitor-new').modal('hide');
			refreshVisitor();
		}
		console.log(e);
	}).fail(function(e){
		$('.form-error').html(e.responseText);
	});
});

var table = $('#table-display').DataTable({
	"bSort" : false,
	"bLengthChange": false,
	"processing": true,
	"serverSide": true,
	"ajax": {
		"type": "POST",
		"url": base_url + "absenqr/ajax_module_index"
	},
	"columns": [
        {"data": "nama"},
        {"data": "lokasi"},
        {"data": "jumlah_scan"},
        {"data": "action"}
	]
});