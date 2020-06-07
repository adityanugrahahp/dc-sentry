<div class="row" style="padding-top: 5px;">
	<div class="col-lg-10 col-lg-offset-1">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">PT. PELNI (Persero) - <b>Kantor Pusat</b></h3>
				<h3 class="box-title pull-right">Tanggal: <b><span><?php echo date('d/m/Y');?></span></b></h3>
			</div>
			<div class="box-body" style="border-bottom: 1px solid #EEE">
				<div class="btn-group pull-left">
					<button class="btn btn-default btn-sm btn-refresh">
						<i class="fa fa-refresh fa-fw"></i> REFRESH
					</button>
				</div>
				<div class="btn-group pull-right">
					<a href="<?php echo base_url('kartu') ?>" class="btn btn-default btn-sm">
						<i class="fa fa-credit-card fa-fw"></i> KARTU AKSES
					</a>
					<button class="btn btn-primary btn-sm btn-change">
						<i class="fa fa-list fa-fw"></i> RIWAYAT TAMU
					</button>
					<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#visitor-new">
						<i class="fa fa-user-plus fa-fw"></i> TAMU BARU
					</button>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-lg-12" id="visitor-current">
						<h5>
							<strong><i class="fa fa-users fa-fw"></i> PENGUNJUNG SAAT INI: </strong> 
							<span id="visitor-jumlah"></span> Orang &middot;
							<strong>MENUNGGU:</strong> 
							<span id="waiting-visitor-jumlah"></span> Orang
						</h5>
						<div class="table-responsive">
							<table id="table-visitor" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Foto</th>
										<th>Nama Tamu</th>
										<th>No.HP</th>
										<th>Waktu Masuk</th>
										<th>Tujuan</th>
										<th>Keperluan</th>
										<th>ID Card</th>
										<th>Suhu</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>	
						</div>
					</div>
					<div class="col-lg-12" id="visitor-history">
						<div class="row">
							<div class="col-lg-8">
								<h5><strong><i class="fa fa-users fa-fw"></i> PENGUNJUNG TANGGAL <span id="history-date"><?php echo date('m-d-Y') ?> s/d <?php echo date('m-d-Y') ?></span>:</strong> <span id="visitor-history-jumlah">N/A</span> Orang</h5>
							</div>
							<div class="col-lg-4" style="padding-bottom: 30px;">
								<div class="input-group datepicker-range">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control" id="history-filter-start" value="<?php echo date('m-d-Y') ?>">
									<div class="input-group-addon">s/d</div>
									<input type="text" class="form-control" id="history-filter-end" value="<?php echo date('m-d-Y') ?>">
									<div class="input-group-btn">
										<button class="btn btn-default btn-filter">
											<i class="glyphicon glyphicon-search"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="table-visitor-history" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Foto</th>
										<th>Nama Tamu</th>
										<th>No.HP</th>
										<th>Waktu Masuk</th>
										<th>Tujuan</th>
										<th>Keperluan</th>
										<th>ID Card</th>
										<th>Waktu Keluar</th>
										<th>Suhu</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- new visitor modal -->
<div id="visitor-new" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title modal-visitor-title"><i class="fa fa-user-plus fa-fw"></i> Pengunjung Baru</h4>
			</div>
			<div class="modal-body">
				<form id="form-visitor">
					<div class="row">
						<div class="col-lg-6">
							<div class="row">
								<div class="col-lg-12">
									<span class="form-error text-danger"></span>
								</div>
								<div class="col-lg-12">
									<b>PETUNJUK:</b>
									<ul class="list-styled" style="margin-left: -25px;">
										<li>Silakan lengkapi identitas tamu pada form di bawah ini.</li>
										<li>Scan kartu akses yang akan diberikan kepada tamu pada textbox yang tersedia.</li>
										<li>Pastikan kartu akses yang di scan telah sesuai.</li>
									</ul>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>NIK<span style="color:red">*</span></label>
										<input type="hidden" name="id"/>
										<input type="text" name="nik" required class="form-control" />
									</div> 
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Nama<span style="color:red">*</span></label>
										<input type="text" required class="form-control" name="nama" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Jenis Kelamin<span style="color:red">*</span></label>
										<select required class="form-control" name="jenis_kelamin">
											<option value="L">Laki-laki</option>
											<option value="P">Perempuan</option>
										</select>
									</div> 
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Tanggal Lahir</label>
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" class="form-control pull-right datepicker" name="tgl_lahir">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Alamat<span style="color:red">*</span></label>
										<textarea required class="form-control" name="alamat"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
							    <div class="col-md-6">
									<div class="form-group">
										<label>No HP<span style="color:red">*</span></label>
										<input required type="text" class="form-control" name="no_hp" />
									</div> 
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Tujuan<span style="color:red">*</span></label>
										<?php echo form_dropdown('tujuan', $tujuan, null, 'class="form-control"') ?>
										<!-- <input required type="text" class="form-control" name="tujuan" /> -->
									</div> 
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Keperluan<span style="color:red">*</span></label>
										<input required type="text" class="form-control" name="keperluan" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Suhu Tubuh</label>
										<input type="text" class="form-control" name="suhu" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Form Deklarasi Mandiri<span style="color:red">*</span></label>
										<span class="clearfix"><a href="#" class="show-form-deklarasi">Lihat Form Deklarasi</a></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12"><hr></div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Visitor Card ID<span style="color:red">*</span></label>
										<input required type="text" class="form-control" name="id_visitor_card" />
									</div> 
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<label>Identifikasi Kartu Akses:</label>
										<label class="clearfix" id="visitor-card-res" style="margin-top: 5px;">Scan Kartu Terlebih Dahulu</label>
									</div> 
								</div>
							</div>
						</div>
						<!-- Col untuk Camera -->
						<div class="col-lg-6 text-center box-camera">
							<div class="camera">
								<video id="video">Video stream not available.</video>
								<button id="startbutton">Ambil Gambar</button> 
							</div>
							<canvas id="canvas"></canvas>
							<div class="output">
								<img id="photo" alt="The screen capture will appear in this box.">
								<div class="form-group">
									<input type="hidden" class="form-control" id="foto" name="foto" /> 
								</div>
							</div>
						</div>
						<div class="col-lg-6 box-deklarasi" style="display:none;">
							<h4 class="text-primary text-bold">Form Deklarasi</h4>
							<p>Berikut ini merupakan form deklarasi yang diisi oleh pengunjung.</p>
							<hr>
							<div id="form-tambahan"></div>
							<span>Deklarasi pengakuan ini dibuat dengan sebenar-benarnya oleh pengunjung yang bersangkutan. Segala ketidakbenaran data akan ditanggung oleh pengunjung sepenuhnya.</span>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary btn-save" disabled>Simpan</button>
			</div>
		</div>
	</div>
</div>
<!-- end new visitor modal -->

<!-- Date and timepicker modal -->
<div id="visitor-checkout" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-sign-out fa-fw"></i> Checkout Visitor</h4>
			</div>
			<div class="modal-body">
				<form id="form-checkout">
					<div class="form-group">
						<b>PETUNJUK:</b>
						<ul class="list-styled" style="margin-left:-25px;">
							<li>Silakan masukkan tanggal dan jam checkout dari tamu yang dipilih.</li>
							<li>Pastikan data yang dimasukkan telah benar.</li>
						</ul>
					</div>
					<div class="form-group">
						<label>Tanggal Checkout (sesuai buku tamu)</label>
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="hidden" name="id">
							<input type="text" class="form-control pull-right datepickertime" name="last_seen" required>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-danger btn-delete">CHECK OUT</button>
			</div>
		</div>
	</div>
</div>