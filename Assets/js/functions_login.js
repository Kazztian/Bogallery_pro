// Script de SweetAlert2
var script = document.createElement("script");
script.src = "https://cdn.jsdelivr.net/npm/sweetalert2@9";
document.head.appendChild(script);

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector("#formLogin")) {
        let formLogin = document.querySelector("#formLogin");
        formLogin.onsubmit = function(e) {
            e.preventDefault();

            let email = document.querySelector('#txtEmail').value;
            let password = document.querySelector('#txtPassword').value;

            if (email == "" || password == "") {
                Swal.fire("Por favor", "Ingrese su usuario y contraseña.", "error");
                return false;
            }

            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
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
                        Swal.fire("Atención", objData.msg, "error");
                    }
                } else {
                    Swal.fire("Atención", "Error en el proceso.", "error");
                }
            }
        }
    }
    
    if (document.querySelector("#formRecetPass")) {
        let formRecetPass = document.querySelector("#formRecetPass");
        formRecetPass.onsubmit = function(e) {
            e.preventDefault();

            let emailReset = document.querySelector('#txtEmailReset').value;

            if (emailReset == "") {
                Swal.fire("Por favor", "Ingrese su email.", "error");
                return false;
            }

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
                        Swal.fire("Éxito", objData.msg, "success");
                    } else {
                        Swal.fire("Atención", objData.msg, "error");
                    }
                } else {
                    Swal.fire("Atención", "Error en el proceso.", "error");
                }
            }
        }
    }
}, false);
