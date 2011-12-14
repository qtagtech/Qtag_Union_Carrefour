<?php
include_once('../include/session.php');
include_once('../include/database.php');

$id = $_POST[id];
$response = $database->deleteImage($id);
if($response==1) echo 'Muy bien';
else echo $response;

?>