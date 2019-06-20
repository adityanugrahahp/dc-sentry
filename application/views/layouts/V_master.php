<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('layouts/_header') ?>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
            <!-- TOPBAR -->
			<?php $this->load->view('layouts/_topbar') ?>            
            <!-- END TOPBAR -->
            
            <!-- SIDEBAR -->
			<!-- <?php $this->load->view('layouts/_sidebar') ?> -->
            <!-- END SIDEBAR -->

            <!-- MAIN WRAPPER -->
            <div class="content-wrapper">
				<!-- CONTENT TITLE -->
				<?php if(isset($page_title)) { ?>
                <!-- <section class="content-header">
					<h1><?php echo $page_title ?></h1>
				</section> -->
				<?php } ?>
                <!-- END CONTENT TITLE -->
                <!-- CONTENTS -->
                <section class="content">
				<?php if(isset($page_view)) { ?>
					<?php $this->load->view($page_view) ?>
				<?php }else{ ?>
					<center style="padding-top: 200px;">
						<h4>Halaman Tidak Ditemukan</h4>
					</center>
				<?php } ?>
                </section>
                <!-- END CONTENTS -->
            </div>
            <!-- MAIN WRAPPER -->
        
            <!-- FOOTER -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    DIVISI TI - <b>Version</b> <?php echo APP_VERSION ?>
                </div>
                <strong>&copy; <?php echo date('Y') ?> - <a href="http://pelni.co.id"><?php echo APP_COMPANY ?></a></strong>
            </footer>
        <!-- END FOOTER -->
		</div>
		
		<!-- SCRIPTS -->
		<?php $this->load->view('layouts/_footer') ?>
		<!-- END SCRIPTS -->
	</body>
</html>