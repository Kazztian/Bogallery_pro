// Cargar el script de JsBarcode
document.write(
  `<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`
);
let tablePlanes;
let rowTable = ""; //Recargar la tabla

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


  // Configurar la tabla de planes
  tablePlanes = $('#tablePlanes').dataTable({
    "aProcessing": true,
    "aServerSide": true,
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax": {
      "url": base_url + "/Planes/getPlanes",
      "dataSrc": ""
    },
    "columns": [
      { "data": "id_plan" },
      { "data": "codigo" },
      { "data": "nombre" },
      { "data": "stock" },
      { "data": "precio" },
      { "data": "status" },
      { "data": "options" }
    ],
    "columnDefs": [
      { 'className': "textcenter", "targets": [3] },
      { 'className': "textright", "targets": [4] },
      { 'className': "textcenter", "targets": [5] }
    ],
    'dom': 'lBfrtip',
    'buttons': [
      {
        "extend": "copyHtml5",
        "text": "<i class='far fa-copy'></i> Copiar",
        "titleAttr": "Copiar",
        "className": "btn btn-secondary",
        "exportOptions": {
          "columns": [0, 1, 2, 3, 4, 5] //Los campos a exportar
        }
      },
      {
        "extend": "excelHtml5",
        "text": "<i class='fas fa-file-excel'></i> Excel",
        "titleAttr": "Exportar a Excel",
        "className": "btn btn-success",
        "exportOptions": {
          "columns": [0, 1, 2, 3, 4, 5]
        }
      },
      {
        "extend": "pdfHtml5",
        "text": "<i class='fas fa-file-pdf'></i> PDF",
        "titleAttr": "Exportar a PDF",
        "className": "btn btn-danger",
        "exportOptions": {
          "columns": [0, 1, 2, 3, 4, 5]
        }
      },
      {
        "extend": "csvHtml5",
        "text": "<i class='fas fa-file-csv'></i> CSV",
        "titleAttr": "Exportar a CSV",
        "className": "btn btn-info",
        "exportOptions": {
          "columns": [0, 1, 2, 3, 4, 5]
        }
      }
    ],
    "responsive": true,
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "desc"]]
  });
  window.addEventListener('load', function () {
  // Manejar el formulario de planes
  if (document.querySelector("#formPlanes")) {
    let formPlanes = document.querySelector("#formPlanes");
    formPlanes.onsubmit = function (e) {
      e.preventDefault();
      let strNombre = document.querySelector('#txtNombre').value;
      let intCodigo = document.querySelector('#txtCodigo').value;
      let strPrecio = document.querySelector('#txtPrecio').value;
      let intStock = document.querySelector('#txtStock').value;
      let intStatus = document.querySelector('#listStatus').value;

      if (strNombre == '' || intCodigo == '' || strPrecio == '' || intStock == '') {
        Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
        return false;
      }
      if (intCodigo.length < 5) {
        Swal.fire("Atención", "El código debe ser mayor que 5 dígitos.", "error");
        return false;
      }

      divLoading.style.display = "flex";
      tinyMCE.triggerSave();
      let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
      let ajaxUrl = base_url + '/Planes/setPlanes'; 
      let formData = new FormData(formPlanes);
      request.open("POST", ajaxUrl, true);
      request.send(formData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          let objData = JSON.parse(request.responseText);
          if(objData.status){

            Swal.fire("", objData.msg, "success");
            document.querySelector("#idPlanes").value = objData.idplan;
            document.querySelector("#containerGallery").classList.remove("notblock");

            if(rowTable == ""){
              tablePlanes.api().ajax.reload();
            }else{
              htmlStatus = intStatus == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent = intCodigo;
                            rowTable.cells[2].textContent = strNombre;
                            rowTable.cells[3].textContent = intStock;
                            rowTable.cells[4].textContent = smony+strPrecio;
                            rowTable.cells[5].innerHTML =  htmlStatus;
                            rowTable = ""; 

            }
          
          }else{
            Swal.fire("Error", objData.msg, "error");
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

  // Inicializar funciones de categorías y lugares
  fntInputFile();
  fntCategorias();
  fntLugares();
}, false);

// Manejar el evento onkeyup para el código de barras
if (document.querySelector("#txtCodigo")) {
  let inputCodigo = document.querySelector("#txtCodigo");
  inputCodigo.onkeyup = function () {
    if (inputCodigo.value.length >= 5) {
      document.querySelector("#divBarCode").classList.remove("notblock");
      fntBarcode();
    } else {
      document.querySelector("#divBarCode").classList.add("notblock");
    }
  };
}
// Inicializar TinyMCE //Editor de texto
tinymce.init({
  selector: "#txtDescripcion",
  width: "100%",
  height: 400,
  statusbar: true,
  plugins: [
    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "save table contextmenu directionality emoticons template paste textcolor",
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});

//Funcion para cargar las fotos 
function fntInputFile(){
  let inputUploadfile = document.querySelectorAll(".inputUploadfile");
  inputUploadfile.forEach(function(inputUploadfile) {
      inputUploadfile.addEventListener('change', function(){
          let idPlanes = document.querySelector("#idPlanes").value;
          let parentId = this.parentNode.getAttribute("id");
          let idFile = this.getAttribute("id");            
          let uploadFoto = document.querySelector("#"+idFile).value;
          let fileimg = document.querySelector("#"+idFile).files;
          let prevImg = document.querySelector("#"+parentId+" .prevImage");
          let nav = window.URL || window.webkitURL;
          if(uploadFoto !=''){
              let type = fileimg[0].type;
              let name = fileimg[0].name;
              if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                  prevImg.innerHTML = "Archivo no válido";
                  uploadFoto.value = "";
                  return false;
              }else{
                  let objeto_url = nav.createObjectURL(this.files[0]);
                  prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg" >`;

                  let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                  let ajaxUrl = base_url+'/Planes/setImage'; 
                  let formData = new FormData();
                  formData.append('id_plan',idPlanes);
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
                            Swal.fire("Error", objData.msg , "error");
                          }
                      }
                  }

              } 
          }

      });
  });
}
//Funcion para Eliminar imagenes
function fntDelItem(element){
  let nameImg = document.querySelector(element+' .btnDeleteImage').getAttribute("imgname");
  let idPlan = document.querySelector("#idPlanes").value;
  let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url+'/Planes/delFile'; 
//Formulario desde jSript
  let formData = new FormData();
  formData.append('idplan',idPlan);
  formData.append("file",nameImg);
  request.open("POST",ajaxUrl,true);
  request.send(formData);
  request.onreadystatechange = function(){
      if(request.readyState != 4) return;
      if(request.status == 200){
          let objData = JSON.parse(request.responseText);
          if(objData.status)
          {
              let itemRemove = document.querySelector(element);
              itemRemove.parentNode.removeChild(itemRemove);

              Swal.fire({
                title: "Imagen eliminada",
                text: "La imagen ha sido eliminada correctamente",
                icon: "success",
                confirmButtonText: "OK"
            });
          }else{
              Swal.fire("", objData.msg , "error");
          }
      }
  }
}


function fntViewInfo(idPlan){
 
  let request = (window.XMLHttpRequest) ? 
                  new XMLHttpRequest() : 
                  new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url+'/Planes/getPlan/'+idPlan;
  request.open("GET",ajaxUrl,true);
  request.send();
  request.onreadystatechange = function(){
      if(request.readyState == 4 && request.status == 200){
          let objData = JSON.parse(request.responseText);
          if(objData.status)
          {
              let htmlImage = "";
              let objPlan = objData.data;
              let estadoPlan = objPlan.status == 1 ? 
              '<span class="badge badge-success">Activo</span>' : 
              '<span class="badge badge-danger">Inactivo</span>';

              document.querySelector("#celCodigo").innerHTML = objPlan.codigo;
              document.querySelector("#celNombre").innerHTML = objPlan.nombre;
              document.querySelector("#celPrecio").innerHTML = objPlan.precio;
              document.querySelector("#celStock").innerHTML = objPlan.stock;
              document.querySelector("#celCategoria").innerHTML = objPlan.categoria;
              document.querySelector("#celLugar").innerHTML = objPlan.lugar;
              document.querySelector("#celStatus").innerHTML = estadoPlan;
              document.querySelector("#celDescripcion").innerHTML = objPlan.descripcion;

              if(objPlan.images.length > 0){
                  let objPlanes = objPlan.images;
                  for (let p = 0; p < objPlanes.length; p++) {
                      htmlImage +=`<img src="${objPlanes[p].url_image}"></img>`;
                  } 
              }
              document.querySelector("#celFotos").innerHTML = htmlImage;
               $('#modalViewPlan').modal('show');

          }else{
            Swal.fire("Error", objData.msg , "error");
          }
      }
  } 
}
//Funcion para actualizar o editar un plan
function fntEditInfo(element,idPlan){
  rowTable = element.parentNode.parentNode.parentNode;
  document.querySelector('#titleModal').innerHTML ="Actualizar Producto";
  document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
  document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
  document.querySelector('#btnText').innerHTML ="Actualizar";
  let request = (window.XMLHttpRequest) ? 
                  new XMLHttpRequest() : 
                  new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url+'/Planes/getPlan/'+idPlan;
  request.open("GET",ajaxUrl,true);
  request.send();
  request.onreadystatechange = function(){
      if(request.readyState == 4 && request.status == 200){
          let objData = JSON.parse(request.responseText);
          if(objData.status)
          {
              let htmlImage = "";
              let objPlan = objData.data;
              document.querySelector("#idPlanes").value = objPlan.id_plan;
              document.querySelector("#txtNombre").value = objPlan.nombre;
              document.querySelector("#txtDescripcion").value = objPlan.descripcion;
              document.querySelector("#txtCodigo").value = objPlan.codigo;
              document.querySelector("#txtPrecio").value = objPlan.precio;
              document.querySelector("#txtStock").value = objPlan.stock;
              document.querySelector("#listCategoria").value = objPlan.id_categoria;
              document.querySelector("#listLugar").value = objPlan.id_lugar;
              document.querySelector("#listStatus").value = objPlan.status;
               tinymce.activeEditor.setContent(objPlan.descripcion); 
               $('#listCategoria').selectpicker('render');
               $('#listLugar').selectpicker('render');
               $('#listStatus').selectpicker('render');
               fntBarcode(); //Llamar y general el codigo de barra

              if(objPlan.images.length > 0){
                  let objPlanes = objPlan.images;
                  for (let p = 0; p < objPlanes.length; p++) {
                      let key = Date.now()+p;
                      htmlImage +=`<div id="div${key}">
                          <div class="prevImage">
                          <img src="${objPlanes[p].url_image}"></img>
                          </div>
                          <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objPlanes[p].img}">
                          <i class="fas fa-trash-alt"></i></button></div>`;
                  }
              }
                   document.querySelector("#containerImages").innerHTML = htmlImage; 
                   document.querySelector("#divBarCode").classList.remove("notblock");
                   document.querySelector("#containerGallery").classList.remove("notblock");           
              $('#modalFormPlanes').modal('show');
          }else{
            Swal.fire("Error", objData.msg , "error");
          }
      }
  }
}

function fntDelInfo(idPlan) {
  Swal.fire({
      title: "Eliminar Plan",
      text: "¿Realmente quiere eliminar el plan?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, eliminar!",
      cancelButtonText: "No, cancelar!",
      reverseButtons: true
  }).then((result) => {
      if (result.isConfirmed) {
          let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
          let ajaxUrl = base_url + '/Planes/delPlan';
          let strData = "idPlan=" + idPlan;
          request.open("POST", ajaxUrl, true);
          request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          request.send(strData);
          request.onreadystatechange = function() {
              if (request.readyState == 4 && request.status == 200) {
                  let objData = JSON.parse(request.responseText);
                  if (objData.status) {
                      Swal.fire("Eliminar!", objData.msg, "success");
                      tablePlanes.api().ajax.reload();
                  } else {
                      Swal.fire("Atención!", objData.msg, "error");
                  }
              }
          }
      }
  });
}

// Función para cargar categorías
function fntCategorias() {
  if (document.querySelector('#listCategoria')) {
    let ajaxUrl = base_url + '/Categorias/getSelectCategorias';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
      if (request.readyState == 4 && request.status == 200) {
        document.querySelector('#listCategoria').innerHTML = request.responseText;
        $('#listCategoria').selectpicker("render");
      }
    };
  }
}

