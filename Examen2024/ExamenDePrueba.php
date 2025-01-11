<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Examen de Prueba</title>
	<style type="text/css">
		body {
			background: #CCC;
			width: 1024px;
			display: block;
			margin: auto;
			font: Georgia, "Times New Roman", Times, serif;
		}

		#principal {
			background: #9FF;
			border-radius: 10px 10px 10px 10px;
			-ms-border-radius: 10px 10px 10px 10px;
			-webkit-border-radius: 10px 10px 10px 10px;
			-moz-border-radius: 10px 10px 10px 10px;
			-o-border-radius: 10px 10px 10px 10px;
			-ms-box-shadow: 0 0 1.3em black;
			-moz-box-shadow: 0 0 1.3em black;
			-webkit-box-shadow: 0 0 1.3em black;
			-o-box-shadow: 0 0 1.3em black;
			box-shadow: 0 0 1.3em black;
		}

		h1 {
			border: Outset 6px LightBlue;
			background-color: DarkSlateBlue;
			text-align: center;
			color: Khaki;
		}

		.entrada {
			background-color: LightGoldenrodYellow;
			font-family: "Bitstream Vera Serif";
			font-weight: bold;
			font-size: 12pt;
			color: Crimson;
			text-align: center;
			width: 40px;
		}

		.promedio {
			background-color: LightGoldenrodYellow;
			font-family: "Bitstream Vera Serif";
			font-weight: bold;
			font-size: 12pt;
			color: Crimson;
			text-align: center;
			width: 55px;
		}

		.salida {
			text-align: center;
			width: 40px;
		}

		input[type=text] {
			border-radius: 7px;
		}

		.fecha {
			background-color: LightGoldenrodYellow;
			font-family: "Bitstream Vera Serif";
			color: Crimson;
			font-weight: bold;
			font-size: 12pt;
			text-align: center;
		}

		p {
			font-family: Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
			font-style: italic;
			font-size: 14pt;
			color: blue;
		}

		h2 {
			font-family: Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
			color: red;
			font-size: 24px;
		}
	</style>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="js/main.js"></script>
	<?php
	$Frases = array(
		'Esperamos que pueda suceder cualquier cosa, y nunca estamos prevenidos para nada. Sophie Soynonov',
		'El pasado es como una lámpara colocada a la entrada del porvenir. Félicité Robert de Lamennais',
		'Valor es lo que se necesita para levantarse y hablar, pero también es lo que se requiere para sentarse y escuchar.',
		'Si no sueltas el pasado, ¿con qué mano agarras el futuro?'
	);
	$curso = "210A";
	$codcol = "00026011";
	$alucur = "alucura24";
	$archnotas = 'notasa24';
	$link = mysqli_connect("localhost", "root", "", "examen24");
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	mysqli_select_db($link, "examen24");

	$consulta = "SELECT * FROM $archnotas WHERE curso='$curso'";
	$result = mysqli_query($link, $consulta) or die("* ERROR EN $archnotas *" . mysqli_error($link));
	$Alumnos = array();
	while ($registro = mysqli_fetch_array($result)) {
		$codal = $registro['codigo'];
		$Notas[$codal][1] = $registro['nota1'];
		$Notas[$codal][2] = $registro['nota2'];
		$Notas[$codal][0] = round(($registro['nota1'] + $registro['nota2']) / 2, 1);
	}

	$consulta = "SELECT C.codigo,A.apellidos,A.nombres FROM $alucur C,alumnos A ";
	$consulta .= " WHERE C.curso='$curso' AND C.codigo=A.codigo ORDER BY A.apellidos ASC ";
	$result = mysqli_query($link, $consulta) or die("* ERROR EN ALUMNOS *" . mysqli_error($link));
	$Alumnos = array();
	while ($registro = mysqli_fetch_array($result)) {
		$codal = $registro['codigo'];
		$Alumnos[$codal] = utf8_encode($registro['apellidos'] . ' ' . $registro['nombres']);
	}
	$n = rand(0, 3);
	$CodsAlum = array_keys($Alumnos); // Guardo el codigo del alumno para insertar las columnas
	mysqli_close($link);
	?>
	<script>
		Alumnos = <?PHP echo json_encode($Alumnos); ?>
	</script>
	<script>
		CodsAlum = <?PHP echo json_encode($CodsAlum); ?>
	</script>
	<script>
		Notas = <?PHP echo json_encode($Notas); ?>
	</script>
</head>

<body>
	<center>
		<div id="principal">
			<br />
			<h1>COLEGIO DE PRUEBA SYSCOLEGIOS </h1>
			<marquee>
				<?php echo $Frases[$n] . date('Y-m-d'); ?>
			</marquee>
			<h2>PLANILLA DE INGRESO DE CALIFICACIONES</h2>
			<p>Fecha de Ingreso:
				<input type="text" id="fecha" readonly="readonly" size="8" class="fecha" />
			</p>
			<hr />
			<img src="SignoMas.jpg" id="masCol" width="50" height="50" title="Adicionar Columna" />
			<form id="Form1">
				<div id="contenedor"></div>
			</form>
			<div id="mensaje" title="Mensaje syscolegios"></div>
			<hr />

			<input type="button" id="grabar" value="Grabar">
			<input type="button" id="regresar" value="Regresar" onclick="window.history.go(-1);">
			<hr />
		</div>
	</center>
</body>

</html>