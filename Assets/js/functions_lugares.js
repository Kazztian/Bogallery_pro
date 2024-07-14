function openModal() {
    rowTable = "";
    document.querySelector('#id_lugar').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo lugar";
    document.querySelector("#formLugares").reset();
    $('#modalFormLugares').modal('show');
   
};