</div>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/libs/js/main-js.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_principales.js"></script>

<?php if(isset($data['page'])) {?>
    <?php if ($data['page'] == 'roles') { ?>
    <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_rol.js"></script>
    <?php } ?>

    <?php if ($data['page'] == 'usuario') { ?>
    <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_usuarios.js"></script>
    <?php } ?>
<?php }else {?>


<?php } ?>

<script type="text/javascript" src="<?php echo server_url; ?>assets/libs/boostrap-select/js/bootstrap-select.min.js"></script>

<!--------------------------------------CDN -------------------------------->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<!--------------------------------------CDN --------------------------------->

</body>
</html>