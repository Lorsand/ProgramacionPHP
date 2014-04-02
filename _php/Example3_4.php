<?php
  if (isset($_COOKIE['eventos'])) { 
    $array = split("/n",$_COOKIE['eventos']);
  }  else {
    $array = array();
  };
  
  if (isset($_POST['borrar'])) {
	  $id = $_POST['borrar'];
	  unset($array[$id]);
	  $array = array_values($array);
	  setcookie('eventos',implode("/n",$array));
  } else if (isset($_POST['agregar'])) {
	  $new_item = $_POST['dia'].'|'.$_POST['hora'].'|'.$_POST['evento'];
	  $array[] = $new_item;
	  setcookie('eventos',implode("/n",$array));
  } else {
	  setcookie('eventos',null);
	  $array = array();
  }
?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<head>
		<title>Calendario de eventos</title>
	</head>
	<body>
	  <h2>Calendario de eventos</h2>
	  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<table border=1>
			<tr><th>Día</th><th>Hora</th><th>Evento</th><th>Operación</th></tr>
			<?php
			  for ($i=0;$i<sizeof($array);$i++) {
				$values = explode("|",$array[$i]);
				echo '<tr><td>'.$values[0].'</td><td>'.$values[1].'</td><td>'.
					$values[2].'</td><td><button name="borrar" value="'.$i.
					'">Borrar</button></td></tr>';
			  }
			?>
			<tr><td><input size="10" name="dia" type="date"/></td>
			    <td><input name="hora" size="10" type="time"/></td>
				<td><input size="40" name="evento"/></td>
				<td><button name="agregar">Agregar</button></td>
			</tr>
		</table>
	  </form>
	</body>
</html>