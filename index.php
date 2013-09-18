<!DOCTYPE html>
<html>
	<head>
		<title>PHP/Redis - phpredis</title>
		<link type="text/css" href="css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script>
		<script type="text/javascript" src="js/script.js"></script>		
		<!--[if lt IE 9]>
				<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<header>
			<h1>PHP/Redis - phpredis</h1>
		</header> 
		<nav>
			<ul>
				<li id="servidor">Servidor</li>
				<li id="strings">Strings</li>
				<li id="hashes">Hashes</li>
				<li id="lists">Lists</li>
				<li id="sets">Sets</li>
				<li id="sorted_sets">Sorted Sets</li>
			</ul>
		</nav>
		<section>
			<!-- SERVIDOR -->            
			<article class="servidor">
				<div class="botones">
					<h2>Servidor:</h2>
					<input type="button" id="info" value="Info del Servidor" />
					<input type="button" id="save" value="Guardar en Disco" />
					<input type="button" id="lastSave" value="Ultima persistencia" />
					<input type="button" id="dbSize" value="Cantidad de claves" />
					<input type="button" id="flush" value="Vaciar BD" />
				</div>                
				<div class="resultados" id="rServidor"></div>
			</article>
			<!-- STRING -->  
			<article class="strings">
				<div class="botones">
					<h2>Strings:</h2>
					<input type="radio" name="usuario" id="usuario1" value="1" checked="checked">
					<label for="usuario1">ID:1 Fabi&aacute;n</label>
					<br />
					<input type="radio" name="usuario" id="usuario2" value="2">
					<label for="usuario2">ID:2 Tom&aacute;s</label>
					<br />
					<input type="radio" name="usuario" id="usuario3" value="3">
					<label for="usuario3">ID:3 Eve</label>
					<br />					
					<input type="radio" name="usuario" id="usuario4" value="4">
					<label for="usuario4">ID:4 Alberto</label>

					<input type="button" class="sverClave" value="Ver Clave" />
					<input type="button" class="sIncrDecr" value="+10" />
					<input type="button" class="sIncrDecr" value="+1" />
					<input type="button" class="sIncrDecr" value="-1" />
					<input type="button" class="sIncrDecr" value="-10" />

					<input type="button" class="sNuevo" value="set 'usuario:5:visitas'" />
					<input type="button" class="sReemplazar" value="setRange 'Visitante'" />
					<input type="button" class="sverClave5" value="get 'usuario:5:visitas'" />
					
					<form enctype="multipart/form-data" id="sSubirImagenForm">
						<input type="file" name="imagen"/>
						<input type="submit" id="sSubirImagen" value="Subir" />
					</form>
				</div>                
				<div class="resultados" id="rStrings"></div>
			</article>
			<!-- HASH -->  
			<article class="hashes">
				<div class="botones">
					<h2>Hashes de clientes:</h2>
					<input type="button" id="aCliente" value="Importar Clientes" />
					<input type="button" id="bCliente" value="Buscar" />
					<input type="text" id="bClienteId" value="" />
					
					<input type="button" id="mCliente" value="Modificar" />
					<input type="button" id="vCliente" value="Visitar" />
					<input type="button" id="eCliente" value="Eliminar" />
				</div>
				<div class="resultados" id="rHashes"></div>
				<div class="resultados" id="rHashesCampos">
					<p id="clienteClave"><b>Cliente:</b></p>
					<label for="clienteNombre">Nombre</label>
					<input type="text" id="clienteNombre" value="" />
					<label for="clienteApellido">Apellido</label>
					<input type="text" id="clienteApellido" value="" />
					<label for="clienteCorreo">Correo</label>
					<input type="text" id="clienteCorreo" value="" />
					<label for="clienteVisitas">Visitas</label>
					<input type="text" id="clienteVisitas" value="" readonly="readonly"/>
				</div>
			</article>
			<!-- LIST -->  
			<article class="lists">
				<div class="botones">
					<h2>Listas:</h2>
					<input type="radio" name="lista" id="lista1" value="1" checked="checked">
					<label for="lista1">Lista uno</label>
					<br />					
					<input type="radio" name="lista" id="lista2" value="2">
					<label for="lista2">Lista dos</label>

					<input type="text" id="lValor" value="" />
					<input type="button" id="lRange" value="Ver Lista" />
					<input type="button" id="lPush" class="push" value="Agregar: Izquierda" />
					<input type="button" id="lPop" class="pop" value="Eliminar: Izquierda" />
					<input type="button" id="rPush" class="push" value="Agregar: Derecha" />
					<input type="button" id="rPop" class="pop" value="Eliminar: Derecha" />
				</div>
				<div class="resultados" id="rLists"></div>
			</article>
			<!-- SET -->  
			<article class="sets">
				<div class="botones">
					<h2>Circulos de Alberto:</h2>
					<input type="radio" name="circulos" id="circuloFamilia"  value="familia" checked="checked">
					<label for="circuloFamilia">Familia</label>
					<br />					
					<input type="radio" name="circulos" id="circuloFacultad" value="facultad">
					<label for="circuloFacultad">Facultad</label>
					<br />
					<input type="radio" name="circulos" id="circuloFutbol" value="futbol">
					<label for="circuloFutbol">Futbol</label>

					<input type="button" id="sMembers" value="Ver Circulo" />
					<input type="button" data="tom&aacute;s" class="sadd" value="agregar a Tom&aacute;s" />
					<input type="button" data="fabi&aacute;n" class="sadd" value="agregar a Fabi&aacute;n" />
					<input type="button" data="eve" class="sadd" value="agregar a Eve" />
					<input type="button" data="juan" class="sadd" value="agregar a Juan" />

					<input type="button" id="sUnion" value="Union" />
					<input type="button" id="sInter" value="Intersecci&oacute;n" />
				</div>
				<div class="resultados" id="rSets"></div>
			</article>
			<!-- SORTED SET -->  
			<article class="sorted_sets">
				<div class="botones">
					<h2>Autocompletado:</h2>
					<input type="button" id="importarSet" value="Importar Nombres" />
					<input type="text" id="buscarClaveSet" value="" />
					<div id="buscarClaveSetLista"></div>
				</div>
				<div class="resultados" id="rSortedSets"></div>
			</article>
		</section>
		<footer>
		</footer>
	</body>
</html>