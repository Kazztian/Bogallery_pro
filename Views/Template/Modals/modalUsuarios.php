<!-- Vertically centered scrollable modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
                <button type="button" class="custom-close-btn" data-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <form id="formUsuario" name="formUsuario" class="form-horizontal">
                    <input type="hidden" id="idUsuario" name="idUsuario" value="">
                    <p class="text-primary">Todos los campos son obligatorios</p>

                    <!-- <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtIdentificacion">Identificacion</label>
                            <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" require="">
                        </div>
                    </div> -->

                    <div class="row">
                        <div class=" col-md-6">
                            <div class="form-group">
                                <label for="txtNombre">Nombres</label>
                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtApellido">Apellidos</label>
                                <input type="text" class="form-control" id="txtApellido" name="txtApellido" required="">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtTelefono">Telefono</label>
                                <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtEmail">Email</label>
                                <input type="email" class="form-control" id="txtEmail" name="txtEmail" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtEdad">Edad</label>
                                <input type="text" class="form-control" id="txtEdad" name="txtEdad" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtDireccion">Direccion</label>
                                <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" required="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtPrimerI">Primer Idioma</label>
                                <input type="text" class="form-control" id="txtPrimerI" name="txtPrimerI" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtSegundoI">Segundo Idioma</label>
                                <input type="text" class="form-control" id="txtSegundoI" name="txtSegundoI" required="">
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="listRolid">Tipo usuario</label>
                                <select class="form-control" data-live-search="true" id="listRolid" name="listRolid" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="listStatus">Status</label>
                                <select class="form-control selectpicker" id="listStatus" name="listStatus" required>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtPassword">Passaword</label>
                            <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                        </div>
                    </div>
                    <br><br>

                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span>
                        </button>&nbsp;&nbsp;&nbsp;

                        <button class="btn btn-danger" type="button" data-dismiss="modal">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i>Cerrar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Odal de usuario -->

<!-- Vertically centered scrollable modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
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
                            <td>Email (Usuario)</td>
                            <td id="celEmail">Jose</td>
                        </tr>
                        <tr>
                            <td>Telefono</td>
                            <td id="celTelefono">Jose</td>
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
                            <td>Fecha registro</td>
                            <td id="celFechaRegistro">Jose</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>