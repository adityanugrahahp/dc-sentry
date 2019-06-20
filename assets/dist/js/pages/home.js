var menu_history 	= 0;
var table_history 	= null;

$(document).ready(function () {
	$(".datepicker").datepicker({
		format: 'mm-dd-yyyy',
		todayHighlight: true,
		autoclose: true
	});

	refreshVisitor();
	$('#visitor-history').hide();

	var d = new Date();
	$('#history-date').text(d.getDate()+'-'+d.getMonth()+'-'+d.getFullYear());
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

var table = $('#table-visitor').DataTable({
	"bSort" : false,
	"bLengthChange": false,
	"processing": true,
	"serverSide": true,
	"ajax": {
		"type": "POST",
		"url": base_url + "home/ajax_get_visitor"
	},
	"columns": [
        {"data": "foto"},
        {"data": "nama"},
        {"data": "no_hp"},
        {"data": "register_time"},
        {"data": "tujuan"},
        {"data": "keperluan"},
        {"data": "id_visitor_card"},
        {"data": "action"},
	],
	"columnDefs": [
        {"className": "text-center", "targets": [7], "width": 30},
        {"className": "text-center", "targets": [0, 2, 3, 6]},
    ]
});

$(document).on('change', '#history-filter', function (){
	$('#history-date').text($(this).val());
	refreshVisitorHistory($(this).val());
});

$(document).on('click', '.btn-delete', function (){
	res = confirm('Apakah Anda yakin dengan aksi ini?');
	if(res){
		data_id = $(this).data('id');
		url 	= base_url + 'home/ajax_checkout';
		data 	= {id: data_id};

		$.post(url, data).done(function(e){
			if(e.status){ refreshVisitor(); }
			console.log(e);
		}).fail(function(e){
			console.log(e);
			alert("Oops.. Terjadi Kesalahan.");
		});
	}
});

$(document).on('click', '.btn-refresh', function(){
	refreshVisitor();
	refreshVisitorHistory();
});

$(document).on('click', '.btn-change', function(){
	// ubah text button face
	if(menu_history == 0){
		menu_history = 1;
		$(this).html('<i class="fa fa-users fa-fw"></i> TAMU SAAT INI');
		if ( ! $.fn.DataTable.isDataTable( '#table-visitor-history' ) ) {
			tableHistory();
		}
		refreshVisitorHistory();
	}else{
		menu_history = 0;
		$(this).html('<i class="fa fa-list fa-fw"></i> RIWAYAT TAMU');
	}

	$('#visitor-history').toggle();
	$('#visitor-current').toggle();
});

$(document).on('keypress', 'input[name="id_visitor_card"]', function(e){
	if(e.which == 13) {
		url 	= base_url + 'home/ajax_get_card';
		data 	= {id: $(this).val()};

		$.post(url, data).done(function(e){
			if(e.status){
				$('#visitor-card-res').text(e.name);
				$('#visitor-card-res').addClass('text-success');
				$('#visitor-card-res').removeClass('text-danger');
				$('.btn-save').removeAttr('disabled');
			}else{
				$('#visitor-card-res').text('ERROR: '+ e.name);
				$('#visitor-card-res').addClass('text-danger');
				$('#visitor-card-res').removeClass('text-success');
				$('.btn-save').attr('disabled', 'disabled');
			}
		});

    }
});

function tableHistory(){
	table_history = $('#table-visitor-history').DataTable({
		"bSort" : false,
		"bLengthChange": false,
		"processing": true,
		"serverSide": true,
		"ajax": {
			"type": "POST",
			"url": base_url + "home/ajax_get_visitor_history",
			"data": { "tggl": $('#history-filter').val() }
		},
		"columns": [
			{"data": "foto"},
			{"data": "nama"},
			{"data": "no_hp"},
			{"data": "register_time"},
			{"data": "tujuan"},
			{"data": "keperluan"},
			{"data": "id_visitor_card"},
			{"data": "last_seen"},
		],
		"columnDefs": [
			{"className": "text-center", "targets": [0, 2, 3, 6, 7]},
		]
	});
}

function refreshVisitor(){
	url = base_url + 'home/ajax_get_current_visitor';
	$.get(url).done(function(e){
		table.ajax.reload();
		$('#visitor-jumlah').text(e.jumlah);
	});
}

function refreshVisitorHistory(str_date){
	url = base_url + 'home/ajax_get_history_visitor';
	$.get(url, {tggl: str_date}).done(function(e){ 
		$('#visitor-history-jumlah').text(e.jumlah); 
		if($.fn.DataTable.isDataTable('#table-visitor-history')) {
			table_history.destroy();
		}
		tableHistory();
	});
}

function formReset(){
	$('#form-visitor').trigger("reset");
	$('.btn-save').attr('disabled', 'disabled');
	$('#visitor-card-res').removeClass('text-danger');
	$('#visitor-card-res').removeClass('text-success');
	$('#visitor-card-res').text('Scan Kartu Terlebih Dahulu');
}