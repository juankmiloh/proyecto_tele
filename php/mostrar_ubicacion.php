<!DOCTYPE html>
<html>
<head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  	<title>SERVIDOR / POSICIÓN</title>
  	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  	<link rel="shortcut icon" href="../images/gps_icon.ico" type="image/vnd.microsoft.icon"\>
  	<script src="../js/jquery.js"></script>
  	<script src="../js/bootstrap.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  	<style type="text/css">
      html, body { height: 100%; margin: 0; padding: 0; }
      #map { height: 100%;  width:100%;}
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5TqLnWHMFlFSxufxXOEJK7jp-J3_isJY&signed_in=true&libraries=places&callback=initMap" async defer></script>
  	<script>
		$(document).ready(function(){
			//alert("hola mundo");
		});
		
		var map;
		var marcadores = [[],[]];
		var geocoder;
		var infowindow;

		var markers = [];

		function initMap() {
			geocoder = new google.maps.Geocoder;
			infowindow = new google.maps.InfoWindow;
			

			var latitud = 4.6280995; //valor establecido cuando se registra el paciente
  			var longitud = -74.0658582; //opcionales toca cambiarlos por los de la BD

		    var latlng = new google.maps.LatLng(latitud, longitud);
		    var mapOptions = {
		    	zoom: 18, //18
		    	center: latlng,
		    	mapTypeId: google.maps.MapTypeId.ROADMAP,
		    }
		    map = new google.maps.Map(document.getElementById('map'), mapOptions); 

		    marcadores[0][0] = latitud;
		    marcadores[0][1] = longitud;

		    setMarkers(null, null, true, false, "UBICACIÓN ESTABLECIDA"); 
		    iniciar(); 
		}

		function iniciar(){
			//alert("entra");
			//-- valores de ubicacion definidos por el usuario --//
			//var latitud_fija = 4.6827396; //valor establecido cuando se registra el paciente
	  		//var longitud_fija = -74.1395542; //opcionales toca cambiarlos por los de la BD

	  		var latitud_fija = 4.6280995; //valor establecido cuando se registra el paciente
	  		var longitud_fija = -74.0658582; //opcionales toca cambiarlos por los de la BD

	  		//-- valores del rango del radio de ubicacion establecido --//
	  		var latitud_rango_arriba = latitud_fija+0.00090;
  			var latitud_rango_abajo = latitud_fija-0.00090;
  			var longitud_rango_derecha = longitud_fija+0.00090;
  			var longitud_rango_izquierda = longitud_fija-0.00090;

			//$.get("http://10.21.51.114:8080/proyecto_tele/script_mostrar_ubicacion.php", function(data, status){
			$.get("../php/script_mostrar_ubicacion.php", function(data, status){
		        //alert("Data: " + data + "\nStatus: " + status);
		        var str = data;
                var res = str.split(",");

                //-- aca se carga el registro de ubicacion de la base de datos --//
		        latitud_bd_antigua = parseFloat(res[0]);
		        longitud_bd_antigua = parseFloat(res[1]);

		        latitud_bd_nueva = parseFloat(res[2]);
		        longitud_bd_nueva = parseFloat(res[3]);	  			

		        //-- se muestran los valores en los campos de texto --//
			    $('#id_latitud').val(latitud_bd_nueva); //posicion respecto al ecuador
	  			$('#id_longitud').val(longitud_bd_nueva); //posicion respecto al meridiano de greenwich

	  			marcadores[0][0] = latitud_bd_nueva;
			    marcadores[0][1] = longitud_bd_nueva;
			    //alert(marcadores);
			    imagen_marcador = '../images/paciente.png';
			    
			    //setMarkers(map, marcadores, geocoder, infowindow, imagen_marcador, null, false, true); 

			    if (latitud_bd_nueva>=latitud_rango_arriba || latitud_bd_nueva<=latitud_rango_abajo || longitud_bd_nueva>=longitud_rango_derecha || longitud_bd_nueva<=longitud_rango_izquierda) { 
			    	//deleteMarkers();
			    	//setMarkers(map, marcadores, geocoder, infowindow, imagen_marcador, null, false, true); 
			    	document.getElementById('demo').play();
	  				navigator.vibrate(10000);
	  				//alert("Se voló el hpta paciente!!!");
	  				//iniciar(map, marcadores, geocoder, infowindow);
	  			} else {
	  				//deleteMarkers();
	  				//setMarkers(map, marcadores, geocoder, infowindow, imagen_marcador, null, false, true); 
	  				document.getElementById('demo').pause();
	  				navigator.vibrate(0);
	  				//iniciar(map, marcadores, geocoder, infowindow);
	  			}

			    if ((latitud_bd_nueva != latitud_bd_antigua) || (longitud_bd_nueva != longitud_bd_antigua)) {
			    	//alert("se cumplio");
			    	deleteMarkers();
			    	setMarkers(imagen_marcador, google.maps.Animation.BOUNCE, false, true, "UBICACIÓN DEL PACIENTE"); 
			    } 

			    if ((latitud_bd_nueva == latitud_bd_antigua) || (longitud_bd_nueva == longitud_bd_antigua)) {
			    	deleteMarkers();
			    	setMarkers(imagen_marcador, google.maps.Animation.BOUNCE, false, true, "UBICACIÓN DEL PACIENTE"); 
			    }
	  			setTimeout('iniciar()',2000);
		    });
		}

		function setMarkers(icono, animacion, dibujar_radio, guardar_marcador, mensaje) {
			for (var i = 0; i < marcadores.length; i++) {
				var myLatLng = new google.maps.LatLng(marcadores[i][0], marcadores[i][1]);

				var marker = new google.maps.Marker({
					position: myLatLng,
					icon: icono,
					animation: animacion,//bounce
					map: map,
				});
				(function(i, marker) {
					geocoder.geocode({'location': myLatLng}, function(results, status) {
						google.maps.event.addListener(marker,'click',function() {      
							var markerLatLng = marker.getPosition();    
							infowindow.setContent(
									'<br><b><center>'+mensaje+'</center></b><br>'+ 
									'<b>BARRIO: </b>' + results[1].formatted_address +  
									'<br><b>DIRECCIÓN: </b>' + results[0].formatted_address +
									'<br><b>LATITUD: </b>' + marker.getPosition().lat() +
									'<br><b>LONGITUD: </b>' + markerLatLng.lng()
								);
							infowindow.open(map, marker);         
						});
					});
				})(i, marker);

				if (guardar_marcador) {
					markers.push(marker);
				}

				if (dibujar_radio) {
					var cityCircle = new google.maps.Circle({
						strokeColor: 'red',
						strokeOpacity: 0.8,
						strokeWeight: 2,
						fillColor: '#FF0000',
						fillOpacity: 0.35,
						map: map,
						center: myLatLng,
						radius: 110
					});   
				}   
			}
		}

		// Sets the map on all markers in the array.
		function setMapOnAll(map) {
		  	for (var i = 0; i < markers.length; i++) {
		    	markers[i].setMap(map);
		  	}
		}

		// Removes the markers from the map, but keeps them in the array.
		function clearMarkers() {
		  	setMapOnAll(null);
		}

		// Shows any markers currently in the array.
		function showMarkers() {
		  	setMapOnAll(map);
		}

		// Deletes all markers in the array by removing references to them.
		function deleteMarkers() {
		  	clearMarkers();
		  	markers = [];
		}
	</script> 
</head>
<body>    
	<audio id="demo" src="../audio/alerta"></audio>
    <div class="container">
		<hr>
    	<center>
	     	<div class="row">
		        <div class="col-xs-12 col-sm-12 col-md-12">
		        	<label>POSICIÓN DEL PACIENTE</label>
		        </div>
		    </div>
		    <hr>
	        <!--<div class="row">
	        	<div class="col-xs-12 col-sm-12 col-md-12">
		            <label for="id_latitud">Latitud:</label><br>
		            <input id="id_latitud" name="latitud" step="any" type="number" value="0.0">
	          	</div>
	        </div>
	        <div class="row">
	        	<div class="col-xs-12 col-sm-12 col-md-12">
	            	<label for="id_longitud">Longitud:</label><br>
	            	<input id="id_longitud" name="longitud" step="any" type="number" value="0.0">
	          	</div>
	        </div>
		    <hr>
	        <div class="row">
	        	<div class="col-xs-12 col-sm-12 col-md-12">
	          	</div>
	        </div>
	        <hr>
		</center>-->
    </div>
    <div id="map"></div>
</body>
</html>