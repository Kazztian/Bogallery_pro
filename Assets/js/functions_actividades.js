 let tableActividades;
 
 
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
      tableLugares = $("#tableActividades").DataTable({
          aProcessing: true,
          aServerSide: true,
          language: {
              url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          ajax: {
              url: base_url + "/Actividades/getActividades",
              dataSrc: ''
          },
          columns: [
            { data: "id_actividad" },
            { data: "nombre" },
            { data: "jornada" },
            { data: "valor" },
            //{ data: "lugares" },
            { data: "status" },
            { data: "options" },
          ],
          columnDefs: [
            //  { 'className': "textright", "targets": [ 3 ] },
             { 'className': "textright", "targets": [ 3 ] },
              { 'className': "textcenter", "targets": [ 4] }
          ],   
          dom: 'lBfrtip',  // Indica a DataTables que muestre los botones en la tabla
          buttons: [
              {
                  "extend": "copyHtml5",
                  "text": "<i class='far fa-copy'></i> Copiar",
                  "titleAttr":"Copiar",
                  "className": "btn btn-secondary",
                  "exportOptions": { 
                      "columns": [ 0, 1, 2, 3, 4] 
                  }
              },
              {
                  "extend": "excelHtml5",
                  "text": "<i class='fas fa-file-excel'></i> Excel",
                  "titleAttr":"Esportar a Excel",
                  "className": "btn btn-success",
                  "exportOptions": { 
                      "columns": [ 0, 1, 2, 3, 4] 
                  }
              },
              {
                  "extend": "pdfHtml5",
                  "text": "<i class='fas fa-file-pdf'></i> PDF",
                  "titleAttr":"Esportar a PDF",
                  "className": "btn btn-danger",
                  "exportOptions": { 
                      "columns": [ 0, 1, 2, 3, 4] 
                  }
              },
              {
                  "extend": "csvHtml5",
                  "text": "<i class='fas fa-file-csv'></i> CSV",
                  "titleAttr":"Esportar a CSV",
                  "className": "btn btn-info",
                  "exportOptions": { 
                      "columns": [ 0, 1, 2, 3, 4] 
                  }
              }
          ],
          responsive: true,
          bDestroy: true,
          iDisplayLength: 5,
          order: [[0, "desc"]],
      });

      if(this.document.querySelector("#formActividades")){
        let formActividades = this.document.querySelector("#formActividades");
        formActividades.onsubmit = function(e){

          e.preventDefault();
          let strNombre = document.querySelector('#txtNombre').value;
          let strJornada = document.querySelector("#txtJornada").value;
          let intValor = document.querySelector("#txtValor").value;

          if(strNombre == '' || strJornada == '' || intValor == '')
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
    let ajaxUrl = base_url+'/Actividades/setActividades';
    let formData = new FormData(formActividades);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
      if (request.readyState == 4 && request.status == 200) {
        let objData = JSON.parse(request.responseText);
        if(objData.status){
          Swal.fire("Actividades", objData.msg, "success");
          document.querySelector("#id_actividad").value = objData.id_actividad;
                   
          tableLugares.ajax.reload();
        }else{
          Swal.fire("Error", objData.msg, "error");
        }
      }
      divLoading.style.display = "none";
      return false;
        }
        }
      }

    }, false);
  
  
 // Manejar la propagación del evento focusin en los diálogos de TinyMCE
  $(document).on("focusin", function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
      e.stopImmediatePropagation();
    }
  });
   
  //
  window.addEventListener('load', function(){
    fntLugares();
  }, false);

 tinymce.init({
    selector: '#txtDescripcion',
    width: "100%",
    height: 400,    
    statubar: true,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor",
        "autosave spellchecker code textpattern help imagetools quickbars",
        "geolocation gallery weather accessibility"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media gallery | print preview media fullpage | forecolor backcolor emoticons | code | spellchecker | help | geolocation weather"
}); 

 function fntLugares(){
    if(document.querySelector('#listLugar')){
        let ajaxUrl = base_url+'/Lugares/getSelectLugares';
        let request = (window.XMLHttpRequest) ? 
        new XMLHttpRequest() : 
        new ActiveXObject('Microsoft.XMLHTTP');
request.open("GET",ajaxUrl,true);
request.send();
request.onreadystatechange = function(){
    if(request.readyState == 4 && request.status == 200){
        document.querySelector('#listLugar').innerHTML = request.responseText;
        $('#listLugar').selectpicker('render');
      }
    }
 }
}


   function openModal() {
        rowTable = "";
        document.querySelector('#id_actividad').value = "";
        document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
        document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
        document.querySelector('#btnText').innerHTML = "Guardar";
        document.querySelector('#titleModal').innerHTML = "Nueva actividad";
        document.querySelector("#formActividades").reset();

       // document.querySelector("#containerGallery").classList.add("notblock");
       // document.querySelector("#containerImages").innerHTML = "";
        $('#modalFormActividades').modal('show');
    };