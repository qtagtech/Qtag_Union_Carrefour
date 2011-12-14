<?php
/**
 * Admin.php
 *
 * This is the Admin Center page. Only administrators
 * are allowed to view this page. This page displays the
 * database table of users and banned users. Admins can
 * choose to delete specific users, delete inactive users,
 * ban users, update user levels, etc.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
include("../include/session.php");

function displayArticles(){
   global $database;
   $q = "SELECT ".TBL_ARTICLES.".id,autor,titulo,subtitulo,seccion,timestamp, categorias.nombre as categ FROM ".TBL_ARTICLES." LEFT JOIN categorias on categorias.id = seccion ORDER BY timestamp DESC";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo '<p class="msg error">Error mostrando informaci&oacute;n</p>';
      return;
   }
   if($num_rows == 0){
      echo '<p class="msg info">No hay usuarios registrados en la base de datos.</p>';
      return;
   }
   /* Display table contents */
   $hoy = new DateTime();
   echo '<table>';
   echo "<tr><th>T&iacute;tulo</th><th>Autor</th><th>Secci&oacute;n</th><th>Fecha de Creaci&oacute;n</th><th>Editar</th><th>Borrar</th></tr>\n";
   for($i=0; $i<$num_rows; $i++){
   	$id = mysql_result($result, $i, "id");
      $titulo  = mysql_result($result,$i,"titulo");
      $titulo = strip_tags($titulo, $allowable_tags = null);
      $autor = mysql_result($result,$i,"autor");
      $seccion  = mysql_result($result,$i,"categ");
      $time  = new DateTime(date('Y-m-d',mysql_result($result,$i,"timestamp")));
      $time = $time->format('Y-m-d');
     
      
      
	if($i % 2 == 0)
      echo "<tr class=\"bg\">";
    else
    	echo "<tr>";
    
   echo "<td><a href='../article.php?id=$id' target='_blank'>$titulo</a></td><td>$autor</td><td>$seccion</td><td>$time</td><td><img style='cursor:pointer;' class='edit' id='$id' src='/images/pencil_edit.png' ></td><td><img class='delete' style='cursor:pointer;' id='$id' src='/images/close_delete_2.png'></td>";
	echo "</tr>\n";   
   }
   echo "</table><br>\n";
}
   
/**
 * User not an administrator, redirect to main page
 * automatically.
 */
