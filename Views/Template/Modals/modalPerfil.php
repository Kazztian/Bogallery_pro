<!-- Vertically centered scrollable modal -->
<div class="modal fade" id="modalFormPerfil" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header headerUpdate">
                <h5 class="modal-title" id="titleModal">Actualizar Datos</h5>
                <button type="button" class="custom-close-btn" data-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <form id="formPerfil" name="formPerfil" class="form-horizontal">
                    <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>


                    <div class="row">
                        <div class=" col-md-6">
                            <div class="form-group">
                                <label for="txtNombre">Nombres <span class="required">*</span></label>
                                <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" value="<?= $_SESSION['userData']['nombres']; ?>" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtApellido">Apellidos <span class="required">*</span></label>
                                <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" value="<?= $_SESSION['userData']['apellidos']; ?>" required="">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtTelefono">Telefono <span class="required">*</span></label>
                                <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" value="<?= $_SESSION['userData']['telefono']; ?>" onkeypress="return controlTag(event);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtEmail">Email </label>
                                <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" value="<?= $_SESSION['userData']['email_user']; ?>" required="" readonly disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtPrimerI">Primer Idioma <span class="required">*</span></label>
                                <input type="text" class="form-control valid validText" id="txtPrimerI" name="txtPrimerI" value="<?= $_SESSION['userData']['apellidos']; ?>" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtSegundoI">Segundo Idioma <span class="required">*</span></label>
                                <input type="text" class="form-control valid validText" id="txtSegundoI" name="txtSegundoI" value="<?= $_SESSION['userData']['apellidos']; ?>" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtEdad">Edad <span class="required">*</span></label>
                                <input type="text" class="form-control valid validNumber" id="txtEdad" name="txtEdad" value="<?= $_SESSION['userData']['apellidos']; ?>" required="" onkeypress="return controlTag(event);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtDireccion">Direccion <span class="required">*</span></label>
                                <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" value="<?= $_SESSION['userData']['apellidos']; ?>" required="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtPassword">Passaword</label>
                            <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtPasswordConfirm">Confirmar Passaword</label>
                            <input type="password" class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm">
                        </div>
                    </div>
                    <br><br>

                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-info" type="submit">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span>
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