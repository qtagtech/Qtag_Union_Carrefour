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
<script type="text/javascript" src="jquery.formerize/jquery.formerize-0.1.js" ></script>

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
		<li><a href="afiliate.php"><img src="images/estructura-pagina_03.jpg" alt="Afíliate al Sindicato" ></a></li>
		<li><a href="mundo.php"><img src="images/estructura-pagina_04.jpg" alt="Trabajadores Carrefour en el Mundo" ></a></li>
		<li><a href="biblioteca.php"><img src="images/estructura-pagina_05.jpg" alt="Biblioteca Virtual" ></a></li>
		<li><img src="images/estructura-pagina_06.jpg" alt="Galería de Imágenes" ></li>
		<li><a href="index.php"><img src="images/estructura-pagina_07.jpg" alt="Noticias" ></a></li>
		<li><img src="images/estructura-pagina_08.jpg" alt="Glosario Sindical" ></li>
		<li><a href="contacto.php" ><img src="images/estructura-pagina_09.jpg" alt="Contacto" ></a></li>
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
if($session->logged_in){
   echo "<h2>Ya te encuentras afiliado</h2>";
   echo "<p>Lo sentimos<b>$session->username</b>, ya se ecnuentra registrado. "
       ."<a href=\"index.php\">Incio</a>.</p>";
}

else if(isset($_SESSION['regsuccess'])){
  //Registro exitoso
   if($_SESSION['regsuccess']){
      echo "<h2>Te has afiliado correctamente</h2>";
      echo "<p>Gracias<b>".$_SESSION['reguname']."</b>, tu informaci&oacute;n ha sido guardada correctamente, "
          ."ahora puedes <a href=\"index.php\">iniciar sesi&oacute;n</a>.</p>";
   }
   /* Error de registro */
   else{
      echo "<h2>Hubo errores en la afiliaci&oacute;n</h2>";
      echo "<p>Lo sentimos pero hubo errores en la afiliaci&oacute;n de <b>".$_SESSION['reguname']."</b>, "
          ."<br>Por favor intenta de nuevo m&aacute;s tarde.</p>";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);
}
else{
?>


<?php
if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(es) encontrados</font></td>";
}

?>
	<div id="afiliateForm">
		<form id="subscriptionForm" action="process.php" method="POST">
		<label>Para una inscripci&oacute;n v&aacute;lida, todos los campos deben estar completos.</label>
		<table summary="" >

<tr>
<td><input type="text" id="userName" title="Nombre de Usuario" name="user" maxlength="30" value="<? echo $form->value("user"); ?>"><? echo $form->error("user"); ?></td>
<td align="center"><input type="password" id="pass1"  title="Contrase&ntilde;a" name="pass" maxlength="30" value="<? echo $form->value("pass"); ?>"><? echo $form->error("pass"); ?></td>
<td><input type="password" id="pass2"  title="Repita Contrase&ntilde;a" name="pass" maxlength="30" value="<? echo $form->value("pass"); ?>"><? echo $form->error("pass"); ?></td>
</tr>
<tr>

<td><input type="text" id="userNombre"  title="Nombre" name="name" maxlength="60" value="<? echo $form->value("name"); ?>"><? echo $form->error("name"); ?></td>
<td align="center"><input type="text" id="userLast"  title="Apellidos" name="lastname" maxlength="30" value="<? echo $form->value("lastname"); ?>"><? echo $form->error("lastname"); ?></td>
<td></td>
</tr>
<tr>
<td>Fecha de nacimiento

</td>
<td align="center"><select name="fecha_nacimiento_d" id="fecha_nacimiento_d" style="margin-left: 4px;" >
    <option value="" label="Día"></option>
    <option value="1" label="1">1</option>
    <option value="2" label="2">2</option>
    <option value="3" label="3">3</option>
    <option value="4" label="4">4</option>
    <option value="5" label="5">5</option>
    <option value="6" label="6">6</option>
    <option value="7" label="7">7</option>
    <option value="8" label="8">8</option>
    <option value="9" label="9">9</option>
    <option value="10" label="10">10</option>
    <option value="11" label="11">11</option>
    <option value="12" label="12">12</option>
    <option value="13" label="13">13</option>
    <option value="14" label="14">14</option>
    <option value="15" label="15">15</option>
    <option value="16" label="16">16</option>
    <option value="17" label="17">17</option>
    <option value="18" label="18">18</option>
    <option value="19" label="19">19</option>
    <option value="20" label="20">20</option>
    <option value="21" label="21">21</option>
    <option value="22" label="22">22</option>
    <option value="23" label="23">23</option>
    <option value="24" label="24">24</option>
    <option value="25" label="25">25</option>
    <option value="26" label="26">26</option>
    <option value="27" label="27">27</option>
    <option value="28" label="28">28</option>
    <option value="29" label="29">29</option>
    <option value="30" label="30">30</option>
    <option value="31" label="31">31</option>
