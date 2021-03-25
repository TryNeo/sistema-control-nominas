<div class="modal fade" id="modalReporteNomina" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Reporte | Nominas </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="pdfnomina"src="<?php echo server_url; ?>nominas/reporteNominas#toolbar=0" width="100%" height="500px">
        </iframe>
        <hr>
        <div>
            <a href="<?php echo server_url; ?>nominas/reporteNominas" download class="btn btn-danger">
            Descargar <i class="fa fa-download" aria-hidden="true"></i></a>
            <button onclick="return printPdf('pdfnomina');" 
                class="btn btn-primary">Imprimir <i class="fas fa-print" aria-hidden="true"></i></button>
        </div>
      </div>
    </div>

  </div>
</div>
