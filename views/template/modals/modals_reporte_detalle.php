<div class="modal fade" id="modalReporteDetalle" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Reporte | Detalle </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="pdfdetallenomina" width="100%" height="500px">
        </iframe>
        <hr>
        <div>
            <a download id="dowloadpdf" class="btn btn-danger">
            Descargar <i class="fa fa-download" aria-hidden="true"></i></a>
            <button type="button" onclick="return printPdf('pdfdetallenomina');" 
                class="btn btn-primary">Imprimir <i class="fas fa-print" aria-hidden="true"></i></button>

        </div>
      </div>
    </div>

  </div>
</div>
