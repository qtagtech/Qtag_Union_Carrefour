<?php
include("include/session.php");
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
      echo "[<a href=\"admin/index.php\">Centro de Administraci&oacute;n</a>] &nbsp;&nbsp;";
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
		<li><a href="usersGallery.php"><img src="images/estructura-pagina_06.jpg" alt="Galería de Imágenes" border="0" ></a></li>
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
<div id="page" style="height:550px; padding-top:25px;background-color:#FFFFFF;">
	<div id="box" style="height:550px;">
		<div id="boxColumn1" style="height:550px;">
		<h2 id="title1">Af&iacute;liate al Sindicato</h2>
		<div id="image1"><img src="images/Carrefour-India2.jpg" id="imagen1" alt="" ></div>
		<p class="frontText" style="border-bottom: 1px solid #000000;"> <b>La Unión de Trabajadores y Trabajadoras de Grandes Superficies de Colombia S.A., Carrefour es una organización creada para la defensa de tus derechos en el trabajo y al trabajo, creada el 2 de noviembre de 2011.</b></p>		
		<p class="frontText">Su meta más importante es mejorar las condiciones de trabajo para los 10 mil trabajadoras y trabajadores de Carrefour en las tiendas del país</p><p class="frontText">

<a href="noticias_1.php">Ver m&aacute;s...</a>
		</div>
		<div id="boxColumn2" style="height:550px;">
		<h2 id="title2">Unión de trabajadoras y trabajadores de Carrefour Colombia, sindicato para el diálogo social</h2>
		<div id="innerbox1">
		<p class="frontText" style="color:red;font-style:italic;font-size:10px;">Con 122 afiliadas y afiliados, una presidenta mujer y una agenda laboral bastante amplia, se crea el sindicato de las trabajadoras y trabajadores de Carrefour en Colombia, con el apoyo de la Empresa y del sindicalismo internacional</p>		
	<div id="image1"><img src="images/foto_noticia.jpg" id="imagen1" alt="" ></div>	
	<p class="frontText">La Unión de Trabajadores y Trabajadoras de Grandes Superficies de Colombia S.A., Carrefour, es el sindicato creado el pasado 2 de noviembre de 2011 y fue creado con el visto bueno y el interés de la Empresa multinacional, además del apoyo del sindicato Global UNI y la Escuela Nacional Sindical.</p>		
		
		
		
		</div>
		<div id="innerbox2">
		<div id="image1"><img src="images/foto_noticia_2.jpg" id="imagen1" alt="" ></div>	
<p class="frontText">En un encuentro de tres días con los integrantes de los copasos de la empresa, representantes de los trabajadores al fondo de empleados de Carrefour y trabajadores con liderazgos</p>
		<p class="frontText"> reconocidos en cada uno de los almacenes, trabajadoras y trabajadores de las 72 tiendas y almacenes de la multinacional en Colombia votaron y formaron un sindicato, cuya agenda gira alrededor de reivindicaciones en el lugar de trabajo y el diálogo social.</p>		
		
		<p class="frontText" style="text-align:right;"><a href="noticias.php">Ver m&aacute;s...</a></p>		
		</div>		
		
		</div>
		<div id="boxColumn3" style="height:550px;">
		<h2 id="title3">Inf&oacute;rmate sobre el Sindicato</h2>
<p class="frontText2" style="font-size: 12px; line-height:1.1em; text-align:justify;">La Unión de Trabajadores y Trabajadoras de Grandes Superficies de Colombia S.A., Carrefour tiene para tí diversos insumos para que puedas enterarte de qué apoya el trabajo de los delegados. Visita <a href="biblioteca.php">acá</a>  y conoce los estatutos y otros documentos que apoyan el trabajo de la Unión.		</p>
		
		<div id="image1"><img src="images/color-books.jpg" id="imagen1" alt="" ></div>
		<h2 id="title1">Enlaces de inter&eacute;s</h2>				
		<a href="http://www.ens.org.co" target="_blank"><img src="images/LOGO-ENS.jpg" alt="" style="display:block; float:left; clear:none; margin-top: 5px; margin-left:15px;" ></a>
		<a href="http://www.uniglobalunion.org/Apps/iportal.nsf/pages/HOMEPAGEEs" target="_blank"><img src="images/LOGO-UNI.jpg" alt="" style="display:block; float:left; clear:none; margin-top:5px; margin-left:5px;" >	</a>	
		</div>
		
	</div>
	
</div>
<div id="footer">
	
</div>
<!-- end #footer -->
</body>
</html>
