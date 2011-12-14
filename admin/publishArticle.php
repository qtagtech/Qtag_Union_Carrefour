<?php
include_once ('../include/session.php');
include_once ('../include/database.php');

$art = $_POST[art];
$pos = $_POST[pos];
$response = $database->publishArticle($art,$pos);
if($response == 1) echo "Muy Bien";
else echo $response;
?>