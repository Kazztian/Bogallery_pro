var tableUsuarios;
document.addEventListener('DOMContentLoaded', function(){

    tableUsuarios = $('#tableUsuarios').dataTable({
        aProcessing: true,
        aServerSide: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json", //Configuracion del lenguaje
        },
        "ajax": {
            "url": " "+base_url+"/Usuarios/getUsuarios",
            "dataSrc": "",
        },
        "columns": [
            { "data": "id_usuario" },
            { "data": "nombres" },
            { "data": "apellidos" },
            { "data": "edad" },
            { "data": "telefono" },
            { "data": "email_user" },
            { "data": "primer_idioma" },
            { "data": "status" },
            { "data": "options" },
        ],
        responsive: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, "desc"]],
    });

    var formUsuario = document.querySelector("#formUsuario");
    formUsuario.onsubmit = function(e){
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

        if(strNombre == '' || strApellido == '' || strEmail == '' || intTelefono == '' || intEdad == '' || strDireccion == '' || strPrimerI == '' || strSegundoI == '' || intTipousuario == '') {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url + '/Usuarios/setUsuario'; 
        var formData = new FormData(formUsuario);
        request.open("POST", ajaxUrl, true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status) {
                    $('#modalFormUsuario').modal("hide");
                    Swal.fire("Usuarios", objData.msg, "success");
                    tableUsuarios.api().ajax.reload(function(){
                        // Callback function after reloading the table, if needed
                    });
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            }
        }
    }
}, false);

window.addEventListener('load', function(){
    ftnRolesUsuarios();
}, false);

function ftnRolesUsuarios(){
    var ajazUrl = base_url + '/Roles/getSelectRoles';
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

    request.open("GET", ajazUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listRolid').innerHTML = request.responseText;
            document.querySelector('#listRolid').value = 1;
            $('#listRolid').selectpicker('render');
        }
    }
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
