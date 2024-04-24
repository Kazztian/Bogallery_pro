<!-- Vertically centered scrollable modal -->
<div class="modal fade" id="modalFormRol" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTittle">Nuevo Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formRol" name="formRol">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre Rol" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" id="txtDesc" name="txtDesc" rows="2" placeholder="Descripción del Rol" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="exampleSelect1">Estado</label>
                                <select class="form-control" id="listStatus" name="listStatus" required>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Guardar</button>
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill me-2"></i>Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>