var table 			= null;
var menu_history 	= 0;
var table_history 	= null;
var scanner 		= null;
var data_camera 	= [];

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

	table = $('#table-visitor').DataTable({
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
	
	// setInterval untuk mengecek apakah ada visitor baru?
	// INFO: loop setiap 1 menit sekali
	setInterval(function(){
		refreshVisitor();
		table.ajax.reload();
	}, 60 * 1000);
});

$(document).on('click', '.btn-save', function (){
	url 	= base_url + 'home/ajax_new_visitor';
	data 	= $('#form-visitor').serialize();

	$.post(url, data).done(function(e){
		if(e.status == false){
			$('.form-error').html(e.msg);
		}else{
			alert("Pengunjung Berhasil Didaftarkan!");
			$('#visitor-new').modal('hide');
			
			formReset();
			refreshVisitor();
		}
	}).fail(function(e){
		$('.form-error').html(e.responseText);
	});
});

$(document).on('click', '.btn-filter', function (){
	$('#history-date').text($('#history-filter-start').val()+ " s/d " +$('#history-filter-end').val());
	refreshVisitorHistory($('#history-filter-start').val(), $('#history-filter-end').val());
});

$(document).on('click', '.show-form-deklarasi', function (){
	$('.box-deklarasi, .box-camera').toggle();
});

$(document).on('click', '.btn-add', function (){
	$('#visitor-new').modal('show');
	$('.modal-visitor-title').html('<i class="fa fa-user-plus fa-fw"></i> Pengunjung Baru');
	$('#form-visitor').trigger('reset');

	$('.btn-disapprove').attr('disabled', 'disabled').hide();
	$('.btn-save').attr('disabled', 'disabled').text('Simpan');
});

$(document).on('click', '.btn-edit', function (){
	data_id = $(this).data('id');

	// ambil data dari backend
	$.post(base_url + 'home/ajax_get_detail_tamu', {id: data_id}, function(d){
		if(d.status){
			// tampilkan modal
			$('#visitor-new').modal('show');
			$('.modal-visitor-title').html('<i class="fa fa-edit fa-fw"></i> Verifikasi Pengunjung Baru');

			// masukkan semua item pada form modal
			$('input[name="id"]').val(d.data.id);
			$('input[name="nik"]').val(d.data.nik);
			$('input[name="nama"]').val(d.data.nama);
			$('select[name="jenis_kelamin"]').val(d.data.jenis_kelamin).change();
			$('input[name="tgl_lahir"]').val(d.data.tgl_lahir);
			$('textarea[name="alamat"]').val(d.data.alamat);
			$('input[name="no_hp"]').val(d.data.no_hp);
			$('input[name="keperluan"]').val(d.data.keperluan);
			$('select[name="tujuan"]').val(d.data.tujuan).change();

			// kartu akses
			$('input[name="id_visitor_card"]').val(d.data.no_kartu);
			$('#visitor-card-res').html('<span class="text-success">'+ d.data.nama_kartu + ' - ' + d.data.kode_akses + '</span>');

			// form deklarasi
			$('#form-tambahan').html(d.data.form);
			$('.box-deklarasi').hide();
			$('.box-camera').show();

			$('.btn-disapprove').removeAttr('disabled').show();
			$('.btn-save').removeAttr('disabled').text('Approve');
		}else{
			alert('Tidak Dapat Mendapatkan Data Visitor Ini');
		}
	});
});

$(document).on('click', '.btn-checkout-qr', function (){
	scanner = new Instascan.Scanner({ 
        video: document.getElementById('scanner'),
        mirror: false
	});

	_initiate_camera();
	
	$('#visitor-checkout-qr').modal('show');
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

$(document).on('click', '.btn-disapprove', function (){
	data_id = $('input[name="id"]').val();

	res = confirm('Apakah Anda yakin dengan aksi ini?');
	if(res){
		url = base_url + 'home/ajax_disapprove';

		$.post(url, { id: data_id }).done(function(e){
			if(e.status){ 
				refreshVisitor();
				refreshVisitorHistory();
				
				$('#form-visitor').trigger('reset');
				$("#visitor-new").modal('hide');
				
				alert('Tamu Berhasil Dihapus');
			}else{
				alert('Gagal Menghapus Data');
			}
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

$(document).on('change', '.kamera_aktif', function(){
    var val = $(this).val();
    
    try {
        if(data_camera[val] !== undefined){
            scanner.start(data_camera[val]);
        }
    } catch (error) {
        console.log(error);
    }
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

$('#visitor-checkout-qr').on('hidden.bs.modal', function (){
	// destroy camera
	scanner.stop();
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
		$('#waiting-visitor-jumlah').text(e.waiting);
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

function _initiate_camera(){
    scanner.addListener('scan', function (data_qr) {

		$.post(base_url + 'home/ajax_checkout', {kode_akses: data_qr}).done(function(d){
			if(d.status){ 
				refreshVisitor();
				refreshVisitorHistory();

				$('#visitor-checkout-qr').modal('hide');
				
				alert('Tamu Berhasil Checkout');
			}else{
				alert('Terjadi Kesalahan: ' + d.msg);
			}
		}).fail(function(e){
			alert("Oops.. Terjadi Kesalahan.");
		});

    });

    try {
        Instascan.Camera.getCameras().then(function (e) {
            $(".kamera_aktif").empty().trigger("change");
    
            if(e.length > 0){
                $.each(e, function(i, v){
                    data_camera.push(v);
                    newOption = new Option(v.name, i, false, false);
                    $('.kamera_aktif').append(newOption);
				});
				
				$('.kamera_aktif').trigger('change');
            }else{
                alert('No cameras found.');
            }
        });
    } catch (error) {
        console.log(error);
    }
}