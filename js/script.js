$(document).ready(function(){
	// muestra contenido inicial
	mostrarContenido('servidor');

	// muestra contenido dependiendo del item del menu
	$(document).on('click', 'nav ul li', function(){
		mostrarContenido($(this).attr('id'));
	});

// SERVIDOR ---//
	// muestra info del servidor Redis
	$(document).on('click', '#info', function(){
		$.post("funciones.php","action=getInfo",
			function(data){
				$('#rServidor').html(data);
			}
		);
	});
	// guardar BD
	$(document).on('click', '#save', function(){
		$.post("funciones.php","action=setSave",
			function(data){
				$('#rServidor').html(data);
			}
		);
	});
	// muestra ultima vez que persistio Redis
	$(document).on('click', '#lastSave', function(){
		$.post("funciones.php","action=getLastSave",
			function(data){
				$('#rServidor').html(data);
			}
		);
	});
	// muestra la cantidad de claves
	$(document).on('click', '#dbSize', function(){
		$.post("funciones.php","action=getdbSize",
			function(data){
				$('#rServidor').html(data);
			}
		);
	});	
	// vacia la BD
	$(document).on('click', '#flush', function(){
		$.post("funciones.php","action=setFlush",
			function(data){
				$('#rServidor').html(data);
			}
		);
	});
// STRINGS ---//
	// Ver clave - Strings
	$(document).on('click', '.sverClave', function(){
		var IdUsuario = $('input[name="usuario"]:checked').val();
		$.post("funciones.php","action=getString&IdUsuario="+IdUsuario,
			function(data){
				$('#rStrings').html(data);
			}
		);
	});
	// incrementar/decrementar - Strings
	$(document).on('click', '.sIncrDecr', function(){
		var IdUsuario = $('input[name="usuario"]:checked').val();
		var valor = $(this).val();
		$.post("funciones.php","action=setValorString&IdUsuario="+IdUsuario+"&valor="+valor,
			function(data){
				$('#rStrings').html(data);
			}
		);
	});
	// nuevo - Strings
	$(document).on('click', '.sNuevo', function(){
		$.post("funciones.php","action=setNuevo",
			function(data){
				$('#rStrings').html(data);
			}
		);
	});
	// reemplazar - Strings
	$(document).on('click', '.sReemplazar', function(){
		$.post("funciones.php","action=setReemplazar",
			function(data){
				$('#rStrings').html(data);
			}
		);
	});
	// Ver Clave 5 - Strings
	$(document).on('click', '.sverClave5', function(){
		$.post("funciones.php","action=getString&IdUsuario=5",
			function(data){
				$('#rStrings').html(data);
			}
		);
	});
	// subir imagen
	$(document).on('submit', '#sSubirImagenForm', function(e) {
		e.preventDefault();
		$('#sSubirImagen').attr('disabled', ''); // disabilitamos el boton de upload
		$(this).ajaxSubmit({
			type: "POST",
			url: "funciones.php",
			success:  function(data){
				if (data > 0)
					$('#rStrings').html('<img class="sImagenBD" src="funciones.php?action=getImagen&id='+data+'">');
				else
					$('#rStrings').html('Ha ocurrido un error :-)');
				$('#sSubirImagenForm').resetForm();
				$('#sSubirImagen').removeAttr('disabled'); // habilitamos el boton de upload
			}
		});
	});
// HASHES ---//
	// crea un hash
	$(document).on('click', '#aCliente', function(){
		$.post("funciones.php","action=aCliente",
			function(data){
				$('#rHashes').html('<b>Se importaron '+data+' clientes con las siguientes claves:</b> Nombre, Apellido, Correo y Visitas').show().fadeOut(9999);
			}
		);
	});
	// buscar hash
	$(document).on('click', '#bCliente', function(){
		$('#rHashesCampos input[type="text"]').val('');
		$.post("funciones.php","action=bCliente"+"&id="+$('#bClienteId').val(),
			function(data){
				// get json
				if(data != 0){
					var items = eval('(' + data + ')');
					$('#clienteNombre').val(items['nombre']);
					$('#clienteApellido').val(items['apellido']);
					$('#clienteCorreo').val(items['correo']);
					$('#clienteVisitas').val(items['visitas']);
					$('#clienteClave').html('<b>Cliente: '+$('#bClienteId').val()+'</b>');
				}else{
					$('#clienteClave').html('El cliente no existe');
				}
			}
		);
	});
	// modificar hash
	$(document).on('click', '#mCliente', function(){
		$.post("funciones.php","action=mCliente"+"&id="+$('#bClienteId').val()+"&nombre="+$('#clienteNombre').val()+"&apellido="+$('#clienteApellido').val()+"&correo="+$('#clienteCorreo').val(),
			function(data){
				$('#rHashes').html('<b>Cliente '+$('#bClienteId').val()+' Actualizado</b>').show().fadeOut(9999);
				$('#rHashesCampos input[type="text"]').val('');
			}
		);
	});
	// incrementar el contador
	$(document).on('click', '#vCliente', function(){
		$.post("funciones.php","action=vCliente"+"&id="+$('#bClienteId').val(),
			function(data){
				$('#clienteVisitas').val(data);
			}
		);
	});
	// eliminar hash
	$(document).on('click', '#eCliente', function(){
		$.post("funciones.php","action=eCliente"+"&id="+$('#bClienteId').val(),
			function(data){
				$('#rHashes').html('<b>Cliente '+$('#bClienteId').val()+' Eliminado</b>').show().fadeOut(9999);
				$('#rHashesCampos input[type="text"]').val('');
				$('#clienteClave').html('<b>Cliente:</b>');
			}
		);		
	});
// LISTS ---//
	// ver lista
	$(document).on('click', '#lRange', function(){
		var lista = $('input[name="lista"]:checked').val();
		$.post("funciones.php","action=lRange&lista="+lista,
			function(data){
				$('#rLists').html(data);
			}
		);
		$('#lValor').val('');
	});
	// agrega una clave a la lista
	$(document).on('click', '.push', function(){
		var lista = $('input[name="lista"]:checked').val();
		var valor = $('#lValor').val();
		var side = $(this).attr('id');
		$.post("funciones.php","action=push&lista="+lista+"&valor="+valor+"&side="+side,
			function(data){
				$('#rLists').html(data);
			}
		);
		$('#lValor').val('');
	});
	// elimina una clave de la lista
	$(document).on('click', '.pop', function(){
		var lista = $('input[name="lista"]:checked').val();
		var side = $(this).attr('id');
		$.post("funciones.php","action=pop&lista="+lista+"&side="+side,
			function(data){
				$('#rLists').html(data);
			}
		);
		$('#lValor').val('');
	});
// SETS ---//
	// obtiene los miembros
	$(document).on('click', '#sMembers', function(){
		var circulo = $('input[name="circulos"]:checked').val();
		$.post("funciones.php","action=sMembers&circulo="+circulo,
			function(data){
				$('#rSets').html(data);
			}
		);		
	});
	// agrega una clave
	$(document).on('click', '.sadd', function(){
		var circulo = $('input[name="circulos"]:checked').val();
		var usuario = $(this).attr('data');
		$.post("funciones.php","action=sAdd&circulo="+circulo+"&usuario="+usuario,
			function(data){
				$('#rSets').html(data);
			}
		);
		$('#lValor').val('');
	});
	// union de sets
	$(document).on('click', '#sUnion', function(){
		var circulo = $('input[name="circulos"]:checked').val();
		$.post("funciones.php","action=sUnion",
			function(data){
				$('#rSets').html(data);
			}
		);
	});
	// interseccion de sets
	$(document).on('click', '#sInter', function(){
		var circulo = $('input[name="circulos"]:checked').val();
		$.post("funciones.php","action=sInter",
			function(data){
				$('#rSets').html(data);
			}
		);
	});
 // SORTED SETS ---//
	// importa los nombres
	$(document).on('click', '#importarSet', function(){
		$.post("funciones.php","action=importarSet",
			function(data){
				$('#rSortedSets').html(data).show().fadeOut(9999);
			}
		);
	});
	// busca los nombres coincidentes
	$(document).on('keyup', '#buscarClaveSet', function(){
		$('#buscarClaveSetLista').html('');

		$.post("funciones.php","action=buscarClaveSet"+"&prefix="+$(this).val(),
			function(data){
				var items = eval('(' + data + ')');
				for (var i in items)
					$('#buscarClaveSetLista').append('<div class="item">'+items[i]+'</div>');
			}
		);
	});
	// selecciona un nombre de la lista
	$(document).on('click', '.item', function(){
		$('#buscarClaveSet').val($(this).html());
		$('#buscarClaveSetLista').html('');
	});
});

function mostrarContenido(id) {
	$('nav ul li').removeClass('active');
	$('#'+id).addClass('active');
	$('article').hide();
	$('.'+id).show();
}