<!-- Modal -->
<div class="modal fade" id="modalFormLugares" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevos Lugares</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
        <button type="button" class="custom-close-btn" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formLugares" name="formLugares" class="form-horizontal">
          <input type="hidden" id="id_lugar" name="id_lugar" value="">
          <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="control-label">Nombre Lugar<span class="required">*</span></label>
                <input class="form-control" id="txtNombre" name="txtNombre" type="text" required="">
              </div>
              <div class="form-group">
                <label class="control-label">Descripción Lugar</label>
                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Localidad<span class="required">*</span></label>
                <input class="form-control" id="txtLocalidad" name="txtLocalidad" type="text" placeholder="Localidad Lugar" required="">
              </div>
              <div class="form-group">
                <label for="exampleSelect1">Estado <span class="required">*</span></label>
                <select class="form-control selectpicker" id="listStatus" name="listStatus" required="">
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
              <br></br>
              <div class="form-group">
                <label class="control-label">Direccion<span class="required">*</span></label>
                <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" placeholder="Ej: Calle 65 car 13-25" required="">
              </div>
              <br></br>
              <div class="form-group">
                <label class="control-label">Tipo de lugar<span class="required">*</span></label>
                <input type="text" class="form-control valid validText" id="txtTipoLugar" name="txtTipoLugar" placeholder="Ej: Religioso, Ambiental, Historico" required="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group ">
              <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
              <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
            </div>
          </div>

          <div class="tile-footer">
            <div class="form-group col-md-12">
              <div id="containerGallery">
                <span>Galeria de fotos</span>
                <button class="btnAddImage btn btn-info btn-sm" type="button">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
              <hr>
              <div id="containerImages">
                <div id="div24">
                  <div class="preImage">
                     <img src="<?= media(); ?>/images/uploads" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalViewCategoria" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de la categoría</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>ID:</td>
              <td id="celId"></td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre"></td>
            </tr>
            <tr>
              <td>Descripción:</td>
              <td id="celDescripcion"></td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado"></td>
            </tr>
            <tr>
              <td>Foto:</td>
              <td id="imgCategoria"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>