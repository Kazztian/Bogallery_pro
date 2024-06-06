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
            }else{
                var request = window.XMLHttpRequest ? new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP");
                var ajaxUrl = base_url+'/Login/loginUser';
                var formData=new FormData(formLogin);
                request.open("POST",ajaxUrl,true);
                request.send(formData);

                request.onreadystatechange = function(){

                if(request.readyState !=4) return;
                if(request.status ==200){
                    var objData = JSON.parse(request.responseText);
                        if(objData.status)
                            {
                                window.location = base_url+'/dashboard';
                            }else{
                                Swal.fire("Atencion",objData.msg,"error");
                                document.querySelector('#txtPassword').value = "";
                            }
                }else{
                    Swal.fire("Atencion","Error en el proceso","error");
                }

                return false;
             }
            }

           
        }
    }
}, false);
