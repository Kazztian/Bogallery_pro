document.addEventListener('DOMContentLoaded', function() {
    // Creamos un elemento <script> para cargar SweetAlert desde el CDN
    let script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@9';

    // Agregamos un evento para manejar el estado de carga del script
    /*script.onload = function() {
        // Una vez que SweetAlert está cargado, podemos usarlo
        inicializarTabla();
    };*/

    // Agregamos el script al final del <body> para asegurarnos de que se cargue antes de usarlo
    document.body.appendChild(script);
    if(document.querySelector("#formCliente")){
        let formCliente = document.querySelector("#formCliente");
        formCliente.onsubmit = function(e) {
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
            let strPassword = document.querySelector('#txtPassword').value;
            let strNit = document.querySelector('#txtNit').value;
            let strNombreFiscal = document.querySelector('#txtNombreFiscal').value;
            let strDirFiscal = document.querySelector('#txtDirFiscal').value;
           
    //Para generar el status inactivo lo tendriamos que llamar como arriba en listRolid
    
    //Validacion patra los datos vacios
            if (strNombre === '' || strApellido === '' || strEmail === '' || intTelefono === '' || intEdad === '' || strDireccion === '' || strPrimerI === '' || strSegundoI === '' || strNit === '' || strNombreFiscal === '' || strDirFiscal === '') {
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
            let ajaxUrl = base_url + '/Clientes/setCliente'; 
            let formData = new FormData(formCliente);
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
                        $('#modalformCliente').modal("hide");
                        // Utilizamos SweetAlert en lugar de swal()
                        Swal.fire("Usuarios", objData.msg, "success");
                        /*tableUsuarios.ajax.reload(function() {
                            // Callback function after reloading the table, if needed
                        });*/
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

}, false);
//Codigo para abrir el modal de los usuarios
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
