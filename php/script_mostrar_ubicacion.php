<?php
	header("access-control-allow-origin: *");
	include ("conexion_BD.php");
	//-- conseguir el consecutivo de la ultima ubicacion --//
	$sql="SELECT max(consecutivo) FROM posicion";
	$result=mysqli_query($con,$sql);  
	while ($row = mysqli_fetch_row($result)) {
	    $consecutivo=$row[0];
	}

	//-- conseguir la penultima ubicacion --//
	$sql="SELECT * FROM posicion where consecutivo=".($consecutivo-1);
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	while ($row=mysqli_fetch_array($result)) {
		$latitud_antigua = $row['latitud'];
		$longitud_antigua = $row['longitud'];
	}
	echo $latitud_antigua.','.$longitud_antigua.',';

	//-- conseguir la ultima ubicacion --//
	$sql="SELECT * FROM posicion where consecutivo=".$consecutivo;
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	while ($row=mysqli_fetch_array($result)) {
		$latitud_nueva = $row['latitud'];
		$longitud_nueva = $row['longitud'];
	}
	echo $latitud_nueva.','.$longitud_nueva;
?>