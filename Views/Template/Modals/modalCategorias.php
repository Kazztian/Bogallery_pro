<!-- Vertically centered scrollable modal -->
<!-- Modal de Categoria -->
<div class="modal fade" id="modalFormCategorias" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Categoria</h5>
                <button type="button" class="custom-close-btn" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCategoria" name="formCategoria" class="form-horizontal">
                    <input type="hidden" id="idUsuario" name="id_usuario" value="">
                    <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" id="idCategoria" name="idCategoria" value="">
                            <div class="mb-3">
                                <label class="form-label">Nombre <span class="required">*</span></label>
                                <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre Categoria" required="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción <span class="required">*</span></label>
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripción de la Categoria" required=""></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="exampleSelect1">Estado<span class="required">*</span></label>
                                <select class="form-control" id="listStatus" name="listStatus">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="photo">
                                <label for="foto">Foto (570x380)</label>
                                <div class="prevPhoto">
                                    <span class="delPhoto notBlock">X</span>
                                    <label for="foto"></label>
                                    <div>
                                        <img id="img" src="<?= media(); ?>/images/portada_categoria.png" alt="Foto de categoría">
                                    </div>
                                </div>
                                <div class="upimg">
                                    <input type="file" name="foto" id="foto">
                                </div>
                                <div id="form_alert"></div>
                            </div>
                        </div>

                    </div>
            </div>
            <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span>
                </button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    <i class="fa fa-fw fa-lg fa-check-circle"></i>Cerrar
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Modal de Categoria -->

<!-- Vertically centered scrollable modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del usuario</h5>
                <button type="button" class="custom-close-btn" data-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Nombres</td>
                            <td id="celNombre">Jose</td>
                        </tr>
                        <tr>
                            <td>Apellidos</td>
                            <td id="celApellidos">Jose</td>
                        </tr>
                        <tr>
                            <td>Edad</td>
                            <td id="celEdad">Jose</td>
                        </tr>
                        <tr>
                            <td>Dirreccion</td>
                            <td id="celDireccion">Jose</td>
                        </tr>
                        <tr>
                            <td>Email (Usuario)</td>
                            <td id="celEmail">Jose</td>
                        </tr>
                        <tr>
                            <td>Telefono</td>
                            <td id="celTelefono">Jose</td>
                        </tr>

                        <tr>
                            <td>Primer Idioma</td>
                            <td id="celPrimerIdioma">Jose</td>
                        </tr>
                        <tr>
                            <td>Primer Idioma</td>
                            <td id="celSegundoIdioma">Jose</td>
                        </tr>
                        <tr>
                            <td>Tipo Usuario</td>
                            <td id="celTipoUsuario">Jose</td>
                        </tr>
                        <tr>
                            <td>Estatus</td>
                            <td id="celEstado">Jose</td>
                        </tr>
                        <tr>
                        <tr>
                            <td>Fecha registro</td>
                            <td id="celFechaRegistro">Jose</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>