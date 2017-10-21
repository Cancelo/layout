<?php

header('Content-Type: application/json');

// BD
//define('DB_HOST', 'localhost:3306');
define('DB_HOST', 'BEMFSW2008_R2:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '##c3ns0l0r##');
define('DB_NAME', 'sigrec');

// Validar GET
if(!isset($_GET["f"])) {
    if(empty($_GET["f"])) {
				// Por defecto
        defaultData();
			}
    } else {
    $f = $_GET["f"];

		// Llamada a funciones dependiendo del valor recibido
}

function defaultData() {

  $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if(!$mysqli) { die("Connection failed: ".$mysqli->error); }

	$query = sprintf("SELECT fechaLlegada AS y,

  SUM(CASE WHEN fechaLlegada THEN 1 ELSE 0 END) AS Recibidas,

  SUM(CASE WHEN fechaReparacion THEN 1 ELSE 0 END) AS Reparadas,

  SUM(CASE WHEN fechaFin THEN 1 ELSE 0 END) AS Enviadas

  FROM partereparacion WHERE fechaLlegada > 20170000 GROUP BY MONTH(fechaLlegada)");

	$result = $mysqli->query($query);

	$data = array();

	foreach ($result as $row) { $data[] = $row;}

	$result->close();
	$mysqli->close();
	print json_encode($data);
}
