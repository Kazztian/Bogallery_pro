<!-- Modal -->
<div class="modal fade" id="modalFormPlanes" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Plan Turístico</h5>
        <button type="button" class="custom-close-btn" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <form id="formPlanes" name="formPlanes" class="form-horizontal">
          <input type="hidden" id="idPlanes" name="idPlanes" value="">
          <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Nombre del Plan <span class="required">*</span></label>
                <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del Plan" required>
              </div>
              <div class="form-group">
                <label class="control-label">Descripción</label>
                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Código <span class="required">*</span></label>
                <input class="form-control" id="txtCodigo" name="txtCodigo" type="text" placeholder="Código de barra" required>
              </div>
              <br>
              <div id="divBarCode" class="notblock textcenter">
                <div id="printCode">
                  <svg id="barcode"></svg>
                </div>
                <button class="btn btn-success btn-sm" type="button" onClick="fntPrintBarcode('#printCode')"><i class="fas fa-print"></i> Imprimir</button>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label class="control-label">Precio <span class="required">*</span></label>
                  <input class="form-control validNumber " id="txtPrecio" name="txtPrecio" type="text" required="" onkeypress="return controlTag(event);">
                </div>
                <div class="form-group col-md-6">
                  <label class="control-label">Stock <span class="required">*</span></label>
                  <input class="form-control" id="txtStock" name="txtStock" type="text" required>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-12">
                  <label for="Jornadap">Jornada <span class="required">*</span></label>
                  <select class="form-control selectpicker" id="Jornadap" name="Jornadap" required>
                    <option value="Mañana">Mañana</option>
                    <option value="Tarde">Tarde</option>
                    <option value="Noche">Noche</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="fechaInicio" class="control-label">Fecha Inicio <span class="required">*</span></label>
                  <input class="form-control" id="fechaInicio" name="fechaInicio" type="datetime-local" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="fechaFin" class="control-label">Fecha Fin <span class="required">*</span></label>
                  <input class="form-control" id="fechaFin" name="fechaFin" type="datetime-local" required>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="listCategoria">Categoría<span class="required">*</span></label>
                  <select class="form-control" data-live-search="true" id="listCategoria" name="listCategoria" required></select>
                </div>
                <div class="form-group col-md-6">
                  <label for="listLugar">Lugar<span class="required">*</span></label>
                  <select class="form-control" data-live-search="true" id="listLugar" name="listLugar" required></select>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="listStatus">Estado <span class="required">*</span></label>
                  <select class="form-control selectpicker" id="listStatus" name="listStatus" required>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <button id="btnActionForm" class="btn btn-primary btn-lg btn-block" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i>
                    <span id="btnText">Guardar</span>
                  </button>
                </div>
                <div class="form-group col-md-6">
                  <button class="btn btn-danger btn-lg btn-block" type="button" data-dismiss="modal">
                    <i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar
                  </button>
                </div>
              </div>
            </div>

          </div>

          <div class="tile-footer">
            <div class="form-group col-md-12">
              <div id="containerGallery">
                <span>Agregar foto (440 x 545)</span>
                <button class="btnAddImage btn btn-info btn-sm" type="button">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
              <hr>
              <div id="containerImages">
                <!-- <div id="div24">
                             <div class="prevImage">
                                 <img src="<?= media(); ?>/images/uploads/producto1.jpg">
                             </div>
                             <input type="file" name="foto" id="img1" class="inputUploadfile">
                             <label for="img1" class="btnUploadfile"><i class="fas fa-upload "></i></label>
                             <button class="btnDeleteImage" type="button" onclick="fntDelItem('div24')"><i class="fas fa-trash-alt"></i></button>
                         </div>
                         <div id="div24">
                             <div class="prevImage">
                                 <img class="loading" src="<?= media(); ?>/images/loading.svg">
                             </div>
                             <input type="file" name="foto" id="img1" class="inputUploadfile">
                             <label for="img1" class="btnUploadfile"><i class="fas fa-upload "></i></label>
                             <button class="btnDeleteImage" type="button" onclick="fntDelItem('div24')"><i class="fas fa-trash-alt"></i></button>
                         </div> -->

              </div>
            </div>


          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewPlan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Codigo:</td>
              <td id="celCodigo"></td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre"></td>
            </tr>
            <tr>
              <td>Precio:</td>
              <td id="celPrecio"></td>
            </tr>
            <tr>
              <td>Stock:</td>
              <td id="celStock"></td>
            </tr>
            <tr>
              <td>Categoría:</td>
              <td id="celCategoria"></td>
            </tr>
            <tr>
              <td>Lugar:</td>
              <td id="celLugar"></td>
            </tr>
            <tr>
              <td>Status:</td>
              <td id="celStatus"></td>
            </tr>
            <tr>
              <td>Jornada:</td>
              <td id="celJornadap"></td>
            </tr>
            <tr>
              <td>Fecha Inicio:</td>
              <td id="celFechaInicio"></td>
            </tr>
            <tr>
              <td>Fecha Fin:</td>
              <td id="celFechaFin"></td>
            </tr>
            <tr>
              <td>Descripción:</td>
              <td id="celDescripcion"></td>
            </tr>
            <tr>
              <td>Fotos de referencia:</td>
              <td id="celFotos"></td>
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