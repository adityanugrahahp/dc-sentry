<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
    	$.widget.bridge('uibutton', $.ui.button);	
    });
    var base_url = "<?php echo base_url();?>";
</script>

<script src="<?php echo base_url();?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo base_url() ?>assets/bower_components/moment/moment.js"></script>
<script src="<?php echo base_url();?>assets/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url();?>assets/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url();?>assets/dist/js/pages/visitor_main.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<?php if(isset($extraJs)):?>
    <?php foreach($extraJs as $key => $js):?>
        <script type="text/javascript" src="<?php echo base_url();?>assets/dist/js/pages/<?=$js;?>"></script>
    <?php endforeach;?>
<?php endif;?>