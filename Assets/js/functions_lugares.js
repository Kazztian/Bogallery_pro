let tableLugares;
let rowTable = "";
let divLoading = document.querySelector('#divLoading');

document.addEventListener('DOMContentLoaded', function() {
    // Creamos un elemento <script> para cargar SweetAlert desde el CDN
    let script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@9';
    script.onload = function() {
        // Una vez que SweetAlert está cargado, podemos usarlo
        inicializarTabla();
    };
    document.body.appendChild(script);

    function inicializarTabla() {
        tableLugares = $("#tableLugares").DataTable({
            aProcessing: true,
            aServerSide: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
            },
            ajax: {
                url: base_url + "/Lugares/getLugares",
                dataSrc: ''
            },
            columns: [
                { data: "id_lugar" },
                { data: "nombre" },
                { data: "localidad" },
                { data: "direccion" },
                { data: "tipo_lugar" },
                { data: "status" },
                { data: "options" },
            ],
            columnDefs: [
              //  { 'className': "textcenter", "targets": [ 3 ] },
               // { 'className': "textcenter", "targets": [ 4 ] },
                { 'className': "textcenter", "targets": [ 5 ] }
            ],   
            dom: 'lBfrtip',  // Indica a DataTables que muestre los botones en la tabla
            buttons: [
                {
                    "extend": "copyHtml5",
                    "text": "<i class='far fa-copy'></i> Copiar",
                    "titleAttr":"Copiar",
                    "className": "btn btn-secondary",
                    "exportOptions": { 
                        "columns": [ 0, 1, 2, 3, 4, 5] 
                    }
                },
                {
                    "extend": "excelHtml5",
                    "text": "<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr":"Esportar a Excel",
                    "className": "btn btn-success",
                    "exportOptions": { 
                        "columns": [ 0, 1, 2, 3, 4, 5] 
                    }
                },
                {
                    "extend": "pdfHtml5",
                    "text": "<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr":"Esportar a PDF",
                    "className": "btn btn-danger",
                    "exportOptions": { 
                        "columns": [ 0, 1, 2, 3, 4, 5] 
                    }
                },
                {
                    "extend": "csvHtml5",
                    "text": "<i class='fas fa-file-csv'></i> CSV",
                    "titleAttr":"Esportar a CSV",
                    "className": "btn btn-info",
                    "exportOptions": { 
                        "columns": [ 0, 1, 2, 3, 4, 5] 
                    }
                }
            ],
            responsive: true,
            bDestroy: true,
            iDisplayLength: 10,
            order: [[0, "desc"]],
        });
    }

    tinymce.init({
        selector: '#txtDescripcion',
        width: "100%",
        height: 400,    
        statubar: true,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
    });

    
if(document.querySelector("#formLugares")){
    let formLugares = document.querySelector("#formLugares");
    formLugares.onsubmit = function(e){
        e.preventDefault();
        let strNombre = document.querySelector('#txtNombre').value;
        let strLocalidad = document.querySelector('#txtLocalidad').value;
        let strDireccion = document.querySelector('#txtDireccion').value;
        let strTipoLugar = document.querySelector('#txtTipoLugar').value;
       // let strDescripcion = document.querySelector('#txtDescripcion').value;
        if(strNombre == '' || strLocalidad == '' || strDireccion == '' || strTipoLugar == '' )
        {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        divLoading.style.display = "flex";
        //divLoading.setHTMLUnsafe.display = "flex";
        tinyMCE.triggerSave();

        let request =(window.XMLHttpRequest)?
                       new XMLHttpRequest() :
                       new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Lugares/setLugar';
        let formData = new FormData(formLugares);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
               let objData = JSON.parse(request.responseText);
               if(objData.status)
               {
                Swal.fire("", objData.msg , "success");
                document.querySelector("#id_lugar"). value = objData.id_lugar;
                tableLugares.ajax.reload(null, false); 
               }else{
                Swal.fire("Error", objData.msg , "error");
               }
            }
            divLoading.style.display = "none";
            return false;
        }
        
    }
}
}, false);
    function openModal() {
        rowTable = "";
        document.querySelector('#id_lugar').value = "";
        document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
        document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
        document.querySelector('#btnText').innerHTML = "Guardar";
        document.querySelector('#titleModal').innerHTML = "Nuevo lugar";
        document.querySelector("#formLugares").reset();
        $('#modalFormLugares').modal('show');
    };
