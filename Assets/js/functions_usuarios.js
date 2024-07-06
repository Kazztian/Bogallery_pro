var tableUsuarios;

document.addEventListener('DOMContentLoaded', function() {
    // Creamos un elemento <script> para cargar SweetAlert desde el CDN
    var script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@9';

    // Agregamos un evento para manejar el estado de carga del script
    script.onload = function() {
        // Una vez que SweetAlert está cargado, podemos usarlo
        inicializarTabla();
    };

    // Agregamos el script al final del <body> para asegurarnos de que se cargue antes de usarlo
    document.body.appendChild(script);
});

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

    // Manejo del formulario de usuario
    var formUsuario = document.querySelector("#formUsuario");
    formUsuario.onsubmit = function(e) {
        e.preventDefault();
//Capturacion de datos del formulario de usuarios 
        var strNombre = document.querySelector('#txtNombre').value;
        var strApellido = document.querySelector('#txtApellido').value;
        var strEmail = document.querySelector('#txtEmail').value;
        var intTelefono = document.querySelector('#txtTelefono').value;
        var intEdad = document.querySelector('#txtEdad').value;
        var strDireccion = document.querySelector('#txtDireccion').value;
        var strPrimerI = document.querySelector('#txtPrimerI').value;
        var strSegundoI = document.querySelector('#txtSegundoI').value;
        var intTipousuario = document.querySelector('#listRolid').value;
        var strPassword = document.querySelector('#txtPassword').value;
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

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url + '/Usuarios/setUsuario'; 
        var formData = new FormData(formUsuario);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
/*Aqui se optine el resultado del Model Y controlador de Usuarios
para insertar un nuevo usuario y asi poder optener los datos y convertir el
JSON en un objeto el cual estamos opteniendo en Usuarios 
osea el array de los mensajes*/
        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
                console.log(request.responseText);  // Añade esto
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
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
        }
    };

    // Cargar roles de usuarios al cargar la página
    window.addEventListener('load', function(){
        ftnRolesUsuarios();
        //AQUI PODRIAN IR LAS FUNCIONES DE USUARIO SI NO ABREN
       
    }, false);
    
}
/*Funcion que hace la peticion para extraer los roles del controlador
Roles y el metodo getSelectRoles*/
function ftnRolesUsuarios() {
    var ajaxUrl = base_url + '/Roles/getSelectRoles';
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

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
//Funccion para abrir el modal del usuario
function ftnbViewUsuario(id_usuario) {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/Usuarios/getUsuario/' + id_usuario;
//Valida sisi se hizo la peticion y si devuelve informacion
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                var estadoUsuario = objData.data.status == 1 ?
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
function fntEditUsuario(id_usuario) {
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = 'Actualizar';
    document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/Usuarios/getUsuario/' + id_usuario;

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
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
            var request = window.XMLHttpRequest
                ? new XMLHttpRequest()
                : new ActiveXObject("Microsoft.XMLHTTP");
            var ajaxUrl = base_url + "/Usuarios/delUsuario/";
            var strData = "idUsuario=" + idUsuario;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader(
                "Content-type",
                "application/x-www-form-urlencoded"
            );
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
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
    document.querySelector('#idUsuario').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
}
