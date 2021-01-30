</div>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/libs/js/main-js.js"></script>
<script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_ad.js"></script>

<!--------------------------------------CDN -------------------------------->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<!--------------------------------------CDN --------------------------------->

<script type="text/javascript">
$(document).ready(function() {
  $('.table').DataTable({
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
          "sFirst": "<span class='fa fa-angle-double-left'></span>",
          "sLast": "<span class='fa fa-angle-double-right'></span>",
          "sNext": "<span class='fa fa-angle-right'></span>",
          "sPrevious": "<span class='fa fa-angle-left'></span>"
      },
      "oAria": {
          "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    },
    responsive:true
  });
});
</script>
</body>
</html>