<?php
	session_start();
    ob_start(); //Linea para permitir enviar flujo de datos por url al redireccionar la pagina 
    header("access-control-allow-origin: *");
	include ("conexion_BD.php");
	if(isset($_SESSION['Usuario'])){
        
	}else{
		header("Location: ../index.php?Error=Acceso denegado");
	}
    ob_end_flush();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PANEL DE ADMINISTRACIÓN</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="../images/gps_icon.ico" type="image/vnd.microsoft.icon"\>
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../estilos_css/estilos_admin.css">
    <script type="text/javascript" src="../javascript/script_admin.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){ 
            //alert("sirve js");
        });
	</script>
</head>
<body>
    <div class="container">
        <header>
            <!-- Contenedor de la imagen banner y el título de la cabecera -->
            <div class="row sombra_banner" id="top_home">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <center>
                        <img src="../images/banner.jpg" class="img-responsive banner" alt="gps" style="height: 180px; width: 100%;">
                    </center>
                </div>
            </div>
            <br>
            <div class="row sombra" id="header">
                <div class="col-xs-6 col-md-6" style="width: 60%;">
                    <label style="color: white; padding-top: 0.5em; padding-left: 0.5em;">ADMINISTRADOR</label>
                </div>
                <div class="col-xs-6 col-md-6" style="text-align: right; width: 40%;">
                    <a href="./cerrar_sesion_administrador.php">
                        <button type="button" class="btn btn-primary btn-sm sombra" id="boton">
                            <span class="glyphicon glyphicon-lock"></span>
                            Cerrar Sesión
                        </button>
                    </a>
                </div>
            </div>
        </header>
        <br>

        <hr>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <center>
                    <h4><b>SELECCIONE UNA OPCIÓN</b></h4>
                </center>                        
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <br>
                <center>
                <a href="./mostrar_ubicacion.php">
                    <button type="submit" class="btn btn-success btn-lg boton">
                        <span class="glyphicon glyphicon-globe"></span>
                        POSICIÓN DEL PACIENTE
                    </button> 
                </a>
                </center>
            </div>
        </div>
        <br>
        <hr>
        <footer>
            <div class="row">
                <div class="col-xs-12 col-md-12" style="text-align: center;">
                    <span style="color: #428bca;"><b>Proyecto - Teleinformática II</b></span>
                    <br>
                    <span id="fecha_footer" style="color: #428bca; font-size: 0.9em;"></span>
                    <br><br>
                </div>
            </div>
        </footer>
    </div>    
</body>
</html>