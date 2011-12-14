<?php
include_once ('include/session.php');
include_once ('include/database.php');

$id = $_POST[id];


$response = $database->deleteUserArticle($id);
if($response == 1) echo "Muy Bien";
else echo $response;
?>