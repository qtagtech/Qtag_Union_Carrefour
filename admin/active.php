<?
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

 /**
   * getCity() - Trae la ciudad de un usuario con base en el id de la misma desde ciudades.php
	*/
	function getCity($id = -1)
	{
		$cities = file_get_contents('../ciudades.txt');
		$cities = json_decode($cities);
		//print_r($cities->ciudades[0]);
		$i = 0;
		
		while($i < count($cities->ciudades))
		{
			if($cities->ciudades[$i]->ID == $id)
			{
				$nombre = $cities->ciudades[$i]->NOMBRE;
				break;
			}
			$i++;
		}
		return $nombre;
		
	}

/**
 * displayUsers - Displays the users database table in
 * a nicely formatted html table.
 */
function displayOnlineUsers(){
   global $database;
   $q = "SELECT ".TBL_ACTIVE_USERS.".username, users.city AS city FROM ".TBL_ACTIVE_USERS." LEFT JOIN users ON ".TBL_ACTIVE_USERS.".username = users.username ORDER BY ".TBL_ACTIVE_USERS.".timestamp DESC , username";

   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo '<p class="msg error">Error mostrando informaci&oacute;n</p>';
      return;
   }
   if($num_rows == 0){
      echo '<p class="msg info">No hay usuarios en la p&aacute;gina actualmente.</p>';
      return;
   }
   /* Display table contents */
   $hoy = new DateTime();
   echo '<table>';
   echo "<tr><th>Nombre de Usuario</th><th>Ciudad</th></tr>\n";
   for($i=0; $i<$num_rows; $i++){
      $uname  = mysql_result($result,$i,"username");
      
      $ciudad = getCity(mysql_result($result,$i,"city"));
      
      
      
	if($i % 2 == 0)
      echo "<tr class=\"bg\">";
    else
    	echo "<tr>";
    
   echo "<td>$uname</td><td>$ciudad</td>";
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
		var datos = $("#value").val();
		var action;
	$("#buscar").click(function(e){
		e.preventDefault();
		var action;
		var datos = $("#value").val();		
		$('.chkBuscar').each(function(){
			if ($(this).is(':checked'))
			{
				action = $(this).attr('id');
			}
			});
			var url; /* ="buscarCedula.php";
			switch (action)
			{
				case 'name': 
					url = "buscarNombre.php";
				break;
				case 'id':
					url = "buscarId.php";
				break;
				
			}*/
			if(action == "buscarNombre")
			{
				url = "buscarNombre.php";				
			}
			else
			{		
				url = "buscarCedula.php";				
			}
			searchUsers(url,datos,function(info){							
				var html = '<table><tr><th>Nombres</th><th>Apellidos</th><th>Nombre de Usuario</th><th>Id de Usuario</th><th>Nivel</th><th>Email</th><th>Age</th><th>Tipo Documento</th><th>N&uacute;mero Documento</th><th>G&eacute;nero</th><th>Direcci&oacute;n</th><th>Tel&eacute;fono Celular</th><th>Usuario Facebook</th><th>Usuario Twitter</th><th>Tienda</th><th>Ciudad</th><th>&iquest;Recibe Emails?</tr>\n';
				  
				var i = 0;
				while(i < info.length)
				{				
					html += '<tr><td>'+info[i].nombre+'</td><td>'+info[i].apellido+'</td><td>'+info[i].username+'</td><td>'+info[i].userid+'</td><td>'+info[i].userlevel+'</td><td>'+info[i].email+'</td><td>'+info[i].age+'</td><td>'+info[i].documenttype+'</td><td>'+info[i].documento+'</td><td>'+info[i].genero+'</td><td>'+info[i].direccion+'</td><td>'+info[i].celular+'</td><td>'+info[i].facebook+'</td><td>'+info[i].twitter+'</td><td>'+info[i].tienda+'</td><td>'+info[i].ciudad+'</td><td>'+info[i].notificaciones+'</td>';
					i++;			
				}
				html += '</table>';
				$("#tab01").html(html);
				});
				
			return false;
		
		});		
	});
	function searchUsers(url, datos, f)
	{
		console.log(datos);
		$.post (url, {buscar: datos}, function(data){
			if ((data))
			{
				var info = jQuery.parseJSON(data);
				//console.log(info.name)
				if(typeof f == "function") f(info);
			}
			else
			{
				alert("Hubo algún error al buscar el usuario. Intentalo de nuevo por favor");
			}
		});
		
	};
	</script>
	<title>Secci&oacute;n de Administraci&oacute;n Uni&oacute;n de trabajadores Carrefour Colombia :: Usuarios OnLine</title>
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
            <li><a href="articles.php"><span>Administración de Noticias</span></a></li>
			<li><a href="biblioteca.php"><span>Biblioteca Virtual</span></a></li>
			<li><a href="gallery.php"><span>Galer&iacute;a de Im&aacute;genes</span></a></li>
			<li><a href="#"><span>Glosario Sindical</span></a></li>
			
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
				<form action="#" method="get" id="search">
					<fieldset>
						<legend>Buscar Usuarios</legend>

						<p><input type="text" id="value" size="17" value="Buscar por Cedula" name="" class="input-text" />&nbsp;<input type="submit" id="buscar"value="Buscar" class="input-submit-02" /><br />
						<a href="javascript:toggle('search-options');" class="ico-drop">B&uacute;squeda Avanzada</a></p>

						<!-- Advanced search -->
						<div id="search-options" style="display:none;">

							<p>
								<label><input type="checkbox" name="" class="chkBuscar" id="buscarNombre"/> Buscar por Nombre.</label><br />								
								
							</p>

						</div> <!-- /search-options -->

					</fieldset>
				</form>


				<!-- Create a new project -->
				<p id="btn-create" class="box"><a href="news.php"><span>Crear una nueva noticia.</span></a></p>

			</div> <!-- /padding -->

			<ul class="box">
				<li id="submenu-active"><a href="#" >Administrar Usuarios</a>
				<ul>
						<li><a href="index.php">Usuarios Afiliados al Sindicato</a></li>
						<li><a href="active.php">Usuarios Conectados</a></li>
						<li><a href="#">Invitados Conectados</a></li>
						<li><a href="#">Otras Acciones</a></li>
						
					</ul>				
				</li>
				<li><a href="biblioteca.php">Biblioteca de documentos</a></li>
                <li><a href="articles.php">Administraci&oacute;n de Noticias</a></li>
                	<ul>
                    	<li><a href="news.php">Escribir Noticias</a></li>
                        <li><a href="uploadFile.php">Subir Archivos</a></li>
                    </ul>
				<li><a href="gallery.php">Galer&iacute;a de im&aacute;genes</a></li>
                	<ul>	
                    	<li><a href="imageList.php">Borrar Im&aacute;genes</a></li>
                    </ul>
				<li><a href="#">Glosario Sindical</a> </li>
				
			</ul>

		</div> <!-- /aside -->

		<hr class="noscreen" />

		<!-- Content (Right Column) -->
		<div id="content" class="box">

			<h1>Administraci&oacute;n Sitio Uni&oacute;n de Trabajadores Carrefour Colombia</h1>

			<!-- Headings -->
			<h2>Administraci&oacute;n de usuarios OnLine</h2>
			

			<!-- System Messages -->
			

			
			<div class="box">
			
				
				<? displayOnlineUsers(); ?>
			
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