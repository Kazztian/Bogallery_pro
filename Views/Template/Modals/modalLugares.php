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
                <label class="control-label">Descripción Lugar<span class="required">*</span></label>
                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" required=""></textarea>
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
                <input type="text" class="form-control valid validText" id="txtDireccion" name="txtDireccion" placeholder="Ej: Calle 65 car 13-25" required="">
              </div>
              <br></br>
              <div class="form-group">
                <label class="control-label">Tipo de lugar<span class="required">*</span></label>
                <input type="text" class="form-control valid validText" id="txtTipo" name="txtTipo" placeholder="Ej: Religioso, Ambiental, Historico" required="">
              </div>
            </div>
          </div>
          <div class="tile-footer">
            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
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