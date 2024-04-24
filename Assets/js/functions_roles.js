document.addEventListener('DOMContentLoaded', function(){
    // Creamos un elemento <script> para cargar SweetAlert desde el CDN
    var script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@9';
    
    // Agregamos el script al final del <body> para asegurarnos de que se cargue antes de usarlo
    document.body.appendChild(script);
    
    script.onload = function() {
        // Una vez que SweetAlert está cargado, podemos usarlo sin problemas
        tableRoles = $('#tableRoles').dataTable({
            "aProcessing": true,
            "aServerSide": true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url":""+base_url+"/Roles/getRoles",
                "dataSrc": ""
            },
            "columns": [
                {"data": "id_rol"},
                {"data": "nombrerol"},
                {"data": "descripcion"},
                {"data": "status"},
                {"data": "options"}
            ],
            "responsive": true,
            "bDestroy": true,  
            "iDisplayLength": 10,   
            "order": [[0, "desc"]]
        });

        // Creacion de un nuevo rol
        var formRol = document.querySelector("#formRol");
        formRol.onsubmit = function(e){
            e.preventDefault(); //prevenir que se recargue la pagina

            var strNombre = document.querySelector('#txtNombre').value;
            var strDesc = document.querySelector('#txtDesc').value;
            var strStatus = document.querySelector('#listStatus').value;
            if(strNombre =='' || strDesc =='' || strStatus ==''){
                // Utilizamos SweetAlert en lugar de swal()
                Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
        }
    };
});

$('#tableRoles').DataTable();

function openModal(){
    $('#modalFormRol').modal('show');
}
