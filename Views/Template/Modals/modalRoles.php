<!-- Vertically centered scrollable modal -->
<div class="modal fade" id="modalFormRol" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Rol</h5>
                <button type="button" class="custom-close-btn" data-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formRol" name="formRol">
                            <input type="hidden" id="idrol" name="idrol" value="">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre Rol" required="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripción del Rol" required=""></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="exampleSelect1">Estado</label>
                                <select class="form-control" id="listStatus" name="listStatus">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                            <div class="tile-footer">
                                <button id="btnActionForm" class="btn btn-primary" type="submit">
                                    <i class="bi bi-check-circle-fill me-2"></i><span id="btnText">Guardar</span>
                                </button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                    <i class="bi bi-x-circle-fill me-2"></i>Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>