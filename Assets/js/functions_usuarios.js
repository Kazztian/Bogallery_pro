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
        responsive: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, "desc"]],
    });

    // Manejo del formulario de usuario
    var formUsuario = document.querySelector("#formUsuario");
    formUsuario.onsubmit = function(e) {
        e.preventDefault();

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

        if (strNombre === '' || strApellido === '' || strEmail === '' || intTelefono === '' || intEdad === '' || strDireccion === '' || strPrimerI === '' || strSegundoI === '' || intTipousuario === '') {
            // Utilizamos SweetAlert en lugar de swal()
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url + '/Usuarios/setUsuario'; 
        var formData = new FormData(formUsuario);
        request.open("POST", ajaxUrl, true);
        request.send(formData);

        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
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
       
    }, false);
    
}

function ftnRolesUsuarios() {
    var ajaxUrl = base_url + '/Roles/getSelectRoles';
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            document.querySelector('#listRolid').innerHTML = request.responseText;
            document.querySelector('#listRolid').value = 1;
            $('#listRolid').selectpicker('render');
        }
    }
}

function ftnbViewUsuario(id_usuario) {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/Usuarios/getUsuario/' + id_usuario;

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                var estadoUsuario = objData.data.status == 1 ?
                '<span class="me-1 badge bg-success" style="display: inline-block; font-size: 0.9rem;">Activo</span>' :
                    '<span class="me-1 badge bg-danger" style="display: inline-block; font-size: 0.9rem;">Inactivo</span>';

                document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                document.querySelector("#celApellidos").innerHTML = objData.data.apellidos;
                document.querySelector("#celEdad").innerHTML = objData.data.edad;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
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

function openModal() {
    document.querySelector('#idUsuario').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
}
