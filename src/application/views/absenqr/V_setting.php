<div class="row" style="padding-top: 5px;">
	<div class="col-lg-10 col-lg-offset-1">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title text-bold">
					<i class="fa fa-qrcode fa-fw text-primary"></i> Absensi QR
				</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-lg-9">
						<div class="row" style="margin-top: 30px;">
							<div class="col-lg-2 col-lg-offset-2">
								<center>
									<i class="fa fa-male fa-2x fa-fw"></i>
									<span class="clearfix">Pegawai Scan QR</span>
								</center>
							</div>
							<div class="col-lg-2">
								<center>
									<i class="fa fa-desktop fa-2x fa-fw text-primary"></i>
									<span class="clearfix text-primary text-bold">QR Pada Display</span>
									<span class="clearfix"><span class="label label-success">Anda Di sini</span></span>
								</center>
							</div>
							<div class="col-lg-1">
								<center style="padding-top:5px">
									<i class="fa fa-arrow-right fa-2x fa-fw"></i>
								</center>
							</div>
							<div class="col-lg-3">
								<center>
									<i class="fa fa-cloud fa-2x fa-fw"></i>
									<i class="fa fa-list-alt fa-2x fa-fw"></i>
									<span class="clearfix">Pencatatan Absensi</span>
								</center>
							</div>
							<div class="col-lg-12"><hr></div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<?= form_dropdown('filter_gedung', $unit_kerja, $_SESSION['locationID'], 'class="form-control filter_gedung"') ?>
							</div>
							<div class="col-lg-8 text-right">
								<a href="javascript:void(0)" class="btn btn-primary btn-new-screen btn-sm"><i class="fa fa-plus fa-fw"></i> Tambah Layar</a>
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-12">
								<div class="table-responsive">
									<table id="table-display" class="table table-bordered table-condensed table-striped">
										<thead>
											<tr>
												<th>Nama Display</th>
												<th class="text-center">Lokasi</th>
												<th class="text-center">Pesan</th>
												<th class="text-center">Whitelist IP</th>
												<th class="text-center">Aksi</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>	
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<b>PETUNJUK:</b>
						<p>Berikut ini berisi daftar layar yang menampilkan QR Code yang dapat discan oleh para pegawai untuk absensi mereka.</p>
						<p>Pastikan Anda menampilkan layar sesuai dengan lokasi yang Anda Tentukan.</p>
						<p>Whitelist IP adalah alamat IP yang diperbolehkan untuk mengakses halaman display.</p>
						<b>ALUR ABSENSI:</b>
						<ul class="list-unstyled">
							<li>- Pegawai mengakses QR Scanner melalui halaman PORTAL PELNI.</li>
							<li>- Pegawai melakukan scanning QR pada layar monitor.</li>
							<li>- Pesan berhasil absen akan muncul setelah pegawai melakukan scan QR.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL FOR ADD DISPLAY -->
<div id="display-new" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus fa-fw"></i> Display QR Baru</h4>
			</div>
			<div class="modal-body">
				<form id="form-display">
					<div class="form-group">
						<label>Nama Layar<span style="color:red">*</span></label>
						<input type="hidden" name="id" required/>
						<input type="text" name="nama_layar_qr" class="form-control" required/>
						<small class="clearfix"><b>Contoh:</b> Lobby Utama.</small>
					</div>
					<div class="form-group">
						<label>Lokasi<span style="color:red">*</span></label>
						<?= form_dropdown('lokasi', $unit_kerja, null, 'class="form-control" required') ?>
					</div>
					<div class="form-group">
						<label>Pesan Screen</label>
						<textarea name="pesan_layar" class="form-control" rows="4"></textarea>
					</div>
					<div class="form-group">
						<label>Whitelist IP</label>
						<input type="text" name="whitelist_ip" class="form-control"/>
						<small class="clearfix">Kosongkan apabila tanpa pengecekan IP, pisahkan beberapa IP dengan tanda koma (X.X.X.X, X.X.X.X).</small>
					</div>
					<div class="form-group">
						<label>Custom Kode Akses</label>
						<div class="input-group">
							<input type="text" name="token_layar" class="form-control" placeholder="Masukkan Data">
							<span class="input-group-btn">
								<button class="btn btn-primary btn-random" type="button"><i class="fa fa-refresh fa-fw"></i></button>
							</span>
						</div>
						<small class="clearfix"><b>Catatan:</b> Kosongkan bila tidak ada kode akses custom untuk display ini.</small>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="btn-group">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="button" class="btn btn-primary btn-save">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- MODAL FOR ADD DISPLAY -->
<!-- MODAL FOR JWT KEY -->
<div id="display-token" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-key fa-fw"></i> Token Display Desktop</h4>
			</div>
			<div class="modal-body">
				<p>Silakan copy paste token ini pada aplikasi Absensi QR versi Desktop. Harap diperhatikan bahwa masa berlaku token ini adalah 1 menit saja.</p>
        <span><b>Masa Berlaku Token:</b> <span id="token-exp">N/A</span></span>
        <br>
        <br>
        <textarea id="display-token-jwt" class="form-control" cols="30" rows="10" readonly></textarea>
			</div>
			<div class="modal-footer">
				<div class="btn-group">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END MODAL FOR JWT KEY -->