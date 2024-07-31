// Cargar el script de JsBarcode
document.write(
  `<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`
);

let tablePlanes;
let rowTable = "";

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
          "columns": [0, 1, 2, 3, 4, 5]
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

  // Manejar el formulario de planes
  if (document.querySelector("#formPlanes")) {
    let formPlanes = document.querySelector("#formPlanes");
    formPlanes.onsubmit = function (e) {
      e.preventDefault();
      let strNombre = document.querySelector('#txtNombre').value;
      let intCodigo = document.querySelector('#txtCodigo').value;
      let strPrecio = document.querySelector('#txtPrecio').value;
      let intStock = document.querySelector('#txtStock').value;

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
            tablePlanes.api().ajax.reload();
          }else{
            Swal.fire("Error", objData.msg, "error");
          }

         
        }
        divLoading.style.display = "none";
      }
    }
  }

  // Inicializar funciones de categorías y lugares
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

// Inicializar TinyMCE
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

// Función para cargar categorías
function fntCategorias() {
  if (document.querySelector("#listCategoria")) {
    let ajaxUrl = base_url + '/Categorias/getSelectCategorias';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        document.querySelector("#listCategoria").innerHTML = request.responseText;
        $("#listCategoria").selectpicker("render");
      }
    };
  }
}

// Función para cargar lugares
function fntLugares() {
  if (document.querySelector("#listLugar")) {
    let ajaxUrl = base_url + '/Lugares/getSelectLugares';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        document.querySelector("#listLugar").innerHTML = request.responseText;
        $("#listLugar").selectpicker("render");
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
  $("#modalFormPlanes").modal("show");
}