if(!$session->isAdmin()){
   header("Location: ../index.php");
}
else{
/**
 * Administrator is viewing page, so display all
 * forms.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/reset.css" /> <!-- RESET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/main.css" /> <!-- MAIN STYLE SHEET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/2col.css" title="2col" /> <!-- DEFAULT: 2 COLUMNS -->
	<link rel="alternate stylesheet" media="screen,projection" type="text/css" href="css/1col.css" title="1col" /> <!-- ALTERNATE: 1 COLUMN -->
	<!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="css/main-ie6.css" /><![endif]--> <!-- MSIE6 -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/style.css" /> <!-- GRAPHIC THEME -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/mystyle.css" /> <!-- WRITE YOUR CSS CODE HERE -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/switcher.js"></script>
	<script type="text/javascript" src="js/toggle.js"></script>
	<script type="text/javascript" src="js/ui.core.js"></script>
	<script type="text/javascript" src="js/ui.tabs.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".tabs > ul").tabs();
	});
	</script>
	<script type="text/javascript" >
$(document).ready(function(){
	$(".delete").click(function(){
		var id = $(this).attr("id");
		if(confirm('¿Seguro quieres borrar el artículo?'))
		{
			$.post("/admin/deleteArticle.php", { id: id }, function(data){
		
		if( (data) && (data != "ERROR"))
		{
			
			window.location.reload();
			
		}
		else
		{
			alert("Hubo algún error guardando el artículo, intpentalo de nuevo por favor.")
		}
	});
		}
				
		});
		
	$(".edit").click(function(){
		window.location = 'edit.php?id='+$(this).attr('id');		
		});
	});

</script>
	<title>Secci&oacute;n de Administraci&oacute;n Uni&oacute;n de trabajadores Carrefour Colombia:: Artículos</title>
</head>

<body>

<div id="main">

	<!-- Tray -->
	<div id="tray" class="box">

		<p class="f-left box">

			<!-- Switcher -->
			<span class="f-left" id="switcher">
				<a href="#" rel="1col" class="styleswitch ico-col1" title="Display one column"><img src="design/switcher-1col.gif" alt="1 Column" /></a>
				<a href="#" rel="2col" class="styleswitch ico-col2" title="Display two columns"><img src="design/switcher-2col.gif" alt="2 Columns" /></a>
			</span>

			Administraci&oacute;n: <strong>Uni&oacute;n de trabajadores Carrefour Colombia</strong>

		</p>

		<p class="f-right">Usuario: <strong><a href="#"><? echo $session->username; ?></a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><a href="#" id="logout">Salir</a></strong></p>

	</div> <!--  /tray -->

	<hr class="noscreen" />

	<!-- Menu -->
	<div id="menu" class="box">

		<ul class="box f-right">
			<li><a href="../index.php" target="_blank"><span><strong>Ir al sitio &raquo;</strong></span></a></li>
		</ul>

		<ul class="box">
			<li id="menu-active"><a href="index.php"><span>Inicio</span></a></li> <!-- Active -->
			
			<li><a href="#"><span>Secci&oacute;n Usuarios</span></a></li>
            <li><a href="articles.php"><span>Administración de Noticias</span></a></li>            	
			<li><a href="biblioteca.php"><span>Biblioteca Virtual</span></a></li>
			<li><a href="gallery.php"><span>Galer&iacute;a de Im&aacute;genes</span></a></li>
			<li><a href="glosario.php"><span>Glosario Sindical</span></a></li>
			
		</ul>

	</div> <!-- /header -->

	<hr class="noscreen" />

	<!-- Columns -->
	<div id="cols" class="box">

		<!-- Aside (Left Column) -->
		<div id="aside" class="box">

			<div class="padding box">

				<!-- Logo (Max. width = 200px) -->
				<p id="logo"><a href="#"><img src="tmp/logo-union_02.jpg" alt="Our logo" title="Ir al Sitio" /></a></p>

				<!-- Search -->
				

				<!-- Create a new project -->
				<p id="btn-create" class="box"><a href="news.php"><span>Crear una nueva noticia.</span></a></p>

			</div> <!-- /padding -->

			<ul class="box">
				<li><a href="#" >Administrar Usuarios</a>
				<ul>
						<li><a href="index.php">Usuarios Afiliados al Sindicato</a></li>
						<li><a href="active.php">Usuarios Conectados</a></li>
						<li><a href="#">Invitados Conectados</a></li>
						<li><a href="#">Otras Acciones</a></li>
						
					</ul>				
				</li>
				<li><a href="biblioteca.php">Biblioteca de documentos</a></li>
                <li id="submenu-active"><a href="articles.php">Administraci&oacute;n de Noticias</a></li>
                    <ul>
                        <li><a href="news.php">Escribir Noticias</a></li>
                        <li><a href="uploadFile.php">Subir Archivos</a></li>
                    </ul>                
				<li><a href="gallery.php">Galer&iacute;a de im&aacute;genes</a></li>
                	<ul>
                    	<li><a href="imageList.php">Borrar Im&aacute;genes</a></li>
                    </ul>
				<li><a href="glosario.php">Glosario Sindical</a> </li>
				
			</ul>

		</div> <!-- /aside -->

		<hr class="noscreen" />

		<!-- Content (Right Column) -->
		<div id="content" class="box">

			<h1>Bienvenido a la administraci&oacute;n del sitio de la Uni&oacute;n de trabajadores de Carrefour Colombia</h1>

			<!-- Headings -->
			<h2>Seleccione alguna de las opciones del men&uacute; de la izquierda para administrar el sitio.</h2>
			

			<!-- System Messages -->
			

			<!-- Tabs -->
			

			<div class="tabs box">
				<ul>
					<li><a href="#tab01"><span>Listado de art&iacute;culos</span></a></li>
					<li><a href="#tab02"><span>Art&iacute;culos publicados</span></a></li>
					
				</ul>
			</div> <!-- /tabs -->

			<!-- Tab01 -->
			<div id="tab01">
			
				<? displayArticles(); ?>
				
			
			</div> <!-- /tab01 -->

			<!-- Tab02 -->
			<div id="tab02">
<p><h3 class="tit">Seleccione el art&iacute;culo que debe ir en cada una de las posiciones del sitio</h3></p>
				



			</div> <!-- /tab02 -->

			<!-- Tab03 -->
			 <!-- /tab03 -->

			<!-- 2 columns -->
			
			

			

			

			<!-- 3 columns -->
			
			
			
			
			

			<!-- Text Alignment -->

			

			<!-- Size and Highlight -->
			

			<!-- Unordered List -->
			
			<!-- Unordered List -->
			
			

			<!-- Ordered List (OL) -->
			

			<!-- Table -->
			
			
			<!-- Table (TABLE) -->
			
			

			<!-- Form -->
			
			

			<!-- Definition List -->
			
			

			<!-- Definition List -->
			
			

		</div> <!-- /content -->

	</div> <!-- /cols -->

	<hr class="noscreen" />

	<!-- Footer -->
	<div id="footer" class="box">

		<p class="f-left">&copy; 2011 <a href="#">Uni&oacute;n de trabajadore Carrefour colombia</a>, Todos los derechos reservados &reg;</p>
		
		<p class="f-left">Powered by <a href="http://www.qtagtech.com" target="_blank">Qtag Technologies</a> </p>

		<p class="f-right">Templates by <a href="http://www.adminizio.com/">Adminizio</a></p>

	</div> <!-- /footer -->

</div> <!-- /main -->

</body>
</html>
<?php
}
?>