</select><select name="fecha_nacimiento_m" id="fecha_nacimiento_m">
    <option value="" label="Mes"></option>
    <option value="1" label="Enero">Enero</option>
    <option value="2" label="Febrero">Febrero</option>
    <option value="3" label="Marzo">Marzo</option>
    <option value="4" label="Abril">Abril</option>
    <option value="5" label="Mayo">Mayo</option>
    <option value="6" label="Junio">Junio</option>
    <option value="7" label="Julio">Julio</option>
    <option value="8" label="Agosto">Agosto</option>
    <option value="9" label="Septiembre">Septiembre</option>
    <option value="10" label="Octubre">Octubre</option>
    <option value="11" label="Noviembre">Noviembre</option>
    <option value="12" label="Diciembre">Diciembre</option>
</select><select name="fecha_nacimiento_a" id="fecha_nacimiento_a">
    <option value="" label="Año"></option>
    <option value="2000" label="2000">2000</option>
    <option value="1999" label="1999">1999</option>
    <option value="1998" label="1998">1998</option>
    <option value="1997" label="1997">1997</option>
    <option value="1996" label="1996">1996</option>
    <option value="1995" label="1995">1995</option>
    <option value="1994" label="1994">1994</option>
    <option value="1993" label="1993">1993</option>
    <option value="1992" label="1992">1992</option>
    <option value="1991" label="1991">1991</option>
    <option value="1990" label="1990">1990</option>
    <option value="1989" label="1989">1989</option>
    <option value="1988" label="1988">1988</option>
    <option value="1987" label="1987">1987</option>
    <option value="1986" label="1986">1986</option>
    <option value="1985" label="1985">1985</option>
    <option value="1984" label="1984">1984</option>
    <option value="1983" label="1983">1983</option>
    <option value="1982" label="1982">1982</option>
    <option value="1981" label="1981">1981</option>
    <option value="1980" label="1980">1980</option>
    <option value="1979" label="1979">1979</option>
    <option value="1978" label="1978">1978</option>
    <option value="1977" label="1977">1977</option>
    <option value="1976" label="1976">1976</option>
    <option value="1975" label="1975">1975</option>
    <option value="1974" label="1974">1974</option>
    <option value="1973" label="1973">1973</option>
    <option value="1972" label="1972">1972</option>
    <option value="1971" label="1971">1971</option>
    <option value="1970" label="1970">1970</option>
    <option value="1969" label="1969">1969</option>
    <option value="1968" label="1968">1968</option>
    <option value="1967" label="1967">1967</option>
    <option value="1966" label="1966">1966</option>
    <option value="1965" label="1965">1965</option>
    <option value="1964" label="1964">1964</option>
    <option value="1963" label="1963">1963</option>
    <option value="1962" label="1962">1962</option>
    <option value="1961" label="1961">1961</option>
    <option value="1960" label="1960">1960</option>
    <option value="1959" label="1959">1959</option>
    <option value="1958" label="1958">1958</option>
    <option value="1957" label="1957">1957</option>
    <option value="1956" label="1956">1956</option>
    <option value="1955" label="1955">1955</option>
    <option value="1954" label="1954">1954</option>
    <option value="1953" label="1953">1953</option>
    <option value="1952" label="1952">1952</option>
    <option value="1951" label="1951">1951</option>
    <option value="1950" label="1950">1950</option>
    <option value="1949" label="1949">1949</option>
    <option value="1948" label="1948">1948</option>
    <option value="1947" label="1947">1947</option>
    <option value="1946" label="1946">1946</option>
    <option value="1945" label="1945">1945</option>
    <option value="1944" label="1944">1944</option>
    <option value="1943" label="1943">1943</option>
    <option value="1942" label="1942">1942</option>
    <option value="1941" label="1941">1941</option>
    <option value="1940" label="1940">1940</option>
    <option value="1939" label="1939">1939</option>
    <option value="1938" label="1938">1938</option>
    <option value="1937" label="1937">1937</option>
    <option value="1936" label="1936">1936</option>
    <option value="1935" label="1935">1935</option>
    <option value="1934" label="1934">1934</option>
    <option value="1933" label="1933">1933</option>
    <option value="1932" label="1932">1932</option>
    <option value="1931" label="1931">1931</option>
    <option value="1930" label="1930">1930</option>
    <option value="1929" label="1929">1929</option>
    <option value="1928" label="1928">1928</option>
    <option value="1927" label="1927">1927</option>
    <option value="1926" label="1926">1926</option>
    <option value="1925" label="1925">1925</option>
    <option value="1924" label="1924">1924</option>
    <option value="1923" label="1923">1923</option>
    <option value="1922" label="1922">1922</option>
    <option value="1921" label="1921">1921</option>
    <option value="1920" label="1920">1920</option>
    <option value="1919" label="1919">1919</option>
    <option value="1918" label="1918">1918</option>
    <option value="1917" label="1917">1917</option>
    <option value="1916" label="1916">1916</option>
    <option value="1915" label="1915">1915</option>
    <option value="1914" label="1914">1914</option>
    <option value="1913" label="1913">1913</option>
    <option value="1912" label="1912">1912</option>
    <option value="1911" label="1911">1911</option>
    <option value="1910" label="1910">1910</option>
    <option value="1909" label="1909">1909</option>
    <option value="1908" label="1908">1908</option>
    <option value="1907" label="1907">1907</option>
    <option value="1906" label="1906">1906</option>
    <option value="1905" label="1905">1905</option>
    <option value="1904" label="1904">1904</option>
    <option value="1903" label="1903">1903</option>
    <option value="1902" label="1902">1902</option>
    <option value="1901" label="1901">1901</option>
    <option value="1900" label="1900">1900</option>
    <option value="1899" label="1899">1899</option>
    <option value="1898" label="1898">1898</option>
    <option value="1897" label="1897">1897</option>
    <option value="1896" label="1896">1896</option>
    <option value="1895" label="1895">1895</option>
    <option value="1894" label="1894">1894</option>
    <option value="1893" label="1893">1893</option>
    <option value="1892" label="1892">1892</option>
    <option value="1891" label="1891">1891</option>
    <option value="1890" label="1890">1890</option>
    <option value="1889" label="1889">1889</option>
    <option value="1888" label="1888">1888</option>
    <option value="1887" label="1887">1887</option>
    <option value="1886" label="1886">1886</option>
    <option value="1885" label="1885">1885</option>
    <option value="1884" label="1884">1884</option>
    <option value="1883" label="1883">1883</option>
    <option value="1882" label="1882">1882</option>
    <option value="1881" label="1881">1881</option>
    <option value="1880" label="1880">1880</option>
    <option value="1879" label="1879">1879</option>
    <option value="1878" label="1878">1878</option>
    <option value="1877" label="1877">1877</option>
    <option value="1876" label="1876">1876</option>
    <option value="1875" label="1875">1875</option>
    <option value="1874" label="1874">1874</option>
    <option value="1873" label="1873">1873</option>
    <option value="1872" label="1872">1872</option>
    <option value="1871" label="1871">1871</option>
    <option value="1870" label="1870">1870</option>
    <option value="1869" label="1869">1869</option>
    <option value="1868" label="1868">1868</option>
    <option value="1867" label="1867">1867</option>
    <option value="1866" label="1866">1866</option>
    <option value="1865" label="1865">1865</option>
    <option value="1864" label="1864">1864</option>
    <option value="1863" label="1863">1863</option>
    <option value="1862" label="1862">1862</option>
    <option value="1861" label="1861">1861</option>
    <option value="1860" label="1860">1860</option>
    <option value="1859" label="1859">1859</option>
    <option value="1858" label="1858">1858</option>
    <option value="1857" label="1857">1857</option>
    <option value="1856" label="1856">1856</option>
    <option value="1855" label="1855">1855</option>
    <option value="1854" label="1854">1854</option>
    <option value="1853" label="1853">1853</option>
    <option value="1852" label="1852">1852</option>
    <option value="1851" label="1851">1851</option>
    <option value="1850" label="1850">1850</option>
