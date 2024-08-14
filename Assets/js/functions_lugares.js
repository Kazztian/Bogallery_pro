let tableLugares;
let rowTable = "";
let divLoading = document.querySelector('#divLoading');

// Cargar el script de SweetAlert solo si no está ya cargado
if (!document.querySelector('script[src="https://cdn.jsdelivr.net/npm/sweetalert2@9"]')) {
    var script = document.createElement("script");
    script.src = "https://cdn.jsdelivr.net/npm/sweetalert2@9";
    document.head.appendChild(script);
  }
  
  // Manejar la propagación del evento focusin en los diálogos de TinyMCE
  $(document).on("focusin", function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
      e.stopImmediatePropagation();
    }
  });
  
  window.addEventListener('load', function () {
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

if(document.querySelector(".btnAddImage")){
    let btnAddImage =  document.querySelector(".btnAddImage");
    btnAddImage.onclick = function(e){
     let key = Date.now();
     let newElement = document.createElement("div");
     newElement.id= "div"+key;
     newElement.innerHTML = `
         <div class="prevImage"></div>
         <input type="file" name="foto" id="img${key}" class="inputUploadfile">
         <label for="img${key}" class="btnUploadfile"><i class="fas fa-upload "></i></label>
         <button class="btnDeleteImage notblock" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;
     document.querySelector("#containerImages").appendChild(newElement);
     document.querySelector("#div"+key+" .btnUploadfile").click();
     fntInputFile();
    }
 }
 fntInputFile();
}, false);


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

    function fntInputFile(){
        let inputUploadfile = document.querySelectorAll(".inputUploadfile");
        inputUploadfile.forEach(function(inputUploadfile){
            inputUploadfile.addEventListener('change',function()
        {
            let id_lugar = document.querySelector("#id_lugar").value;
            let parentId = this.parentNode.getAttribute("id");
            let idFile = this.getAttribute("id");            
            let uploadFoto = document.querySelector("#"+idFile).value;
            let fileimg = document.querySelector("#"+idFile).files;
            let prevImg = document.querySelector("#"+parentId+" .prevImage");
            let nav = window.URL || window.webkitURL;
            if(uploadFoto !=''){
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png' ){
                    prevImg.innerHTML = "Archivo no válido";
                    uploadFoto.value = "";
                    return false;
                }else{
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg" >`;

                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+'/Lugares/setImage'; 
                    let formData = new FormData();
                    formData.append('id_lugar',id_lugar);
                    formData.append("foto", this.files[0]);
                    request.open("POST",ajaxUrl,true);
                    request.send(formData);
                    request.onreadystatechange = function(){
                        if(request.readyState != 4) return;
                        if(request.status == 200){
                            let objData = JSON.parse(request.responseText);
                            if(objData.status){
                                prevImg.innerHTML = `<img src="${objeto_url}">`;
                                document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
                                document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notblock");
                                document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notblock");
                            }else{
                               // swal("Error", objData.msg , "error");
                                Swal.fire("Error", objData.msg, "error");
                            }
                        }
                    }

                }
            }
        });
        });
    }

    function fntViewInfo(id_lugar){
        let request = (window.XMLHttpRequest) ?
                new XMLHttpRequest() :
                new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Lugares/getLugar/'+id_lugar;
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    let htmlImage = "";
                    let objLugar = objData.data;
                    let estadoLugar = objLugar.status == 1?
                    '<span class="me-1 badge bg-success" style="display: inline-block; font-size: 0.9rem;">Activo</span>' :
                    '<span class="me-1 badge bg-danger" style="display: inline-block; font-size: 0.9rem;">Inactivo</span>';
                    document.querySelector("#celId").innerHTML = objLugar.id_lugar;
                    document.querySelector("#celNombre").innerHTML = objLugar.nombre;
                    document.querySelector("#celDescripcion").innerHTML = objLugar.descripcion;
                    document.querySelector("#celLocalidad").innerHTML = objLugar.localidad;
                    document.querySelector("#celTipo").innerHTML = objLugar.tipo_lugar;
                    document.querySelector("#celDirección").innerHTML = objLugar.direccion;
                    document.querySelector("#celStatus").innerHTML = estadoLugar;

                    if(objLugar.images.length > 0){
                        let objLugares = objLugar.images;
                        for (let l = 0; l < objLugares.length; l++){
                            htmlImage +=`<img src="${objLugares[l].url_image}"></img>`
                        }
                    }
                    document.querySelector("#celFotos").innerHTML = htmlImage;
                    $('#modalViewLugar').modal('show');
                    

                    
                }else{
                    Swal.fire("Error", objData.msg, "error");
                }
        }
    }

    }
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