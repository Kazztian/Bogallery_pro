let tableClientes;
let rowTable = "";
let divLoading = document.querySelector('#divLoading');

document.addEventListener('DOMContentLoaded', function() {
    // Creamos un elemento <script> para cargar SweetAlert desde el CDN
    let script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@9';
    script.onload = function() {
        // Una vez que SweetAlert está cargado, podemos usarlo
        inicializarTabla();
    };
    document.body.appendChild(script);

    function inicializarTabla() {
        tableClientes = $("#tableClientes").DataTable({
            aProcessing: true,
            aServerSide: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
            },
            ajax: {
                url: base_url + "/Clientes/getClientes",
                dataSrc: ''
            },
            columns: [
                { data: "id_usuario" },
                { data: "nombres" },
                { data: "apellidos" },
                { data: "email_user" },
                { data: "telefono" },
                { data: "options" },
            ],
            
            dom: 'lBfrtip',  // Indica a DataTables que muestre los botones en la tabla
            buttons: [
                {
                    "extend": "copyHtml5",
                    "text": "<i class='far fa-copy'></i> Copiar",
                    "titleAttr":"Copiar",
                    "className": "btn btn-secondary",
                    "exportOptions": { 
                        "columns": [ 0, 1, 2, 3, 4, 5] 
                    }
                    
                },{
                    "extend": "excelHtml5",
                    "text": "<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr":"Esportar a Excel",
                    "className": "btn btn-success",
                    "exportOptions": { 
                        "columns": [ 0, 1, 2, 3, 4, 5] 
                    }
                },{
                    "extend": "pdfHtml5",
                    "text": "<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr":"Esportar a PDF",
                    "className": "btn btn-danger",
                    "exportOptions": { 
                        "columns": [ 0, 1, 2, 3, 4, 5] 
                    }
                },{
                    "extend": "csvHtml5",
                    "text": "<i class='fas fa-file-csv'></i> CSV",
                    "titleAttr":"Esportar a CSV",
                    "className": "btn btn-info",
                    "exportOptions": { 
                        "columns": [ 0, 1, 2, 3, 4, 5] 
                    }
                }
            ],
            responsive: true,
            bDestroy: true,
            iDisplayLength: 10,
            order: [[0, "desc"]],
        });
    }

    if(document.querySelector("#formCliente")){
        let formCliente = document.querySelector("#formCliente");
        formCliente.onsubmit = function(e) {
            e.preventDefault();
            // Captura de datos del formulario de usuarios 
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let intEdad = document.querySelector('#txtEdad').value;
            let strDireccion = document.querySelector('#txtDireccion').value;
            let strPrimerI = document.querySelector('#txtPrimerI').value;
            let strSegundoI = document.querySelector('#txtSegundoI').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let strNit = document.querySelector('#txtNit').value;
            let strNombreFiscal = document.querySelector('#txtNombreFiscal').value;
            let strDirFiscal = document.querySelector('#txtDirFiscal').value;

            // Validación para los datos vacíos
            if (strNombre === '' || strApellido === '' || strEmail === '' || intTelefono === '' || intEdad === '' || strDireccion === '' || strPrimerI === '' || strSegundoI === '' || strNit === '' || strNombreFiscal === '' || strDirFiscal === '') {
                Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Clientes/setCliente'; 
            let formData = new FormData(formCliente);
            request.open("POST", ajaxUrl, true);
            request.send(formData);

            request.onreadystatechange = function() {
                if (request.readyState === 4 && request.status === 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        if (rowTable == "") {
                            tableClientes.ajax.reload(null, false); // False to avoid resetting pagination
                        } else {
                            rowTable.cells[1].textContent = strNombre;
                            rowTable.cells[2].textContent = strApellido;
                            rowTable.cells[3].textContent = strEmail;
                            rowTable.cells[4].textContent = intTelefono;
                            rowTable = "";
                        }
                        $('#modalFormCliente').modal("hide");
                        Swal.fire("Usuarios", objData.msg, "success");
                    } else {
                        Swal.fire("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        };
    }
}, false);

// Función para abrir el modal del usuario
function ftnbViewInfo(id_usuario) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Clientes/getCliente/' + id_usuario;

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                document.querySelector("#celApellidos").innerHTML = objData.data.apellidos;
                document.querySelector("#celEdad").innerHTML = objData.data.edad;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                document.querySelector("#celDireccion").innerHTML = objData.data.direccion;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celPrimerIdioma").innerHTML = objData.data.primer_idioma;
                document.querySelector("#celSegundoIdioma").innerHTML = objData.data.segundo_idioma;
                document.querySelector("#celIde").innerHTML = objData.data.nit;
                document.querySelector("#celNomFiscal").innerHTML = objData.data.nombrefiscal;
                document.querySelector("#celDirFiscal").innerHTML = objData.data.direccionfiscal;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;

                if (!$('#modalViewCliente').hasClass('show')) {
                    $('#modalViewCliente').modal('show');
                }
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    };

    request.open("GET", ajaxUrl, true);
    request.send();
}

function fntEditInfo(element, id_usuario) {
    rowTable = element.parentNode.parentNode.parentNode;

    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = 'Actualizar';
    document.querySelector('#titleModal').innerHTML = "Actualizar Cliente";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Clientes/getCliente/' + id_usuario;

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#idUsuario").value = objData.data.id_usuario;
                document.querySelector("#txtNombre").value = objData.data.nombres;
                document.querySelector("#txtApellido").value = objData.data.apellidos;
                document.querySelector("#txtTelefono").value = objData.data.telefono;
                document.querySelector("#txtEmail").value = objData.data.email_user;
                document.querySelector("#txtDireccion").value = objData.data.direccion;
                document.querySelector("#txtEdad").value = objData.data.edad;
                document.querySelector("#txtPrimerI").value = objData.data.primer_idioma;
                document.querySelector("#txtSegundoI").value = objData.data.segundo_idioma;
                document.querySelector("#txtNit").value = objData.data.nit;
                document.querySelector("#txtNombreFiscal").value = objData.data.nombrefiscal;
                document.querySelector("#txtDirFiscal").value = objData.data.direccionfiscal;
            }
            $('#modalFormCliente').modal('show');
        }
    };

    request.open("GET", ajaxUrl, true);
    request.send();
}

function fntDelInfo(idUsuario) {
    Swal.fire({
        title: "Eliminar Cliente",
        text: "¿Realmente quiere eliminar el Cliente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            let request = window.XMLHttpRequest
                ? new XMLHttpRequest()
                : new ActiveXObject("Microsoft.XMLHTTP");
            let ajaxUrl = base_url + "/Clientes/delCliente/";
            let strData = "idUsuario=" + idUsuario;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader(
                "Content-type",
                "application/x-www-form-urlencoded"
            );
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        Swal.fire("Eliminar!", objData.msg, "success");
                        // Recargar la tabla después de la eliminación
                        tableClientes.ajax.reload(null, false);
                    } else {
                        Swal.fire("Atencion!", objData.msg, "error");
                    }
                }
            };
        }
    });
}
function openModal() {
    rowTable = "";
    document.querySelector('#idUsuario').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#titleModal').innerHTML = "Cliente Usuario";
    document.querySelector("#formCliente").reset();
    $('#modalFormCliente').modal('show');
}
