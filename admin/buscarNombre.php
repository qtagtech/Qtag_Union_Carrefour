<?php
include_once ('../include/session.php');
include_once ('../include/database.php');

$d = $_REQUEST[buscar];
$response = $database->buscarNombre($d);
while($act = mysql_fetch_array($response))
{
	$info[] = array ('nombre' => $act[name], 'apellido' => $act[lastname], 'username' => $act[username], 'userid' => $act[userid], 'userlevel' => $act[userlevel], 'email' => $act[email], 'age' => $act[age], 'documenttype' => $act[documenttype], 'documento' => $act[document], 'genero' => $act[gender], 'direccion' => $act[address], 'celular' => $act[mobile], 'facebook' => $act[facebook], 'twitter' => $act[twitter], 'tienda' => $act[store], 'ciudad' => $act[city], 'notificaciones' => $act[notifications]);
}
echo json_encode($info);
?>