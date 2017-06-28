<?php
	/*
	* conexion con la base de datos del servidor co.nf
	*/
 //    $con = mysqli_connect("localhost","root","root","ubicacion_persona");
 //    // Check connection
 //    mysqli_query($con, "SET NAMES 'UTF8'");
 //    if (mysqli_connect_error())
	// {
	// 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	// }
 //    //echo 'Conectado satisfactoriamente';
?>

<?php
	/*
	* conexion con la base de datos del servidor co.nf
	*/
    $con = mysqli_connect("fdb3.biz.nf","2158013_mp","proyectotele2","2158013_mp");
    // Check connection
    mysqli_query($con, "SET NAMES 'UTF8'");
    if (mysqli_connect_error())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
    //echo 'Conectado satisfactoriamente';
?>