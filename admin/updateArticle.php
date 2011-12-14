<?php
include_once ('../include/session.php');
include_once ('../include/database.php');

$t = $_POST[title];
$c = $_POST[content];
$id = $_POST[id];
$response = $database->updateArticle($t,$c,$id);
if($response == 1) echo "Muy Bien";
else echo $response;
?>