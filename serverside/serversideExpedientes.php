<?php
require 'serverside.php';
$table_data->get('vista_expedientes', 'idexpediente', array('idexpediente', 'dnidenunciante','denunciado','fechadeentrada','fechadesalida','causa','medida','fojas','librodeactas','codigocomisaria','numerodeexpediente'));
?>	