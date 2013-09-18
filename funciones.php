<?php

include('conexion.php');

$param_action   = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$param_file     = isset($_FILES['imagen']) ? $_FILES['imagen'] : '';
$action         = !empty($param_file) ? 'setImagen' : $param_action;
$nombres        = array('Abbott','Abdiel','Abe','Abel','Abey' ,'Abie' ,'Abijah' ,'Abner','Abraham' ,'Abram');
$apellidos      = array('Abascal','Agudo','Aguilar','Aja','Lopez','Sainz','Trapaga','Alarcon','Albertos','Albrecht');

function mostrarSalida($comando){
	return "<b>Comando: </b>{$comando} <br /><pre>";
}

switch ($action){
	// SERVIDOR ---//
	case 'getInfo':
		echo mostrarSalida('$redis->info();');
		print_r($redis->info());
		echo '</pre>';
	break;
	case 'getLastSave':
		echo mostrarSalida('$redis->lastSave();');
		print_r(date('d-m-Y H:i:s',$redis->lastSave()));
		echo '</pre>';
	break;    
	case 'setFlush':
		$redis->flushDB();
		echo mostrarSalida('$redis->flushDB();');
		print_r($redis->info());
		echo '</pre>';
		break;
	case 'setSave':
		echo mostrarSalida('$redis->save();');
		print_r($redis->save());
		echo '</pre>';
	break;
	case 'getdbSize':
		echo mostrarSalida('$redis->dbSize();');
		print_r($redis->dbSize());
		echo '</pre>';
	break;
	// STRINGS ---//
	case 'getString':
		$IdUsuario = $_POST['IdUsuario'];
		$clave = $redis->get('usuario:'.$IdUsuario.':visitas');
		echo mostrarSalida("\$redis->get('usuario:{$IdUsuario}:visitas');");
		echo !empty($clave)?$clave:'(nill)';
		echo '</pre>';
	break;    
	case 'setValorString':
		$IdUsuario = $_POST['IdUsuario'];
		$valor 	= $_POST['valor'];
		
		if ($valor == '+1'){
			$comando    = "\$redis->incr('usuario:{$IdUsuario}:visitas');";
			$resultado  = $redis->incr('usuario:'.$IdUsuario.':visitas');
		}elseif ($valor == '+10'){
			$comando    = "\$redis->incrBy('usuario:{$IdUsuario}:visitas',10);";
			$resultado  = $redis->incrBy('usuario:'.$IdUsuario.':visitas', 10);         
		}elseif ($valor == '-1'){
			$comando    = "\$redis->decr('usuario:{$IdUsuario}:visitas');";
			$resultado  = $redis->decr('usuario:'.$IdUsuario.':visitas');
		}elseif ($valor == '-10'){
			$comando    = "\$redis->decrBy('usuario:{$IdUsuario}:visitas',10);";
			$resultado  = $redis->decrBy('usuario:'.$IdUsuario.':visitas',10);
		}
		echo mostrarSalida($comando);
		echo $resultado;
		echo '</pre>';
	break;
	case 'setNuevo':
		$redis->set('usuario:5:visitas','Nuevo usuario');
		echo mostrarSalida("\$redis->set('usuario:5:visitas');");
		echo $redis->get('usuario:5:visitas');
		echo '</pre>';
	break;     
	case 'setReemplazar':
		$redis->setRange('usuario:5:visitas', 6, 'Visitante');
		echo mostrarSalida("\$redis->setRange('usuario:5:visitas', 6, 'Visitante');");
		echo $redis->get('usuario:5:visitas');
		echo '</pre>';
	break;   
	case 'setImagen':
		if (isset($_FILES['imagen']) && $_FILES['imagen']["error"] == 0){
			$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
			$limite_kb = 16384; // max 16Mb
			$id = rand();
			if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024){ 
				$data = file_get_contents($_FILES['imagen']['tmp_name']);
				$tipo = $_FILES['imagen']['type'];
				$resultado = $redis->mset(array("imagenes:{$id}:imagen" => base64_encode($data), "imagenes:{$id}:tipo" => $tipo));
			}
		echo ($resultado == 1) ? $id : 0;
		}
	break;  
	case 'getImagen':
		if (!empty($id)){
			$imagen = base64_decode($redis->get("imagenes:{$id}:imagen"));
			$tipo   = $redis->get("imagenes:{$id}:tipo");
	 
			header("Content-type: {$tipo}");
			echo $imagen;
		} 
	break;
	// HASHES ---//
	case 'aCliente':
		$i = 0;
		foreach ($apellidos as $apellido) {
			foreach ($nombres as $nombre) {
				$i++;
				$mail = strtolower($nombre.'@'.$apellido.'.com');
				$redis->hmset('cliente:' . $i, array('nombre' => $nombre, 'apellido' => $apellido, 'correo' => $mail, 'visitas' => 0));
			}
		}
		echo $i;
	break;
	case 'bCliente':
		$cliente = $redis->hGetAll('cliente:' . $_POST['id']);
		echo !empty($cliente) ? json_encode($cliente) : '0';
	break;
	case 'mCliente':
		$id = $_POST['id'];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$correo = $_POST['correo'];
		$redis->hmset('cliente:' . $id, array('nombre' => $nombre, 'apellido' => $apellido, 'correo' => $correo));
	break;
	case 'vCliente':
			$id = $_POST['id'];
			echo $redis->hIncrBy('cliente:' . $id, 'visitas', 1);
	break;
	case 'eCliente':
			$id = $_POST['id'];
			$redis->del('cliente:' . $id);
	break;
	// LISTS ---//
	case 'lRange':
		$lista = 'list'.$_POST['lista'];
		echo mostrarSalida("\$redis->lRange({$lista}, 0, -1);");
		print_r($redis->lRange($lista,0,-1));
		echo '</pre>';
	break;
	case 'push':
		$lista = 'list'.$_POST['lista'];
		$valor = $_POST['valor'];
		$side = $_POST['side'];
		$redis->$side($lista,$valor);

		echo mostrarSalida("\$redis->{$side}({$lista},'{$valor}');");
		print_r($redis->lRange($lista,0,-1));
		echo '</pre>';
	break;
	case 'pop':
		$lista = 'list'.$_POST['lista'];
		$side = $_POST['side'];
		$redis->$side($lista);

		echo mostrarSalida("\$redis->{$side}({$lista});");
		print_r($redis->lRange($lista,0,-1));
		echo '</pre>';
	break;  
	// SETS ---//
	case 'sMembers':
		$circulo = 'circulo:alberto:'.$_POST['circulo'];
		echo mostrarSalida("\$redis->smembers('{$circulo}');");
		print_r($redis->smembers($circulo));
		echo '</pre>';
	break;
	case 'sAdd':
		$circulo = 'circulo:alberto:'.$_POST['circulo'];
		$usuario = 'usuario:'.$_POST['usuario'];
		$redis->sadd($circulo, $usuario);

		echo mostrarSalida("\$redis->sadd('{$circulo}', '{$usuario}');");
		print_r($redis->smembers($circulo));
		echo '</pre>';
	break;
	case 'sUnion':
		$cFamilia   = 'circulo:alberto:familia';
		$cFacultad  = 'circulo:alberto:facultad';
		$cFutbol    = 'circulo:alberto:futbol';

		echo mostrarSalida("\$redis->sunion({$cFamilia}, {$cFacultad}, {$cFutbol});");
		print_r($redis->sunion($cFamilia, $cFacultad, $cFutbol));
		echo '</pre>';
	break;      
	case 'sInter':
		$cFamilia   = 'circulo:alberto:familia';
		$cFacultad  = 'circulo:alberto:facultad';
		$cFutbol    = 'circulo:alberto:futbol';

		echo mostrarSalida("\$redis->sinter({$cFamilia}, {$cFacultad}, {$cFutbol});");
		print_r($redis->sinter($cFamilia, $cFacultad, $cFutbol));
		echo '</pre>';
	break;      
	// SORTED SETS ---//
	case 'importarSet':
		if (!$redis->exists("nombres")) {
			$file = file("nombres.txt");
			$i = 0;
			foreach ($file as $line) {
				$line = trim($line);
				for ($j = 0; $j < strlen($line); $j++) {
					$prefix = substr($line, 0, $j);
					$redis->zAdd("nombres", 0, $prefix);
				}
				$redis->zAdd("nombres", 0, $line . "*");
				$i++;
			}            
			echo "Se importaron {$i} Nombres";
		}else {
			echo "Los Nombres ya se importaron";
		}
	break;
	case 'buscarClaveSet':
		$prefix		= $_POST['prefix'];		
		$results	= array();
		$count		= 50;
		$rangeLen 	= 50;
		$start 		= $redis->zRank("nombres", $prefix);

		while(count($results) != $count) {
			$range = $redis->zRange("nombres", $start, $start+$rangeLen-1);
			$start += $rangeLen;
			if(!$range || count($range) == 0)
				break;
			foreach($range as $entry) {
				$minLen = min(strlen($entry), strlen($prefix));
				if(substr($entry, 0, $minLen) != substr($prefix, 0, $minLen))
					$count = count($results);
				if(substr($entry, -1) == "*" && count($results) != $count)
					$results[] = substr($entry, 0, -1);
			}
		}
		echo json_encode($results);
	break;
	default:
		echo 'PHP/Redis - phpredis';
	break;
}
?>