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
include("include/session.php");


$id = $_GET['id'];

global $database;
   $q = "SELECT id,titulo,texto FROM user_Articles WHERE id='$id'";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if($result || (!$num_rows < 0)){
      
     if(!$num_rows == 0){
		
     $titulo  = mysql_result($result,$i,"titulo");
 		$content  = mysql_result($result,$i,"texto");
   }
   }
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	<link rel="stylesheet" media="screen,projection" type="text/css" href="admin/css/reset.css" /> <!-- RESET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="admin/css/main.css" /> <!-- MAIN STYLE SHEET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="admin/css/2col.css" title="2col" /> <!-- DEFAULT: 2 COLUMNS -->
	<link rel="alternate stylesheet" media="screen,projection" type="text/css" href="admin/css/1col.css" title="1col" /> <!-- ALTERNATE: 1 COLUMN -->
	<!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="css/main-ie6.css" /><![endif]--> <!-- MSIE6 -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="admin/css/style.css" /> <!-- GRAPHIC THEME -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="admin/css/mystyle.css" /> <!-- WRITE YOUR CSS CODE HERE -->
	<script type="text/javascript" src="admin/js/jquery.js"></script>
	<script type="text/javascript" src="admin/js/switcher.js"></script>
	<script type="text/javascript" src="admin/js/toggle.js"></script>
	<script type="text/javascript" src="admin/js/ui.core.js"></script>
	<script type="text/javascript" src="admin/js/ui.tabs.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".tabs > ul").tabs();
	});
	</script>
	<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="admin/js/noticias.js"></script>
<script src="/javascripts/jquery.flash.js"></script>

<script type="text/javascript" >
$(document).ready(function(){
$("#updateUserNews").click(function(){
	var titulo = $("#titleEditor").val();
	var content = $("#textEditor").val();
	var id = $("#idUserArticle").val();
	validate(titulo,content,function(valido,msj){
		if(valido)
		{
			$("#loading").show(50);
			updateUserArticle(titulo,content,id,function(data){
				$("#loading").hide(20);
				if(confirm("Artículo actualizado con éxito. \n Si deseas publicarlo ahora, presiona aceptar, de lo contrario presiona cancelar y serás llevado al inicio del panel de administración."))
				{
					window.location = "userArticles.php";
				}
				else
				{
					window.location = "index.php";
				}
								
				});
		}
		else
		{
			alert(msj);
		}
		})
	return false;	
	});
	});
	function updateUserArticle(tit,cont,id,f)
	{
	
	$.post("updateUserArticle.php", { title: tit, content: cont, id : id }, function(data){
		
		if( (data) && (data != "ERROR"))
		{
			
			if (typeof f == "function") f(data)
			
		}
		else
		{
			alert("Hubo algún error guardando el artículo, intentalo de nuevo por favor.")
		}
	});
	};
</script>

	<title>Secci&oacute;n de Edici&oacute;n de Art&iacute;culos publicados :: Editar</title>
</head>

<body>

<div id="main">

	<!-- Tray -->
	<div id="tray" class="box">

		<p class="f-left box">

			<!-- Switcher -->
			<span class="f-left" id="switcher">
				<a href="#" rel="1col" class="styleswitch ico-col1" title="Display one column"><img src="admin/design/switcher-1col.gif" alt="1 Column" /></a>
				<a href="#" rel="2col" class="styleswitch ico-col2" title="Display two columns"><img src="admin/design/switcher-2col.gif" alt="2 Columns" /></a>
			</span>

			<strong>Uni&oacute;n de trabajadores Carrefour Colombia :: Edici&oacute;n de Art&iacute;culos.</strong>

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
			
			<li><a href="quienes.php"><span>Quienes Somos</span></a></li>
            <li><a href="mundo.php"><span>Trabajadores en el Mundo</span></a></li>
			<li><a href="biblioteca.php"><span>Biblioteca Virtual</span></a></li>
			<li><a href="usersGallery.php"><span>Galer&iacute;a de Im&aacute;genes</span></a></li>
			<li><a href="userArticles.php"><span>Noticias</span></a></li>
            <li><a href="#"><span>Glosario Sindical</span></a></li>
            <li><a href="contacto.php"><span>Danos tu Opinión</span></a></li>
			
		</ul>

	</div> <!-- /header -->

	<hr class="noscreen" />

	<!-- Columns -->
	<div id="cols" class="box">

		<!-- Aside (Left Column) -->
		<div id="aside" class="box">

			<div class="padding box">

				<!-- Logo (Max. width = 200px) -->
				<p id="logo"><a href="#"><img src="admin/tmp/logo-union_02.jpg" alt="Our logo" title="Ir al Sitio" /></a></p>

				<!-- Search -->
				<form action="#" method="get" id="search">
					<fieldset>
						<legend>Buscar</legend>

						<p><input type="text" size="17" name="" class="input-text" />&nbsp;<input type="submit" value="Buscar" class="input-submit-02" /><br />
						<a href="javascript:toggle('search-options');" class="ico-drop">B&uacute;squeda Avanzada</a></p>

						<!-- Advanced search -->
						<div id="search-options" style="display:none;">

							<p>
								<label><input type="checkbox" name="" checked="checked" /> Buscar por T&iacute;tulo.</label><br />
								<label><input type="checkbox" name="" /> Buscar por Palabras Clave.</label><br />
								<label><input type="checkbox" name="" /> Buscar por Descripci&oacute;n.</label>
							</p>

						</div> <!-- /search-options -->

					</fieldset>
				</form>

				<!-- Create a new project -->
				

			</div> <!-- /padding -->
            <ul class="box">
				<li id="submenu-active"><a href="#" >Noticias</a>
					<ul>
						<li><a href="userNews.php">Crear nueva noticia</a></li>					
					</ul>				
				</li>			
			</ul>

		</div> <!-- /aside -->

		<hr class="noscreen" />

		<!-- Content (Right Column) -->
		<div id="content" class="box">

			<h1>En esta sección podrá escribir y publicar noticias.</h1>

			<!-- Headings -->
			<h2>Escribir nuevo Art&iacute;culo</h2>
			

			<!-- System Messages -->
			

			
			<div class="box">
			
				
			<form method="post">
		<p>
			<br />
			<textarea id="titleEditor" name="newsTitle"><?php echo $titulo;?></textarea>
			<textarea id="textEditor" name="newsContent"><?php echo $content;?></textarea>
            <input type="hidden" name="idUserArticle" value="<?php echo $id;?>" id="idUserArticle" />
			
		</p>
		<p>
			<input type="submit" id="updateUserNews" /><div id="loading" style="display:none;"><img src="/images/ajax-loader.gif" alt="Guardando Artículo. Espere por favor" ></div>
		</p>
	</form>
			
			</div> 

			
			

			<!-- Tab03 -->
			

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

		<p class="f-left">&copy; 2011 <a href="#">Uni&oacute;n de trabajadores Carrefour colombia</a>, Todos los derechos reservados &reg;</p>
		
		<p class="f-left">Powered by <a href="http://www.qtagtech.com" target="_blank">Qtag Technologies</a> </p>

		<p class="f-right">Templates by <a href="http://www.adminizio.com/">Adminizio</a></p>

	</div> <!-- /footer -->

</div> <!-- /main -->

</body>
</html>