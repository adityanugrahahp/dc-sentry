var table = $('#table-card').DataTable({
	"bSort" : false,
	"bLengthChange": false,
	"processing": true,
	"serverSide": true,
	"ajax": {
		"type": "POST",
		"url": base_url + "kartu/ajax_get_kartu"
	},
	"columns": [
		{"data": "no"},
		{"data": "kode"},
		{"data": "nama"},
		{"data": "created_at"},
		{"data": "action"}
	],
	"columnDefs": [
		{"className": "text-center", "targets": [0,4], "width": 60},
		{"className": "text-center", "targets": [1], "width": 100},
		{"className": "text-center", "targets": [3], "width": 150},
	]
});

$(document).on('click', '.btn-edit', function(){
	// clear semua data dalam form
	$('#form-card').trigger('reset');
	
	url 	= base_url + 'kartu/ajax_get_single_kartu';
	data_id = $(this).data('id');
	
	$.post(url, {id: data_id}, function(e){
		$.each(e.data, function(i, v){
			$('#card-new').modal('show');
			$('input[name="'+ i +'"]').val(v);
		});
	});
});

$(document).on('click', '.btn-new', function(){
	$('#card-new').modal('show');

	// clear semua data dalam form
	$('#form-card').trigger('reset');
});

$(document).on('click', '.btn-save', function(){
	url 	= base_url + 'kartu/ajax_new_kartu';
	data 	= $('#form-card').serialize();

	$.post(url, data).done(function(e){
		if(e.status == false){
			$('.form-error').html(e.msg);
		}else{
			alert("Kartu Berhasil Disimpan!");
			$('#card-new').modal('hide');
			table.ajax.reload();
		}
	}).fail(function(e){
		$('.form-error').html(e.responseText);
	});
});

$(document).on('click', '.btn-delete', function (){
	res = confirm('Apakah Anda yakin dengan aksi ini?');
	if(res){
		data_id = $(this).data('id');
		url 	= base_url + 'kartu/ajax_delete_kartu';
		data 	= {id: data_id};

		$.post(url, data).done(function(e){
			if(e.status){ 
				alert("Berhasil Menghapus Data");
				table.ajax.reload();
			}else{
				alert("ERROR: "+ e.msg);	
			}
		}).fail(function(e){
			console.log(e);
			alert("Oops.. Terjadi Kesalahan.");
		});
	}
});