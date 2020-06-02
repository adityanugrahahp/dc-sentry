var table;
var module_url = base_url + 'absenqr';

$(document).ready(function () {
	table = $('#table-display').DataTable({
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
			{"data": "pesan"},
			{"data": "aksi"}
		]
	});
});

$(document).on('click', '.btn-new-screen', function (){
	$('#display-new').modal('show');
	$('#form-display').find('input, textarea').val('');
});

$(document).on('click', '.btn-save', function (){
	// get form data
	form_data = $('#form-display').serialize();

	$.post(module_url + '/ajax_post_form', form_data).done(function(e){
		if(e.status){
			alert('Berhasil Menyimpan Data');
			$('#form-display').find('input, textarea').val('');
			table.ajax.reload();
			$('#display-new').modal('hide');
		}else{
			alert('Gagal Menyimpan Data. Error: ' + e.msg);
		}
	}).fail(function(e){
		alert(e.responseText);
	});
});

$(document).on('click', '.btn-delete', function (){
	res = confirm('Apakah Anda yakin akan melakukan aksi ini?');
	if(res){
		$.post(module_url + '/ajax_delete_item', {id:$(this).data('id')}).done(function(e){
			if(e.status){
				alert('Berhasil Menghapus Data');
				table.ajax.reload();
			}else{
				alert('Gagal Menghapus Data');
			}
		}).fail(function(e){
			// alert error
			alert(e.responseText);
		});
	}
});

$(document).on('click', '.btn-edit', function (){
	$.post(module_url + '/ajax_get_item', {id:$(this).data('id')}).done(function(e){
		if(e.status){
			$('#display-new').modal('show');

			$('input[name="id"]').val(e.data.id);
			$('input[name="nama_layar_qr"]').val(e.data.nama_layar_qr);
			$('input[name="token_layar"]').val(e.data.token_layar);
			$('textarea[name="pesan_layar"]').val(e.data.pesan_layar);
			$('select[name="lokasi"]').val(e.data.lokasi).change();
		}else{
			alert('Gagal Medapatkan Data');
		}
	}).fail(function(e){
		// alert error
		alert(e.responseText);
	});
});

$(document).on('click', '.btn-random', function (){
	$('input[name="token_layar"]').val(_randomStr(35));
});

function _randomStr(length) {
	var result           = '';
	var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var charactersLength = characters.length;
	
	for(i = 0; i < length; i++){
	   result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}

	return result;
}