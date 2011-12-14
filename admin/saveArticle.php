<?php
include_once ('../include/session.php');
include_once ('../include/database.php');

$t = $_POST[title];
$c = $_POST[content];

$response = $database->saveArticle($t,$c,$session->username);
if($response == 1) echo "Muy Bien";
else echo $response;
?>