</select></td>
<td></td>
</tr>
<tr>
<td><select name="documentype" id="tipoDoc" >
		<option value="">Tipo de Documento</option>
		<option value="cc">Cédula de Ciudadanía</option>
		<option value="ce">Cédula de Extranjería</option>
		</select></td>
<td align="center"><input type="text" id="numeroDoc"  title="N&uacute;mero" name="document" maxlength="30" value="<? echo $form->value("document"); ?>"><? echo $form->error("document"); ?></td>
<td></td>
</tr>
<tr>
<td><select name="gender" id="genderSelect" >
		<option value="">Género</option>
		<option value="f">Femenino</option>		
		<option value="m">Masculino</option>		
		</select>	</td>
<td align="center"><input type="text" id="address"  title="Direcci&oacute;n Postal" name="address" maxlength="100" value="<? echo $form->value("address"); ?>"><? echo $form->error("address"); ?></td>
<td><input type="text" title="Celular" name="mobile" maxlength="30" value="<? echo $form->value("mobile"); ?>"><? echo $form->error("mobile"); ?></td>
</tr>
<tr>
<td><input type="text" title="Correo" id="email"  name="email" maxlength="50" value="<? echo $form->value("email"); ?>"><? echo $form->error("email"); ?></td>
<td align="center"><input type="text" id="userFacebook"  title="Usuario Facebook" name="facebook" maxlength="50" value="<? echo $form->value("facebook"); ?>"><? echo $form->error("facebook"); ?></td>
<td><input type="text" title="Usuario Twitter" name="twitter" maxlength="50" value="<? echo $form->value("twitter"); ?>"><? echo $form->error("twitter"); ?>	</td>
</tr>
<tr>
<td><input type="text" title="Almac&eacute;n" id="store"  name="store" maxlength="50" value="<? echo $form->value("store"); ?>"><? echo $form->error("store"); ?></td>
<td align="center"><input type="hidden" name="city" id="city" value="">		
		<select name="ciudad" id="ciudad">
    <option value="" label="Ciudad">Ciudad</option>
