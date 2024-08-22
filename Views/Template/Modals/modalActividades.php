<!-- Modal -->
<div class="modal fade" id="modalFormActividades" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevas Actividades</h5>
                <button type="button" class="custom-close-btn" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formActividades" name="formActividades" class="form-horizontal">
                    <input type="hidden" id="id_actividad" name="id_actividad" value="">
                    <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label">Nombre Actividad<span class="required">*</span></label>
                                <input class="form-control" id="txtNombre" name="txtNombre" type="text" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Descripción Actividad</label>
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Jornada<span class="required">*</span></label>
                                <input class="form-control" id="txtJornada" name="txtJornada" type="text" required="">
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
                                <label class="control-label">Valor<span class="required">*</span></label>
                                <input type="text" class="form-control" id="txtValor" name="txtValor" required="">
                            </div>
                            <br></br>
                            <div class="form-group">
                                <label for="listLugar">Lugar <span class="required">*</span></label>
                                <select class="form-control" data-live-search="true" id="listLugar" name="listLugar" required=""></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
                            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
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
                             <!--   <div id="div24">
                                    <div class="prevImage">
                                        <img src="<?= media(); ?>/images/uploads/MONSERRATE.jpg" alt="">
                                    </div>
                                    <input type="file" name="foto" id="img1" class="inputUploadfile">
                                    <label for="img1" class="btnUploadfile"><i class="fas fa-upload "></i></label>
                                    <button class="btnDeleteImage" type="button" onclick="fntDelItem('div24')"><i class="fas fa-trash-alt"></i></button>
                                </div>
                                <div id="div24">
                                    <div class="prevImage">
                                        <img class="loading" src="<?= media(); ?>/images/loading.svg" alt="">
                                    </div>
                                    <input type="file" name="foto" id="img1" class="inputUploadfile">
                                    <label for="img1" class="btnUploadfile"><i class="fas fa-upload "></i></label>
                                    <button class="btnDeleteImage" type="button" onclick="fntDelItem('div24')"><i class="fas fa-trash-alt"></i></button>
-->
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
<div class="modal fade" id="modalViewLugar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del lugar</h5>
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
                            <td>Nombre Lugar:</td>
                            <td id="celNombre"></td>
                        </tr>
                        <tr>
                            <td>Localidad:</td>
                            <td id="celLocalidad"></td>
                        </tr>

                        <tr>
                            <td>Dirección:</td>
                            <td id="celDirección"></td>
                        </tr>

                        <tr>
                            <td>Tipo Lugar:</td>
                            <td id="celTipo"></td>
                        </tr>

                        <tr>
                            <td>Descripción:</td>
                            <td id="celDescripcion"></td>
                        </tr>

                        <tr>
                        <tr>
                            <td>Estado:</td>
                            <td id="celStatus"></td>
                        </tr>

                        <tr>
                            <td>Foto:</td>
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