// Función para cargar lugares  
function fntLugares() {
  if (document.querySelector('#listLugar')) {
    let ajaxUrl = base_url + '/Lugares/getSelectLugares';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
      if (request.readyState == 4 && request.status == 200) {
        document.querySelector('#listLugar').innerHTML = request.responseText;
        $('#listLugar').selectpicker("render");
      }
    };
  }
}

// Función para generar el código de barras
function fntBarcode() {
  let codigo = document.querySelector("#txtCodigo").value;
  JsBarcode("#barcode", codigo);
}

// Función para imprimir el código de barras
function fntPrintBarcode(area) {
  let elemntArea = document.querySelector(area);
  let vprint = window.open(" ", "popimpr", "height=400,width=600");
  vprint.document.write(elemntArea.innerHTML);
  vprint.document.close();
  vprint.print();
  vprint.close();
}

// Función para abrir el modal de planes
function openModal() {
  rowTable = "";
  document.querySelector("#idPlanes").value = "";
  document.querySelector(".modal-header").classList.replace("headerUpdate", "headerRegister");
  document.querySelector("#btnActionForm").classList.replace("btn-info", "btn-primary");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#titleModal").innerHTML = "Nuevo Plan Turístico";
  document.querySelector("#formPlanes").reset();

  document.querySelector("#divBarCode").classList.add("notblock");
  document.querySelector("#containerGallery").classList.add("notblock");
  document.querySelector("#containerImages").innerHTML = "";
  $('#listCategoria').selectpicker('render');
  $('#listLugar').selectpicker('render');
  $('#modalFormPlanes').modal('show');


}
