
 var tableRoles;

document.addEventListener('DOMContentLoaded', function(){
   
    
    script.onload = function() {
        tableRoles = $('#tableRoles').dataTable({
            "aProcessing": true,
            "aServerSide": true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url":""+base_url+"/roles/getRoles",
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
