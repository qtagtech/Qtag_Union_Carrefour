<?php
include("include/session.php");

$contact = isset($_POST['subcontact']) ? 1 : 0;
$sent =  false;
if($contact)
{
	$name = $_POST['nombre'];
	$email = $_POST['email'];
	$msj = $_POST['mensaje'];
	
	$mensaje  = " Mensaje enviado por: $name con dirección $email:<br><br>$msj.";
	
	$to = "unioncarrefourcolombia@gmail.com";
	
$headers .= "Reply-To: $name <$email>\r\n"; 
  $headers .= "Return-Path: Formulario web unioncolombia.com <no-reply@unioncolombia.com>\r\n"; 
  $headers .= "From: Formulario web unioncolombia.com <no-reply@unioncolombia.com>\r\n";
  $headers .= "Sindicato de Carrefour Colombia\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Bcc: $email\r\n"; 
  $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
if($msj != "")
{
   //send mail - $subject & $contents come from surfer input
   mail($to, 'Contacto via web - Unioncolombia.com', $mensaje, $headers);
   // redirect back to url visitor came from
   $sent = true;
}
 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Sindicato de Tabajadores y Trabajadoras de Carrefour Colombia</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jquery.poptrox-0.1.js"></script>
<script type="text/javascript" src="jquery.formerize/jquery.formerize-0.1.js"></script>
<script type="text/javascript" src="javascripts/cycles.js"></script>
</head>
<body>

<div id="header" class="container">
	<div id="logo">
		<div id="logo_i"><a href="index.php" id="linkLogo" ></a></div>
<div id="logo_c">
<?php
		if(!$session->logged_in): 
		?>
<img src="images/estructura-pagina_01B.jpg" alt="Usuario y Contraseña" >
<?php
else:
?>
&nbsp;
<?php
endif;
?>
</div>
<div id="logo_d">
<?php
if($session->logged_in){
  
   echo "Bienvenido <b>$session->username</b><br><br>";
   if($session->isAdmin()){
      echo "[<a href=\"admin/admin.php\">Centro de Administraci&oacute;n</a>] &nbsp;&nbsp;";
   }
   echo "[<a href=\"process.php\">Logout</a>]";
}
else{
?>
<form id="loginForm" action="process.php" method="POST">
<input type="text" id="userLogin" name="user">
<input type="password" id="passLogin" name="pass">
<input type="hidden" name="sublogin" value="1">
<input type="submit" value="" id="submitLogin">
</form>
<?php
}
?>
</div>

	</div>
</div>
<div id="menu">
	<ul>
		<li class="current_page_item"><a href="quienes.php" ><img src="images/estructura-pagina_02.jpg" alt="Quiénes Somos" border="0" ></a></li>
		<li><a href="afiliate.php"><img src="images/estructura-pagina_03.jpg" alt="Afíliate al Sindicato" border="0" ></a></li>
		<li><a href="mundo.php"><img src="images/estructura-pagina_04.jpg" alt="Trabajadores Carrefour en el Mundo" border="0" ></a></li>
		<li><a href="biblioteca.php"><img src="images/estructura-pagina_05.jpg" alt="Biblioteca Virtual" border="0" ></a></li>
		<li><img src="images/estructura-pagina_06.jpg" alt="Galería de Imágenes" border="0" ></li>
		<li><a href="index.php"><img src="images/estructura-pagina_07.jpg" alt="Noticias" border="0" ></a></li>
		<li><img src="images/estructura-pagina_08.jpg" alt="Glosario Sindical" border="0" ></li>
		<li><a href="contacto.php" ><img src="images/estructura-pagina_09.jpg" alt="Contacto" border="0" ></a></li>
	</ul>
</div>
<!-- end #header -->
<div id="splash"> 
<div class="main_view">
    <div class="window">
        <div class="image_reel">
            <a href="index.php"><img src="images/banner-1.jpg" alt="" /></a>
            <a href="afiliate.php"><img src="images/banner2.jpg" alt="" /></a>
            <a href="biblioteca.php"><img src="images/banner3.jpg" alt="" /></a>
            
        </div>
    </div>
   <div class="paging">
        <a href="#" rel="1" id="prev">Anterior</a>
        <a href="#" rel="2" id="next">Siguiente</a>
        
    </div>
</div>
</div>
<div id="page">
	<div id="box1">
	<?php
	if(!$sent)
	{
	?>
	<form id="contactForm" name="contactForm" action="contacto.php" method="POST">
	<?php
	if($session->logged_in)
	{
	?>
	<input type="hidden" name="nombre" value="<?=$session->usercname; ?>">
	<input type="hidden" name="email" value="<?=$session->email; ?>">
	<label id="contactPName"><?=$session->usercname; ?>, Com&uacute;nicate con nosotros:</label>
	<?php
	}
	else {
	?>
	<div id="contactName"><input type="text" name="nombre" value="" title="Nombre" ></div>
	<div id="contactEmail"><input type="text" name="email" value="" title="Email" ></div>
	<?php
	}
	?>
	<div id="contactMessage">
	<textarea rows="10" cols="50" name="mensaje" title="Escribe tu mensaje y comun&iacute;cate con el sindicato."></textarea>
	</div>
	<input type="hidden" name="subcontact" value="1">
	<div id="contactSubmit"><input type="submit" value="Enviar"></div>
	</form>
		<?php
		}
		
		else
		{
			?>
			<h2 style="color:#ffffff;margin-top:20px;"><?=$name; ?>, Muchas gracias por comunicarte con nosotros, una copia de tu mensaje ha sido enviada a tu correo: <?=$email; ?>. Te responderemos lo m&aacute;s pronto posible.</h2>
			<?php
		}
		?>
		
	</div>
	
</div>
<div id="footer">
	
</div>
<!-- end #footer -->
<script type="text/javascript" >
$("#contactForm").formerize();
</script>
</body>
</html>
