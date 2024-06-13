// Script de SweetAlert2
var script = document.createElement("script");
script.src = "https://cdn.jsdelivr.net/npm/sweetalert2@9";
document.head.appendChild(script);

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector("#formCambiarPass")) {
        let formCambiarPass = document.querySelector("#formCambiarPass");
        formCambiarPass.onsubmit = function(e) {
            e.preventDefault();

            let strPassword = document.querySelector('#txtPassword').value;
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
            let id_usuario = document.querySelector('#id_usuario').value;

            if (strPassword == "" || strPasswordConfirm == "") {
                Swal.fire("Por favor", "Ingrese la nueva contraseña.", "error");
                return false;
            } else {
                if (strPassword.length < 5) {
                    Swal.fire("Atención", "La contraseña debe tener al menos 5 caracteres.", "info");
                    return false;
                }

                if (strPassword != strPasswordConfirm) {
                    Swal.fire("Atencion", "Las contraseñas no son iguales.", "info");
                    return false;
                }

                var request = (window.XMLHttpRequest) ?
                    new XMLHttpRequest() :
                    new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url + '/Login/setPassword';
                var formData = new FormData(formCambiarPass);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function() {
                    if (request.readyState != 4) return;
                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            Swal.fire("Éxito", objData.msg, "success").then(function() {
                                window.location = base_url + '/login';
                            });
                        } else {
                            Swal.fire("Atención", objData.msg, "error");
                        }
                    } else {
                        Swal.fire("Atención", "Error en el proceso.", "error");
                    }
                }
            }
        }
    }
}, false);
