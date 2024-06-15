// Script de SweetAlert2
var script = document.createElement("script");
script.src = "https://cdn.jsdelivr.net/npm/sweetalert2@9";
document.head.appendChild(script);

// Función para flip de la caja de login
$('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
});

// Función para manejar el envío del formulario y mostrar alertas
document.addEventListener('DOMContentLoaded', function() {

    if (document.querySelector("#formLogin")) {
        let formLogin = document.querySelector("#formLogin");
        formLogin.onsubmit = function(e) {
            e.preventDefault();

            let strEmail = document.querySelector('#txtEmail').value;
            let strPassword = document.querySelector('#txtPassword').value;

            if (strEmail == "" || strPassword == "") {
                Swal.fire("Por Favor", "Escribe usuario y contraseña.", "error");
                return false;
            } else {
                var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
                var ajaxUrl = base_url + '/Login/loginUser';
                var formData = new FormData(formLogin);
                request.open("POST", ajaxUrl, true);
                request.send(formData);

                request.onreadystatechange = function() {
                    if (request.readyState != 4) return;
                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            window.location = base_url + '/dashboard';
                        } else {
                            Swal.fire("Atencion", objData.msg, "error");
                            document.querySelector('#txtPassword').value = "";
                        }
                    } else {
                        Swal.fire("Atencion", "Error en el proceso", "error");
                    }
                    return false;
                };
            }
        };
    }

    if (document.querySelector("#formRecetPass")) {
        let formRecetPass = document.querySelector("#formRecetPass");
        formRecetPass.onsubmit = function(e) {
            e.preventDefault();

            let strEmail = document.querySelector('#txtEmailReset').value;
            if (strEmail == "") {
                Swal.fire("Por favor", "Escribe tu correo electrónico.", "error");
                return false;
            } else {
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url + '/Login/resetPass';
                var formData = new FormData(formRecetPass);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function() {
                    if (request.readyState != 4) return;

                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            Swal.fire({
                                title: "",
                                text: objData.msg,
                                confirmButtonText: "Aceptar",
                                closeOnConfirm: false,
                            }).then(function(isConfirm) {
                                if (isConfirm) {
                                    window.location = base_url; // Redirige a la página base_url
                                }
                            });
                        } else {
                            Swal.fire("Atencion", objData.msg, "error");
                        }
                    } else {
                        Swal.fire("Atencion", "Error en el proceso", "error");
                    }
                    return false;
                };
            }
        };
    }

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
                    Swal.fire("Atención", "Las contraseñas no son iguales.", "error");
                    return false;
                }

                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
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