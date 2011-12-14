<?php
include_once ('../include/session.php');
include_once ('../include/database.php');

$n = $_POST[name];
$r = $_POST[ruta];
$d = $_POST[desc];

$response = $database-> saveImage($n,$r,$d);
if($response == 1) echo "Muy Bien";
else echo $response;
?>