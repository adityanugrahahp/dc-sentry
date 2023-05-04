<div class="row" style="padding-top: 5px;">
	<div class="col-lg-10 col-lg-offset-1">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">PT. PELNI (Persero) - <b>Kantor Pusat</b></h3>
				<h3 class="box-title pull-right">
                    <b>Management Kartu Akses</b>
                </h3>
			</div>
			<div class="box-body" style="border-bottom: 1px solid #EEE">
				<div class="btn-group pull-left">
					<a href="<?php echo base_url() ?>" class="btn btn-primary btn-sm">
						<i class="fa fa-arrow-left fa-fw"></i> MENU UTAMA
					</a>
				</div>
                <div class="btn-group pull-right">
                    <button class="btn btn-success btn-sm btn-new">
                        <i class="fa fa-credit-card fa-fw"></i> KARTU AKSES BARU
                    </button>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="table-card" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>No.</th>
										<th>Kode Akses</th>
										<th>Nama Kartu</th>
										<th>Tanggal Terdaftar</th>
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
<div id="card-new" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-credit-card fa-fw"></i> Kartu Akses Baru</h4>
			</div>
			<div class="modal-body">
				<form id="form-card">
                    <div class="form-group">
                        <span class="form-error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Kode Kartu (Silakan Scan Kartu)<span style="color:red">*</span></label>
                        <input type="hidden" name="id_kartu">
                        <input type="text" name="no_kartu" class="form-control" required />
                    </div> 
                    <div class="form-group">
                        <label>Nama Kartu<span style="color:red">*</span></label>
                        <input type="text" class="form-control" name="nama_kartu" placeholder="Contoh: VISITOR 01" required />
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary btn-save">Simpan</button>
			</div>
		</div>
	</div>
</div>
<!-- end new visitor modal -->