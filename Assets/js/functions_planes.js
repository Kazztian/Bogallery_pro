document.write(
  `<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`
);
let tablePlanes;

$(document).on("focusin", function (e) {
  if ($(e.target).closest(".tox-dialog").length) {
    e.stopImmediatePropagation();
  }
});
//Llamado de las funciones 
window.addEventListener('load', function(){
    tablePlanes = $('#tablePlanes').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": base_url + "/Planes/getPlanes",
            "dataSrc": ""
        },
        "columns": [
            {"data": "id_plan"},
            {"data": "codigo"},
            {"data": "nombre"},
            {"data": "stock"},
            {"data": "precio"},
            {"data": "status"},
            {"data": "options"}
        ],

        "columnDefs":[
          {'clasName': "textcenter","targets":[3]},
          {'clasName': "textright","targets":[4]},
          {'clasName': "textcenter","targets":[5]}
          

        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary"
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success"
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger"
            }, {
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr": "Exportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "responsive": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });
    fntCategorias();
    fntLugares();
},false);






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

//Campo de descripcion y funciones
tinymce.init({
  selector: "#txtDescripcion",
  width: "100%",
  height: 400,
  statubar: true,
  plugins: [
    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "save table contextmenu directionality emoticons template paste textcolor",
  ],
  toolbar:
    "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});
//Funcion para la lista de las categorias
function fntCategorias() {
  if (document.querySelector("#listCategoria")) {
    let ajaxUrl = base_url + "/Categorias/getSelectCategorias";
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        document.querySelector("#listCategoria").innerHTML =
          request.responseText;
        $("#listCategoria").selectpicker("render");
      }
    };
  }
}
//Funcion para la lista de lugares cuando este
function fntLugares() {
  if (document.querySelector("#listLugar")) {
    let ajaxUrl = base_url + "/Lugares/getSelectLugares";
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        document.querySelector("#listLugar").innerHTML =
          request.responseText;
        $("#listLugar").selectpicker("render");
      }
    };
  }
}

//Funcion para crear el codigo de barras
function fntBarcode() {
  let codigo = document.querySelector("#txtCodigo").value;
  JsBarcode("#barcode", codigo);
}
//FUncion para imprimir el codigo
function fntPrintBarcode(area) {
  let elemntArea = document.querySelector(area);
  let vprint = window.open(" ", "popimpr", "height=400,width=600");
  vprint.document.write(elemntArea.innerHTML);
  vprint.document.close();
  vprint.print();
  vprint.close();
}

function openModal() {
  rowTable = "";
  document.querySelector("#idPlanes").value = "";
  document
    .querySelector(".modal-header")
    .classList.replace("headerUpdate", "headerRegister");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-info", "btn-primary");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#titleModal").innerHTML = "Nuevo Plan Turistico";
  document.querySelector("#formPlanes").reset();
  $("#modalFormPlanes").modal("show");
 
}
