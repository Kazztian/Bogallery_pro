$(".js-select2").each(function(){
    $(this).select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).next('.dropDownSelect2')
    });
})

$('.parallax100').parallax100();

$('.gallery-lb').each(function() { // the containers for all your galleries
    $(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
            enabled:true
        },
        mainClass: 'mfp-fade'
    });
});

$('.js-addwish-b2').on('click', function(e){
    e.preventDefault();
});

$('.js-addwish-b2').each(function(){
    var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
    $(this).on('click', function(){
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass('js-addedwish-b2');
        $(this).off('click');
    });
});

$('.js-addwish-detail').each(function(){
    var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

    $(this).on('click', function(){
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass('js-addedwish-detail');
        $(this).off('click');
    });
});

/*---------------------------------------------*/

$('.js-addcart-detail').each(function(){
    var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
    $(this).on('click', function(){
//obtener los id del  campo y cantidad para incriptar 
        let id= this.getAttribute('id');
        let cant = document.querySelector('#cant-product').value;

        if(isNaN(cant) || cant < 1){
            swal("", "La cantidad debe ser mayor o igual que 1", "error");
            return;
        }
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Tiendabo/addCarrito'; 
	    let formData = new FormData();
	    formData.append('id',id);
	    formData.append('cant',cant);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState != 4) return;
            if(request.status == 200){
              let objData = JSON.parse(request.responseText);
              if(objData.status){
              document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito; 
             // document.querySelectorAll(".cantCarrito")[0].setAttribute("data-notify",objData.cantCarrito);
              //document.querySelectorAll(".cantCarrito")[1].setAttribute("data-notify",objData.cantCarrito);
              //Se utiliza para actualizar varios elementos con la misma clase
              const cants = document.querySelectorAll(".cantCarrito");
              cants.forEach(element => {
                element.setAttribute("data-notify", objData.cantCarrito)
              });
              Swal.fire(nameProduct, "Se ha agregado al carrito!", "success");
              }else{
                swal("", objData.msg , "error");
              }
            }
            return false;
        }
       
    });
});

$('.js-pscroll').each(function(){
    $(this).css('position','relative');
    $(this).css('overflow','hidden');
    var ps = new PerfectScrollbar(this, {
        wheelSpeed: 1,
        scrollingThreshold: 1000,
        wheelPropagation: false,
    });

    $(window).on('resize', function(){
        ps.update();
    })
});

//Funciones para actualizar el plan osea la cantidad
    /*==================================================================
    [ +/- num product ]*/
    $('.btn-num-product-down').on('click', function(){
        let numProduct = Number($(this).next().val());
        let idpl = this.getAttribute('idpl');
        if(numProduct > 1) $(this).next().val(numProduct - 1);
        let cant = $(this).next().val();
        if(idpl != null){
            fntUpdateCant(idpl,cant);
        }
      
    });

    $('.btn-num-product-up').on('click', function(){
        let numProduct = Number($(this).prev().val());
        let idpl = this.getAttribute('idpl');
        $(this).prev().val(numProduct + 1);
        let cant = $(this).prev().val();
        if(idpl != null){
            fntUpdateCant(idpl,cant);
        }
    });

    
//Actualizar producto
if(document.querySelector(".num-product")){
	let inputCant = document.querySelectorAll(".num-product");
	inputCant.forEach(function(inputCant) {
		inputCant.addEventListener('keyup', function(){
			let idpl = this.getAttribute('idpl');
			let cant = this.value;
		    if(idpl != null){
                fntUpdateCant(idpl,cant);
            }
		});
	});
}
  
if(document.querySelector("#formRegister")){
    let formRegister = document.querySelector("#formRegister");
    formRegister.onsubmit = function(e) {
        e.preventDefault();
        // Captura de datos del formulario de usuarios 
        let strNombre = document.querySelector('#txtNombre').value;
        let strApellido = document.querySelector('#txtApellido').value;
        let strEmail = document.querySelector('#txtEmailCliente').value;
        let intTelefono = document.querySelector('#txtTelefono').value;
        let intEdad = document.querySelector('#txtEdad').value;
        let strDireccion = document.querySelector('#txtDireccion').value;
        let strPrimerI = document.querySelector('#txtPrimerI').value;
        let strSegundoI = document.querySelector('#txtSegundoI').value;

        
        // Validación para los datos vacíos
        if (strNombre === '' || strApellido === '' || strEmail === '' || intTelefono === '' || intEdad === ''|| strDireccion === ''|| strPrimerI  === ''|| strSegundoI  === '' ) {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }

        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) { 
            if(elementsValid[i].classList.contains('is-invalid')) { 
                Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                return false;
            } 
        } 

        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Tiendabo/registro'; 
        let formData = new FormData(formRegister);
        request.open("POST", ajaxUrl, true);
        request.send(formData);

        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                   window.location.reload(false);
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            }
            divLoading.style.display = "none";
            return false;
        }
    };
}

if(document.querySelector(".methodpago")){

	let optmetodo = document.querySelectorAll(".methodpago");
    optmetodo.forEach(function(optmetodo) {
        optmetodo.addEventListener('click', function(){
        	if(this.value == "Paypal"){
        		document.querySelector("#msgpaypal").classList.remove("notblock");
        		document.querySelector("#divtipopago").classList.add("notblock");
        	}else{
        		document.querySelector("#msgpaypal").classList.add("notblock");
        		document.querySelector("#divtipopago").classList.remove("notblock");
        	}
        });
    });
}
function fntdelItem(element){
    console.log(element);
	//Option 1 = Modal
	//Option 2 = Vista Carrito
	let option = element.getAttribute("op");
	let idpl = element.getAttribute("idpl");
	if(option == 1 || option == 2 ){

		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Tiendabo/delCarrito'; 
	    let formData = new FormData();
	    formData.append('id',idpl);
	    formData.append('option',option);
	    request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	        if(request.readyState != 4) return;
	        if(request.status == 200){
	        	let objData = JSON.parse(request.responseText);
                if(objData.status){
                    if(option == 1){
                        document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito; 
                        const cants = document.querySelectorAll(".cantCarrito");
                        cants.forEach(element => {
                            element.setAttribute("data-notify", objData.cantCarrito)
                        });
                    }else{
                        element.parentNode.parentNode.remove();
                        document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
                        document.querySelector("#totalCompra").innerHTML = objData.total;
                        if(document.querySelectorAll("#tblCarrito tr").length == 1){
                            window.location.href = base_url;
                        }
                    }
                    }else{
                      swal("", objData.msg , "error");
                    }
	        } 
	        return false;
	    }

	}
}

function fntUpdateCant(pla,cant){
    if(cant <= 0){
        document.querySelector("#btnComprar").classList.add("notblock");
    }else{
        document.querySelector("#btnComprar").classList.remove("notblock");
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Tiendabo/updCarrito';
        let formData = new FormData();
        formData.append('id',pla);
        formData.append('cantidad',cant);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState != 4) return;
            if(request.status == 200){
        let objData = JSON.parse(request.responseText);
            if(objData.status){
                let colSubtotal = document.getElementsByClassName(pla)[0];
                colSubtotal.cells[4].textContent = objData.totalPlan;
                document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
                document.querySelector("#totalCompra").innerHTML = objData.total;
            }else{
                swal("", objData.msg , "error");

            }
            }
        }
    }
    return false;
}
