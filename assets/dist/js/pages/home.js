var menu_history 	= 0;
var table_history 	= null;

$(document).ready(function () {
	// datetimepicker initialization
	$(".datepicker").datetimepicker({ format: 'MM-DD-YYYY' });
	$(".datepickertime").datetimepicker({ maxDate: new Date(), format: 'MM-DD-YYYY HH:mm' });
	$('.datepicker-range input').each(function() { $(this).datetimepicker({ format: 'MM-DD-YYYY' }); });

	refreshVisitor();
	$('#visitor-history').hide();

	// cek tamu belum checkout selain hari ini
	$.post(base_url + 'home/ajax_get_not_checkout').done(function(e){
		if(e.status){
			alert("PERHATIAN!\nAnda memiliki "+ e.total +" tamu yang BELUM CHECKOUT sejak "+ e.since 
			+ ".\nKlik RIWAYAT TAMU untuk CHECKOUT dengan memilih TANGGAL "+ e.since +" s/d HARI INI.");
		}
	});
	$(document).on('keypress', 'input[name="nik"]',function (e) {
		var nrp_inp = $(this).val();
		if(e.which == 13) {
			$.ajax({
				type: "post",
				url: base_url+"home/ajax_get_pegawai",
				data: {"nrp":nrp_inp},
				dataType: "json",
				success: function (response) {
					if(response.status=="success")
					{
						var data = response.data;
						$('input[name="nama"]').val(data.pslh_nama);
						$('select[name="jenis_kelamin"]').val(data.pslh_kelamin);
						$('input[name="tgl_lahir"]').val(data.pslh_tgl_lhr);
						$('textarea[name="alamat"]').val(data.pslh_alamat);
						$('input[name="no_hp"]').val(data.pslh_hp);
					}
					else
					{
						get_existing_visitor(nrp_inp)
					}
				}
			});
		}
	});

	function get_existing_visitor(nik_inp)
	{
		$.ajax({
			type: "post",
			url: base_url+"home/get_existing_visitor",
			data: {"nik":nik_inp},
			dataType: "json",
			success: function (response) {
				if(response.status=="success")
				{
					var data = response.data;
					$('input[name="nama"]').val(data.nama);
					$('select[name="jenis_kelamin"]').val(data.jenis_kelamin);
					$('input[name="tgl_lahir"]').val(data.pslh_tgl_lhr);
					$('textarea[name="alamat"]').val(data.alamat);
					$('input[name="no_hp"]').val(data.no_hp);
				}
			}
		});
	}
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

$(document).on('click', '.btn-download', function (){
	// download laporan periode
	var base_doc 	= 'https://devel.pelni.co.id/jrio/rest_v2/reports/VisitorReports/Reports/VisitorHistory.pdf';
	var tgl_awal 	= $('#history-filter-start').val().split('-');
	var tgl_akhir 	= $('#history-filter-end').val().split('-');

	if(tgl_awal && tgl_akhir){
		tgl_awal 	= [tgl_awal[2], tgl_awal[0], tgl_awal[1]];
		tgl_akhir 	= [tgl_akhir[2], tgl_akhir[0], tgl_akhir[1]];

		base_doc += "?tgl_awal="+ tgl_awal.join('-') +"&tgl_akhir="+ tgl_akhir.join('-');
		
		document.location.href = base_doc;
	}else{
		alert('Silakan Pilih Tanggal Awal dan Akhir.');
	}
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
        {"data": "suhu"},
        {"data": "action"},
	],
	"columnDefs": [
        {"className": "text-center", "targets": [7], "width": 30},
        {"className": "text-center", "targets": [0, 2, 3, 6]},
    ]
});

$(document).on('click', '.btn-filter', function (){
	$('#history-date').text($('#history-filter-start').val()+ " s/d " +$('#history-filter-end').val());
	refreshVisitorHistory($('#history-filter-start').val(), $('#history-filter-end').val());
});

$(document).on('click', '.btn-delete', function (){
	data_id = $(this).data('id');

	if($('input[name="last_seen"]').val() == '' && data_id == undefined){
		alert("Tanggal Checkout Belum Dipilih!");
		return false;
	}

	res = confirm('Apakah Anda yakin dengan aksi ini?');
	if(res){
		url 	= base_url + 'home/ajax_checkout';
		data 	= {id: data_id};

		// bila data-id kosong send data dari form
		if(data_id == undefined){
			data = $('#form-checkout').serialize();
		}

		$.post(url, data).done(function(e){
			if(e.status){ 
				refreshVisitor();
				refreshVisitorHistory();
				$('#form-checkout').trigger('reset');
				$("#visitor-checkout").modal('hide');
				
				alert('Tamu Berhasil Checkout');
			}
		}).fail(function(e){
			console.log(e);
			alert("Oops.. Terjadi Kesalahan.");
		});
	}
});

$(document).on('click', '.btn-delete-past', function (){
	$("#visitor-checkout").modal('show');
	$('#form-checkout').trigger('reset');
	$('input[name="id"]').val($(this).data('id'));
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
			"data": { 
				"tggl1": $('#history-filter-start').val(),
				"tggl2": $('#history-filter-end').val()
			}
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
			{"data": "suhu"},
			{"data": "action"},
		],
		"columnDefs": [
			{"className": "text-center", "targets": [0, 2, 3, 6, 7, 8]},
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

function refreshVisitorHistory(str_date_start = null, str_date_end = null){
	url = base_url + 'home/ajax_get_history_visitor';
	$.get(url, {tggl1: str_date_start, tggl2: str_date_end}).done(function(e){ 
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