<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('layouts/_header') ?>
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-box-body">
				<h4 class="login-logo" style="margin: 0px;">
					<a href="<?php echo base_url() ?>">
						<img src="<?php echo base_url('assets/image/logopelni.png') ?>" alt="Logo Pelni" height="70">
					</a>
				</h4>
				<p class="login-box-msg text-bold text-uppercase" style="padding:20px 0;"><?php echo APP_NAME ?></p>
				<?php 
					$message = $this->session->flashdata('message');
					if($message!=null):?>
					<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-ban"></i> Error!</h4>
						<?php echo $message;?>
					</div>
				<?php endif;?>

				<form method="POST" action="<?php echo base_url().'Login/login_action' ?>">
					<div class="form-group">
						<input name="username" class="form-control" placeholder="Username">
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
				<div class="row" style="margin-top: 20px;">
					<div class="col-xs-12 text-center">
						<span>&COPY; <?php echo date('Y').' - '.APP_COMPANY ?></span>
					</div>
				</div>
			</div>
		</div>
		
		<!-- SCRIPTS -->
		<?php $this->load->view('layouts/_footer') ?>
		<!-- END SCRIPTS -->	

		
	</body>
</html>