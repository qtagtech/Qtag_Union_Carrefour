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
	<div id="box2">
	
	<div id="library">
<div id="search">
<form id="searchForm">
<input type="text" title="Buscar por título" name="byTitle" />
<input type="text" title="Buscar por palabras clave" name="byKeyWords" />
<input type="text" title="Buscar por descripción" name="byDescription" />
</form>
</div>
	<table summary="" >
<thead>
<tr>
<th colspan="2">Biblioteca Virtual</th>
</tr>
<tr>
<th>Tipo de Documento</th>
<th>Nombre</th>

</tr>
</thead>
<tbody>
<tr>
<td><img src="images/pdf.png" alt="" ></td>
<td><a href="#" id="Estatutos_Union_de_Trabajadores_y_Trabjadoras_de_Grandes_Superficies_de_Colombia.pdf" class="file">Estatutos del Sindicato</a></td>

</tr>
<tr>
<td colspan="2" align="center"><a href="documentos/Estatutos_Union_de_Trabajadores_y_Trabjadoras_de_Grandes_Superficies_de_Colombia.pdf">Descargar</a></td>
</tr>
<tr>
<td><img src="images/pdf.png" alt="" ></td>
<td><a href="#" id="Acuerdo_UNI_Carrefour_creacion sindicato.pdf" class="file">Acuerdo Creación del Sindicato</a></td>
</tr>
<tr>
<td colspan="2" align="center"><a href="documentos/Acuerdo_UNI_Carrefour_creacion sindicato.pdf">Descargar</a></td>
</tr>
<tr>
<td><img src="images/ppt.png" alt="" ></td>
<td><a href="#" id="presentacion_Eduardo_Perez_de_San_Roman_UNI_oct_31_Bogota_FINAL.ppt" class="file">Presentación Eduardo Pérez San Roman</a></td>
</tr>
<tr>
<td colspan="2" align="center"><a href="documentos/presentacion_Eduardo_Perez_de_San_Roman_UNI_oct_31_Bogota_FINAL.ppt">Descargar</a></td>
</tr>

<tr>
<td><img src="images/ppt.png" alt="" ></td>
<td><a href="#" id="Presentacion_Estatutos_de_la_Union.ppt" class="file">Presentación Estatutos de la Unión</a></td>
</tr>
<tr>
<td colspan="2" align="center"><a href="documentos/Presentacion_Estatutos_de_la_Union.ppt">Descargar</a></td>
</tr>
<tr>
<td><img src="images/ppt.png" alt="" ></td>
<td><a href="#" id="presentacion_Ruben_Cortina_UNI_oct_31 Bogota.ppt" class="file">Presentación Rubén Cortina</a></td>
</tr>
<tr>
<td colspan="2" align="center"><a href="documentos/presentacion_Ruben_Cortina_UNI_oct_31 Bogota.ppt">Descargar</a></td>
</tr>
<tr>
<td><img src="images/ppt.png" alt="" ></td>
<td><a href="#" id="UNI-Carrefour-sp.pdf" class="file">Reunión Carrefour - UNI</a></td>
</tr>
<tr>
<td colspan="2" align="center"><a href="documentos/UNI-Carrefour-sp.pdf">Descargar</a></td>
</tr>


<td><a href="#" id=""></a></td>

<td><a href="#" id=""></a></td>
<td><a href="#" id=""></a></td>
<td><a href="#" id=""></a></td>
</tr>
</tbody>
</table>	
	</div>
		<div id="longtext">
			<iframe id="documentView" src="http://docs.google.com/gview?url=http://www.unioncolombia.com/documentos/Estatutos_Union_de_Trabajadores_y_Trabjadoras_de_Grandes_Superficies_de_Colombia.pdf&embedded=true" style="width:600px; height:488px;" frameborder="0"></iframe>
		</div>
		</div>
		
	</div>
	

<div id="footer">
	
</div>
<!-- end #footer -->
<script type="text/javascript" >
$("#searchForm").formerize();
$(".file").click(function(){
	var fileName = $(this).attr("id");
$("#documentView").attr("src","http://docs.google.com/gview?url=http://www.unioncolombia.com/documentos/"+fileName+"&embedded=true");
return false;
	});
</script>
</body>
</html>
