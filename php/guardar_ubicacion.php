<?php
	header("access-control-allow-origin: *");
	include ("conexion_BD.php");
	$latitud=$_POST['Latitud'];
	$longitud=$_POST['Longitud'];

	$sql="INSERT INTO posicion(latitud,longitud) VALUES(
				'".$latitud."',
				'".$longitud."'
				)";
	if (mysqli_query($con,$sql)==TRUE){
		echo "Registros guardados correctamente.";
	} else {
		echo "error: ". $sql . "<br>" . $con->error;
	}
?>