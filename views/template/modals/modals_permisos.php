<div class="modal fade modalPermisos" tabindex="-1" role="dialog">
  <div class="modal-dialog  modal-lg  modal-dialog-centered"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Permisos roles usuario <i class=" fas fa-clipboard-list"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" id="formPermisos" name="formPermisos">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <input type="hidden" id="id_rol" name="id_rol" value="<?= $data['id_rol']; ?>" required="">
            <div class="card-body">
              <table class="table  first display responsive nowrap" cellspacing="0"  style="width:100%">
                <thead>
                  <th>#</th>
                  <th>Modulo</th>
                  <th>Leer</th>
                  <th>Escribir</th>
                  <th>Actualizar</th>
                  <th>eliminar</th>
                </thead>
                <tbody>
                            <?php 
                                $no=1;
                                $modulos = $data['modulos'];
                                for ($i=0; $i < count($modulos); $i++) { 

                                    $permisos = $modulos[$i]['permisos'];
                                    $rCheck = $permisos['r'] == 1 ? " checked " : "";
                                    $wCheck = $permisos['w'] == 1 ? " checked " : "";
                                    $uCheck = $permisos['u'] == 1 ? " checked " : "";
                                    $dCheck = $permisos['d'] == 1 ? " checked " : "";

                                    $idmod = $modulos[$i]['id_modulo'];
                            ?>
                          <tr>
                            <td>
                                <?= $no; ?>
                                <input type="hidden" name="modulos[<?= $i; ?>][id_modulo]" value="<?= $idmod ?>" required >
                            </td>
                            <td>
                                <?= $modulos[$i]['nombre']; ?>
                            </td>
                            <td>
                            <div class="toggle-flip">
                                  <label>
                                    <input type="checkbox" name="modulos[<?= $i; ?>][r]" <?= $rCheck ?> >
                                  </label>
                                </div>
                            </td>
                            <td><div class="toggle-flip">
                                  <label>
                                    <input type="checkbox" name="modulos[<?= $i; ?>][w]" <?= $wCheck ?>>
                                  </label>
                                </div>
                            </td>
                            <td><div class="toggle-flip">
                                  <label>
                                    <input type="checkbox" name="modulos[<?= $i; ?>][u]" <?= $uCheck ?>>
                                  </label>
                                </div>
                            </td>
                            <td><div class="toggle-flip">
                                  <label>
                                    <input type="checkbox" name="modulos[<?= $i; ?>][d]" <?= $dCheck ?>>
                                  </label>
                                </div>
                            </td>
                          </tr>
                          <?php 
                                $no++;
                            }
                            ?>
                        </tbody>
                </table>
            </div>
                <div class="col-md-12 mb-3 text-center">
                  <button type="submit" class="btn btn-info"><i class="fas fa-save"></i><span class="text-center"> Guardar</span></button>
                  <button type="button" class="btn btn-danger" onclick="return cerrar_modal('.modalPermisos')"><i class=" fas fa-exclamation-circle"></i> Cancelar</button>  
                </div>
            </div>
      </form>
      </div>
    </div>
  </div>
</div>
