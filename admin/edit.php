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


$id = $_GET['id'];

global $database;
   $q = "SELECT id,titulo,texto FROM ".TBL_ARTICLES." WHERE id='$id'";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if($result || (!$num_rows < 0)){
      
     if(!$num_rows == 0){
		
     $titulo  = mysql_result($result,$i,"titulo");
 		$content  = mysql_result($result,$i,"texto");
   }
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
	<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="js/noticias.js"></script>
<script src="/javascripts/jquery.flash.js"></script>

<script type="text/javascript" >
$(document).ready(function(){
$("#updateNews").click(function(){
	var titulo = $("#titleEditor").val();
	var content = $("#textEditor").val();
	var id = $("#idArticle").val();
	validate(titulo,content,function(valido,msj){
		if(valido)
		{
			$("#loading").show(50);
			updateArticle(titulo,content,id,function(data){
				$("#loading").hide(20);
				if(confirm("Artículo actualizado con éxito. \n Si deseas publicarlo ahora, presiona aceptar, de lo contrario presiona cancelar y serás llevado al inicio del panel de administración."))
				{
					window.location = "index.php";
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
</script>

	<title>Secci&oacute;n de Administraci&oacute;n Uni&oacute;n de trabajadores Carrefour Colombia :: Nuevo Artículo</title>
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

			Administraci&oacute;n: <strong>Uni&oacute;n de trabajadores Carrefour Colombia :: Usuarios OnLine</strong>

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
            <li><a href="articles.php"><span>Adiministración de Noticias</span></a></li>
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

			<h1>Administraci&oacute;n Sitio Uni&oacute;n de Trabajadores Carrefour Colombia</h1>

			<!-- Headings -->
			<h2>Escribir nuevo Art&iacute;culo</h2>
			

			<!-- System Messages -->
			

			
			<div class="box">
			
				
			<form method="post">
		<p>
			<br />
			<textarea id="titleEditor" name="newsTitle"><?php echo $titulo; ?></textarea>
			<textarea id="textEditor" name="newsContent"><?php echo $content; ?></textarea>
			<input type="hidden" name="idArticle" value="<?php echo $id; ?>" id="idArticle">
			
		</p>
		<p>
			<input type="submit" id="updateNews" /><div id="loading" style="display:none;"><img src="/images/ajax-loader.gif" alt="Guardando Artículo. Espere por favor" ></div>
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