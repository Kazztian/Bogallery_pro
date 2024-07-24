let tableUsuarios;
let rowTable = "";
let divLoading = document.querySelector('#divLoading');

document.addEventListener('DOMContentLoaded', function() {
    // Creamos un elemento <script> para cargar SweetAlert desde el CDN
    let script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@9';

    // Agregamos un evento para manejar el estado de carga del script
    script.onload = function() {
        // Una vez que SweetAlert está cargado, podemos usarlo
        inicializarTabla();
    };

    // Agregamos el script al final del <body> para asegurarnos de que se cargue antes de usarlo
    document.body.appendChild(script);


function inicializarTabla() {
    tableUsuarios = $("#tableUsuarios").DataTable({
        aProcessing: true,
        aServerSide: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        ajax: {
            url: base_url + "/Usuarios/getUsuarios",
            dataSrc: ''
        },
        columns: [
            { data: "id_usuario" },
            { data: "nombres" },
            { data: "apellidos" },
            { data: "email_user" },
            { data: "telefono" },
            { data: "nombrerol" },
            { data: "status" },
            { data: "options" },
        ],
        dom: 'lBfrtip',  // Indica a DataTables que muestre los botones en la tabla
        buttons: [
           
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        responsive: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, "desc"]],
    });
}
    // Manejo del formulario de usuario
    if(document.querySelector("#formUsuario")){
    let formUsuario = document.querySelector("#formUsuario");
    formUsuario.onsubmit = function(e) {
        e.preventDefault();
//Capturacion de datos del formulario de usuarios 
        let strNombre = document.querySelector('#txtNombre').value;
        let strApellido = document.querySelector('#txtApellido').value;
        let strEmail = document.querySelector('#txtEmail').value;
        let intTelefono = document.querySelector('#txtTelefono').value;
        let intEdad = document.querySelector('#txtEdad').value;
        let strDireccion = document.querySelector('#txtDireccion').value;
        let strPrimerI = document.querySelector('#txtPrimerI').value;
        let strSegundoI = document.querySelector('#txtSegundoI').value;
        let intTipousuario = document.querySelector('#listRolid').value;
        let strPassword = document.querySelector('#txtPassword').value;
        let intStatus = document.querySelector('#listStatus').value;
//Para generar el status inactivo lo tendriamos que llamar como arriba en listRolid

//Validacion patra los datos vacios
        if (strNombre === '' || strApellido === '' || strEmail === '' || intTelefono === '' || intEdad === '' || strDireccion === '' || strPrimerI === '' || strSegundoI === '' || intTipousuario === '') {
            // Utilizamos SweetAlert en lugar de swal()
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
//Validacion de alerta datos vacios 
        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) { 
            if(elementsValid[i].classList.contains('is-invalid')) { 
                Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                return false;
            } 
        } 
        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Usuarios/setUsuario'; 
        let formData = new FormData(formUsuario);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
/*Aqui se optine el resultado del Model Y controlador de Usuarios
para insertar un nuevo usuario y asi poder optener los datos y convertir el
JSON en un objeto el cual estamos opteniendo en Usuarios 
osea el array de los mensajes*/
        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
                console.log(request.responseText);  // Añade esto
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    if(rowTable == ""){
                        tableUsuarios.ajax.reload(function() {
                            // Callback function after reloading the table, if needed
                        });

                    }else{
                        htmlStatus = intStatus == 1 ? 
                        '<span class="badge badge-success">Activo</span>' : 
                        '<span class="badge badge-danger">Inactivo</span>';
                        rowTable.cells[1].textContent = strNombre;
                        rowTable.cells[2].textContent = strApellido;
                        rowTable.cells[3].textContent = strEmail;
                        rowTable.cells[4].textContent = intTelefono;
                        rowTable.cells[5].textContent = document.querySelector("#listRolid").selectedOptions[0].text;
                        rowTable.cells[6].innerHTML = htmlStatus;
                            rowTable="";
                    }
                    $('#modalFormUsuario').modal("hide");
                    // Utilizamos SweetAlert en lugar de swal()
                    Swal.fire("Usuarios", objData.msg, "success");
                    tableUsuarios.ajax.reload(function() {
                        // Callback function after reloading the table, if needed
                    });
                } else {
                    // Utilizamos SweetAlert en lugar de swal()
                    Swal.fire("Error", objData.msg, "error");
                }
            }
            divLoading.style.display="none";
            return false;
        }
    };

    
}
//Actualizar perfil
if(document.querySelector("#formPerfil")){
    let formUsuario = document.querySelector("#formPerfil");
    formUsuario.onsubmit = function(e) {
        e.preventDefault();
//Capturacion de datos del formulario de usuarios 
        let strNombre = document.querySelector('#txtNombre').value;
        let strApellido = document.querySelector('#txtApellido').value;
        let intTelefono = document.querySelector('#txtTelefono').value;
        let intEdad = document.querySelector('#txtEdad').value;
        let strDireccion = document.querySelector('#txtDireccion').value;
        let strPrimerI = document.querySelector('#txtPrimerI').value;
        let strSegundoI = document.querySelector('#txtSegundoI').value;
        let strPassword = document.querySelector('#txtPassword').value;
        let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
//Para generar el status inactivo lo tendriamos que llamar como arriba en listRolid

//Validacion patra los datos vacios
        if (strNombre === '' || strApellido === ''  || intTelefono === '' || intEdad === '' || strDireccion === '' || strPrimerI === '' || strSegundoI === '' ) {
            // Utilizamos SweetAlert en lugar de swal()
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        if(strPassword != "" || strPasswordConfirm != "")
            {   
                if( strPassword != strPasswordConfirm ){
                    Swal.fire("Atención", "Las contraseñas no son iguales." , "info");
                    return false;
                }           
                if(strPassword.length < 5 ){
                    Swal.fire("Atención", "La contraseña debe tener un mínimo de 5 caracteres." , "info");
                    return false;
                }
            }
//Validacion de alerta datos vacios 
        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) { 
            if(elementsValid[i].classList.contains('is-invalid')) { 
                Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                return false;
            } 
        } 
        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Usuarios/putPerfil'; 
        let formData = new FormData(formPerfil);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
/*Aqui se optine el resultado del Model Y controlador de Usuarios
para insertar un nuevo usuario y asi poder optener los datos y convertir el
JSON en un objeto el cual estamos opteniendo en Usuarios 
osea el array de los mensajes*/
request.onreadystatechange = function() {
    if (request.readyState !== 4) return;
    if (request.status === 200) {
        console.log(request.responseText);  // Añade esto para depurar
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
            $('#modalFormPerfil').modal("hide");
            Swal.fire({
                title: "",
                text: objData.msg,
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    }
    divLoading.style.display = "none";
    return false;
}

    };
}
 
//Actualizar Datos Fiscales
if(document.querySelector("#formDataFiscal")){
    let formUsuario = document.querySelector("#formDataFiscal");
    formUsuario.onsubmit = function(e) {
        e.preventDefault();
//Capturacion de datos del formulario de usuarios 
        let strNit = document.querySelector('#txtNit').value;
        let strNombreFiscal = document.querySelector('#txtNombreFiscal').value;
        let strDirFiscal = document.querySelector('#txtDirFiscal').value;
    
//Para generar el status inactivo lo tendriamos que llamar como arriba en listRolid

//Validacion patra los datos vacios
        if (strNit === '' || strNombreFiscal === ''  || strDirFiscal === '') {
            // Utilizamos SweetAlert en lugar de swal()
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Usuarios/putDfiscal'; 
        let formData = new FormData(formDataFiscal);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
/*Aqui se optine el resultado del Model Y controlador de Usuarios
para insertar un nuevo usuario y asi poder optener los datos y convertir el
JSON en un objeto el cual estamos opteniendo en Usuarios 
osea el array de los mensajes*/

request.onreadystatechange = function() {
    if (request.readyState !== 4) return;
    if (request.status === 200) {
        console.log(request.responseText);  // Añade esto para depurar
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
            $('#modalFormPerfil').modal("hide");
            Swal.fire({
                title: "",
                text: objData.msg,
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
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

// Cargar roles de usuarios al cargar la página
window.addEventListener('load', function(){
    ftnRolesUsuarios();
    //AQUI PODRIAN IR LAS FUNCIONES DE USUARIO SI NO ABREN
   
}, false);

/*Funcion que hace la peticion para extraer los roles del controlador
Roles y el metodo getSelectRoles*/
function ftnRolesUsuarios() {
    if(document.querySelector('#listRolid'))
        {
            let ajaxUrl = base_url + '/Roles/getSelectRoles';
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        
            request.open("GET", ajaxUrl, true);
            request.send();
        
            request.onreadystatechange = function() {
                if (request.readyState === 4 && request.status === 200) {
                    document.querySelector('#listRolid').innerHTML = request.responseText;
                   // document.querySelector('#listRolid').value = 1;
                    $('#listRolid').selectpicker('render');
                }
            }
        }
        }
   
//Funccion para abrir el modal del usuario
function ftnbViewUsuario(id_usuario) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Usuarios/getUsuario/' + id_usuario;
//Valida sisi se hizo la peticion y si devuelve informacion
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let estadoUsuario = objData.data.status == 1 ?
                '<span class="me-1 badge bg-success" style="display: inline-block; font-size: 0.9rem;">Activo</span>' :
                    '<span class="me-1 badge bg-danger" style="display: inline-block; font-size: 0.9rem;">Inactivo</span>';
//Cargar los datos del formulario
                document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                document.querySelector("#celApellidos").innerHTML = objData.data.apellidos;
                document.querySelector("#celEdad").innerHTML = objData.data.edad;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                document.querySelector("#celDireccion").innerHTML = objData.data.direccion;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celPrimerIdioma").innerHTML = objData.data.primer_idioma;
                document.querySelector("#celSegundoIdioma").innerHTML = objData.data.segundo_idioma;
                document.querySelector("#celEstado").innerHTML = estadoUsuario;
                document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombrerol;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;

                if (!$('#modalViewUser').hasClass('show')) {
                    $('#modalViewUser').modal('show');
                }
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    };

    request.open("GET", ajaxUrl, true);
    request.send();
}
//Funcion para editar los datos del usuario
function fntEditUsuario(element,id_usuario) {
    rowTable = element.parentNode.parentNode.parentNode;
 
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = 'Actualizar';
    document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Usuarios/getUsuario/' + id_usuario;

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
                document.querySelector("#listRolid").value = objData.data.id_rol;
                $('#listRolid').selectpicker('render');

                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');
            }

            // Mostrar el modal solo después de que los datos se hayan cargado
            $('#modalFormUsuario').modal('show');
        }
    };

    request.open("GET", ajaxUrl, true);
    request.send();
}
//Funcion para Eliminar un usuario
function fntDelUsuario(idUsuario) {
    Swal.fire({
        title: "Eliminar Usuario",
        text: "¿Realmente quiere eliminar el Usuario?",
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
            let ajaxUrl = base_url + "/Usuarios/delUsuario/";
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
                        tableUsuarios.ajax.reload(); // Recargar la tabla sin llamar a fntDelRol nuevamente
                    } else {
                        Swal.fire("Atencion!", objData.msg, "error");
                    }
                }
            };
        }
    });
}

//Codigo para abrir el modal de los usuarios
function openModal() {
    rowTable = "";
    document.querySelector('#idUsuario').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
}
function openModalPerfil(){
    $('#modalFormPerfil').modal('show');
}
