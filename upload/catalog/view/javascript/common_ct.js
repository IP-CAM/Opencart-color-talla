$(document).ready(function() {

	//Mejora Tallas
	$('li.talla').live('click',function(element){
		if(!$(this).hasClass('nostock') ){
			$('li.talla > a').removeClass('active');
			$('#option_selected').val($(this).attr('value'));
			$(this).find('a').addClass('active');

			$('.talla_activa > b').html($(this).children().html());
			if($(this).attr('equivalent')!=0) {
				$('#talla-usa-activa').html(' - TALLA USA: ' + $(this).attr('equivalent'));
			}
		}
	});

	$('ul.size li').live('click',function(){
	
	  	var option_value_id = $(this).attr('value');		
	  	if($(this).attr('STOCK') > 0){
			 var talla_usa =  $(this).attr('talla-usa');
			 var category =  $(this).attr('category');
			 var option =  $(this).attr('option');
	    $('#option_selected').attr('value',option_value_id);
	    $('ul.size li a').removeClass('active');
	    $(this).children().addClass('active');
	    $('.talla_activa > b').html ($(this).children().html());
	    // $('.selected_value').html('Color: ' + COLOR + ', Talla ' + ($(this).children().html()) );
	  }
	  $('div.title-col-der h2.precio').html($(this).attr('price_txt') );

	  	//Display de precios y precios especiales
	  	var precio_special = $(this).attr('price_special_txt');
		if(precio_special !="$0") {
			$('#precio_special').show();
			$('#precio_old').show();
			$("#has-special").show();
			$('#precio_product').hide();
			$('#precio_special').html(precio_special);		
			$('#precio_special').html(precio_special);		
		} else {
			$("#precio_product").remove();
			$("#precio_product").remove();
			$("#has-special").hide();
			$('#precio_special').hide();
			$('#precio_old').hide();
			var precio_txt = $(this).attr('price_txt');
			$("#title-col-der").prepend("<h2 id='precio_product' class='precio'>"+precio_txt+"</h2>");
			$("#price-columbia").prepend("<span id='precio_product'>"+precio_txt+"</span>");
		}
	});
	
});

function setTallas(color_id,sku,color_name,elemento,product_id){
	$('div.colores img').removeClass('color_activo');
	$('div.colors .img').removeClass('div-color_activo');
	
	$(elemento).addClass('color_activo');
	$(elemento).parent().parent().addClass('div-color_activo');
	COLOR = color_name;
	$('.image-additional > a').addClass('hide');
	$('.image-additional > a').each(function(index,element){
	  if(color_id==$(element).attr('color-id')){
	    $(element).removeClass('hide');
	    $(element).addClass('color-selected');
	  }
	});

	$('#option_selected').attr('value','');
	$('.talla_activa > b').html('');
	$('#talla-usa-activa').text('');
	$('.selected_value').html('');

	$.get('index.php?route=product/product/getTallas',{'color_id' : color_id,sku: sku}, function(data) {
	  $("ul.size").html(data);
	  $('span.name_color > b').html(COLOR);
	  if($('ul.size li').size()==1){ // si hay una sola talla
	    $('ul.size li').trigger('click');
	  }
	});

	$.get('index.php?route=product/product/getDetalleColor',{'color_id' : color_id, sku: sku}, function(json) {
		$('span.cod_modelo').html('C&Oacute;DIGO MODELO: ' + json);
		$('div.title-col-der h2.precio').html($('ul.size li').first().attr('price_txt') );
	});


	$.get('index.php?route=product/product/getDetalleColorYPrecio',{'color_id' : color_id, sku: sku}, function(json) {
		console.log(json);
		// $('span.cod_modelo').html('C&Oacute;DIGO MODELO: ' + json);
		// $('div.title-col-der h2.precio').html($('ul.size li').first().attr('price_txt') );
	});
	
}

function changeColor(color_id, nombre, price, price_color, price_oferta, color, product_code_forus){

	$('#option_selected').val('');
	$('ul.tallas li > a').removeClass('active');
	$('#color-name').html(nombre);
	$('.cod_modelo model').html(product_code_forus);
	$('.colors > div').removeClass('div-color_activo');
	$(color).parent().parent().addClass('div-color_activo');

	var _qty = 0;
	var last = 0;
	$( "ul.tallas li" ).each(function( index ) {
		$(this).addClass('hide');
		if($(this).attr('color') == color_id){
			$(this).removeClass('hide');
			last = this;
			_qty++;
		}
	});
		
	if(_qty==1){
		$(last).trigger('click');
	}

	//cuando no hay ofertas...
	if(price != price_color && price_color!='$0'){
		if(price_color=='$0'){
			$('#precio-normal').html(price);
		} else {
			$('#precio-normal').html(price_color);
		}
	} else {
		$('#precio-normal').html(price)
	}

	//cuando hay ofertas
	$('#has-special > div').addClass('hide');
	$('#precio-padre').html(price); //cambia por el precio de ficha
	if(price_oferta!= '$0'){ //cuando hay oferta
		$('#precio-oferta').html(price_oferta);
		$('#precio-padre').html(price);
		$('#has-special > div').removeClass('hide');
		$('#has-special > div.normal').addClass('hide');
	} else { //cuando no hay, muestra precio color
		$('#precio-normal').html(price_color);
		$('#has-special > div.normal').removeClass('hide');
	}

	//carrusel
	// $('.colors .img img').removeClass('color_activo');
	// $(color).addClass('color_activo');
	$(color).parent().parent().addClass('div-color_activo');
	$('.image-additional > a').addClass('hide');
	$('.image-additional > a').each(function(index,element){
	  if(color_id==$(element).attr('color-id')){
	    $(element).removeClass('hide');
	    $(element).addClass('color-selected');
	  }
	});
}

