</div>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/inputmask/js/jquery.inputmask.bundle.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/boostrap-touchspin/js/jquery.bootstrap-touchspin.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/libs/js/main-js.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_principales.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js'></script>
<?php if(isset($data['page'])) {?>
    <?php if($data['page'] == 'dashboard'){?>
        <script src="<?php echo server_url; ?>assets/vendor/highchard/highcharts.js"></script>
        <script src="<?php echo server_url; ?>assets/vendor/highchard/highcharts-3d.js"></script>
        <script src="<?php echo server_url; ?>assets/vendor/highchard/modules/data.js"></script>
        <script src="<?php echo server_url; ?>assets/vendor/highchard/modules/drilldown.js"></script>


        <script src="<?php echo server_url; ?>assets/vendor/highchard/modules/exporting.js"></script>
        <script src="<?php echo server_url; ?>assets/vendor/highchard/modules/export-data.js"></script>
        <script src="<?php echo server_url; ?>assets/vendor/highchard/modules/accessibility.js"></script>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_dashboard.js"></script>
    <?php }?>
    <?php if($data['page'] == 'login'){?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_login.js"></script>
    <?php } ?>

    <?php if($data['page'] == 'respaldo'){?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_respaldo.js"></script>
    <?php } ?>

    <?php if ($data['page'] == 'roles') { ?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_rol.js"></script>
    <?php } ?>

    <?php if ($data['page'] == 'usuario') { ?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_usuarios.js"></script>
    <?php } ?>

    <?php if ($data['page'] == 'contratos') { ?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_contratos.js"></script>
    <?php } ?>

    <?php if ($data['page'] == 'empleados') { ?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_empleados.js"></script>
    <?php } ?>

    <?php if ($data['page'] == 'puestos') { ?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_puestos.js"></script>
    <?php } ?>

    <?php if ($data['page'] == 'nominas' || $data['page'] == 'detalle') { ?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_nominas.js"></script>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_empleados.js"></script>
    <?php } ?>
    <?php if($data['page']=='estado'){?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_estado.js"></script>
    <?php } ?>
<?php }else {?>


<?php } ?>

<script type="text/javascript" src="<?php echo server_url; ?>assets/libs/boostrap-select/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/datepicker/moment.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/datepicker/tempusdominus-bootstrap-4.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/datepicker/datepicker.js"></script>
<!--------------------------------------CDN -------------------------------->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<!--------------------------------------CDN --------------------------------->

</body>
</html>