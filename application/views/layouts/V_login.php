<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('layouts/_header') ?>
	</head>
	<body class="hold-transition">
		<div class="row">
			<div class="col-lg-8 hidden-xs text-center" style="background-image: url('<?= base_url(THEME_PATH);?>image/background/5.jpg');background-size:cover;height:100vh;"></div>
			<div class="col-lg-4" style="background:white;height:100vh;">
				<div class="row">
					<div class="col-lg-10 col-lg-offset-1 col-xs-10 col-xs-offset-1 text-center" style="margin-top:16vh">
						<h4 class="login-logo" style="margin: 0px;">
							<a href="<?php echo base_url() ?>">
								<img src="<?= base_url('assets/image/logopelni.png') ?>" alt="Logo Pelni" height="70">
							</a>
						</h4>
						<h4 class="login-box-msg text-bold text-primary" style="padding:20px 0;">
							<?php echo APP_NAME ?>
						</h4>
						<hr style="margin-top:0px;">
					</div>
					<?php 
						$message = $this->session->flashdata('message');
						if($message != null):
					?>
					<div class="col-lg-10 col-lg-offset-1 col-xs-10 col-xs-offset-1">
						<div class="alert alert-danger">
							<h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>
							<?= $message; ?>
						</div>
					</div>
					<?php endif;?>
					<div class="col-lg-10 col-lg-offset-1 col-xs-10 col-xs-offset-1">
						<form method="POST" action="<?php echo base_url().'Login/login_action' ?>">
							<div class="form-group">
								<input name="username" class="form-control" placeholder="Username / Email">
							</div>
							<div class="form-group">
								<input type="password" name="password" class="form-control" placeholder="Password">
							</div>
							<div class="row">
								<div class="col-xs-12">
									<button type="submit" class="btn btn-primary btn-block">Masuk</button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-12 col-xs-12 text-center" style="bottom:20px;position:absolute">
						<span>&COPY; <?php echo date('Y').' - '.APP_COMPANY ?></span>
						<a class="clearfix" href="https://www.pelni.co.id">www.pelni.co.id</a>
					</div>
				</div>
			</div>
		</div>
		
		<!-- SCRIPTS -->
		<?php $this->load->view('layouts/_footer') ?>
		<!-- END SCRIPTS -->	

	</body>
</html>