</select><? echo $form->error("city"); ?></td>
<td><input type="text" title="Cargo" name="position" maxlength="50" value="<? echo $form->value("position"); ?>"></td><td><? echo $form->error("position"); ?></td>
</tr>
<tr>
<td align="right"><input type="checkbox" name="terms" id="terms" value="1"></td>
<td>Acepto los T&eacute;rminos y Condiciones del Sitio</td>
<td></td>
</tr>
<tr>
<td align="right"><input type="checkbox" name="estatutos" id="estatutos" value="1"></td>
<td>Certifico que he le&iacute;do los estatutos del Sindicato <br>y deseo afiliarme al mismo<br> cumpliendo con sus principios y reglas.</td>
<td></td>
</tr>
<tr>
<td align="right"><input type="checkbox" checked="checked" value="1" name="notifications"></td>
<td>Deseo recibir notificaciones peri&oacute;dicas<br> del sitio web.</td>
<td><input type="submit" id="submitButton" value="Afiliarse" style="height: 20px;">	</td>
</tr>
<input type="hidden" name="subjoin" value="1">

</table>
</form>		
		
	
		<?php
		}
		?>
	</div>
	
</div>
<div id="footer">
	
</div>
<!-- end #footer -->
<script type="text/javascript" >
$("#subscriptionForm").formerize();

$(document).ready(function(){
        jQuery.getJSON('ciudades.php', function(data){
            var ciudades = data.ciudades || [];

            ciudades.splice(0, 0, {ID: '', NOMBRE: 'Seleccione'});
            ciudades.push({ID: '-1', NOMBRE: 'Otra Ciudad'});

            var ciudad = $('#ciudad')[0];
            ciudad.options.length = 0;
            jQuery.each(ciudades, function(){
                ciudad.options.add(new Option(this.NOMBRE, this.ID));
            });
        });
        
        $("#ciudad").change(function(){
        	var val = $(this).val();
				$("#city").val(val);        	
        	});
    
    
$("#submitButton").click(function(){
	
		var estatutos = $("#estatutos").is(':checked');
		var terms = $("#terms").is(':checked');
		
	if(!terms)
	{
		alert("Debes Aceptar los Términos y Condiciones");
		return false;
	}
	else
	{
		if(!estatutos)
		{
			alert("Debes haber leído los estatutos del sindicato.");
			return false;
			
		}
		else
		{
			
			//Validar todos los campos
			if($("#userName").val() == "Nombre de Usuario")
			{
				alert("No pusiste un nombre de usuario");
				return false;
			}
			if($("#userNombre").val() == "Nombre")
			{
				alert("No pusiste un nombre.");
				return false;
			}
			if($("#userLast").val() == "Apellidos")
			{
				alert("No pusiste tus apellidos.");
				return false;
			}
	
			if($("#numeroDoc").val() == "Número")
			{
				alert("No pusiste el número de tu documento");
				return false;
			}
			if($("#address").val() == "Dirección Postal")
			{
				alert("No pusiste la dirección.");
				return false;
			}
			if($("#store").val() == "Almacén")
			{
				alert("No pusiste el almacén al que perteneces.");
				return false;
			}
			
			return true;
		}
	}
		});    
    
    });
</script>
</body>
</html>
