var tableRoles;
var divLoading = document.querySelector('#divLoading');
document.addEventListener("DOMContentLoaded", function () {
    // Creamos un elemento <script> para cargar SweetAlert desde el CDN
    var script = document.createElement("script");
    script.src = "https://cdn.jsdelivr.net/npm/sweetalert2@9";


    

    // Agregamos el script al final del <body> para asegurarnos de que se cargue antes de usarlo
    document.body.appendChild(script);

    script.onload = function () {
        // Una vez que SweetAlert está cargado, podemos usarlo sin problemas
        tableRoles = $("#tableRoles").dataTable({
            aProcessing: true,
            aServerSide: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json", // Configuración del lenguaje
            },
            ajax: {
                url: "" + base_url + "/Roles/getRoles",
                dataSrc: "",
            },
            columns: [
                { data: "id_rol" },
                { data: "nombrerol" },
                { data: "descripcion" },
                { data: "status" },
                { data: "options" },
            ],
            columnDefs: [
                { 'className': "text-center", "targets": [3] },  // Clase correcta para centrar el texto en la columna status
            ],
            responsive: true,
            bDestroy: true,
            iDisplayLength: 10,
            order: [[0, "desc"]],
        });

        // Creacion de un nuevo rol
        var formRol = document.querySelector("#formRol");
        formRol.onsubmit = function (e) {
            e.preventDefault(); //prevenir que se recargue la pagina

            var intIdrol = document.querySelector("#idrol").value;
            var strNombre = document.querySelector("#txtNombre").value;
            var strDescripcion = document.querySelector("#txtDescripcion").value;
            var intStatus = document.querySelector("#listStatus").value;
            if (strNombre == "" || strDescripcion == "" || intStatus == "") {
                // Utilizamos SweetAlert en lugar de swal()
                Swal.fire(
                    "Atención",
                    "Todos los campos son obligatorios y requeridos.",
                    "error"
                );
                return false;
            }
            divLoading.style.display = "flex";
            var request = window.XMLHttpRequest
                ? new XMLHttpRequest()
                : new ActiveXObject("Microsoft.XMLHTTP");
            var ajaxUrl = base_url + "/Roles/setRol"; //peticion hacia los     objetos por medio de ajax
            var formData = new FormData(formRol);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        $("#modalFormRol").modal("hide");
                        formRol.reset(); // Aquí está la corrección
                        Swal.fire({
                            icon: "success",
                            title: "Roles de usuario",
                            text: objData.msg,
                            confirmButtonColor: "#689F38",
                            confirmButtonText: "OK",
                        });
                        tableRoles.api().ajax.reload(function () {
                            fntEditRol();
                        });
                    } else {
                        Swal.fire({
                            icon: "warning",
                            title: "Advertencia",
                            text: objData.msg,
                            confirmButtonColor: "#FFA000",
                            confirmButtonText: "Ok",
                        });
                    }

                }
                divLoading.style.display="none";
                return false;
            };
        };
    };
});

$("#tableRoles").DataTable();
function openModal() {
    document.querySelector("#idrol").value = "";
    document
        .querySelector(".modal-header")
        .classList.replace("headerUpdate", "headerRegister");
    document
        .querySelector("#btnActionForm")
        .classList.replace("btn-info", "btn-primary");
    document.querySelector("#btnText").innerHTML = "Guardar";
    document.querySelector("#titleModal").innerHTML = "Nuevo Rol";
    document.querySelector("#formRol").reset(); //limpia todos los campos

    $("#modalFormRol").modal("show"); //mostrar el modal
}
//funcion para los botones
window.addEventListener(
    "load",
    function () {
        // fntEditRol();
    },
    false
);
// Funcion para acutualizar un rol
function fntEditRol(idrol) {
    document.querySelector("#titleModal").innerHTML = "Actualizar Rol";
    document
        .querySelector(".modal-header")
        .classList.replace("headerRegister", "headerUpdate");
    document
        .querySelector("#btnActionForm")
        .classList.replace("btn-primary", "btn-info");
    document.querySelector("#btnText").innerHTML = "Actualizar";

    var idrol = idrol;
    var request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
    var ajaxetUser = base_url + "/Roles/getRol/" + idrol;
    request.open("GET", ajaxetUser, true);
    request.send(); // Se envia la peticion

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);

            if (objData.status) {
                document.querySelector("#idrol").value = objData.data.id_rol; //como esta en el formulario-como esta en la db
                document.querySelector("#txtNombre").value = objData.data.nombrerol;
                document.querySelector("#txtDescripcion").value =
                    objData.data.descripcion;

                if (objData.data.status == 1) {
                    var optionSelect =
                        '<option value="1" selected class="notBlock">Activo</option>';
                } else {
                    var optionSelect =
                        '<option value="2" selected class="notBlock">Inactivo</option>';
                }
                var htmlSelect = `
                    ${optionSelect}
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                                                    `;
                document.querySelector("#listStatus").innerHTML = htmlSelect;
                $("#modalFormRol").modal("show");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    };
}

// Funcion para eliminar un rol
function fntDelRol(idrol) {
    Swal.fire({
        title: "Eliminar Rol",
        text: "¿Realmente quiere cancelar el Rol?",
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
            var ajaxUrl = base_url + "/Roles/delRol/";
            var strData = "idrol=" + idrol;
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
                        tableRoles.api().ajax.reload(); // Recargar la tabla sin llamar a fntDelRol nuevamente
                    } else {
                        Swal.fire("Atencion!", objData.msg, "error");
                    }
                }
            };
        }
    });
}

function fntPermisos(idrol) {
    var idrol = idrol;
    var request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/Permisos/getPermisosRol/' + idrol;
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            document.querySelector('#contentAjax').innerHTML = request.responseText;
            $('.modalPermisos').modal("show");
            document
                .querySelector('#formPermisos')
                .addEventListener('submit', fntSavePermisos, false);
        }
    };
}

function fntSavePermisos(evnet){
    evnet.preventDefault();
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Permisos/setPermisos';
    var formElement = document.querySelector('#formPermisos');
    var formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);

    request.onreadystatechange = function(){
        if(request.readyState ==4 &&  request.status ==200){
            var objData = JSON.parse(request.responseText);
            if(objData.status)
                {
                    Swal.fire("Permisos de usuario",objData.msg,"success");

                }else{
                    Swal.fire("Erro", objData.msg,"error");
                }
        }
    }
}
