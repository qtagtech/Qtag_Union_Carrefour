<?php
include_once('../include/database.php');
$format = isset($_POST[format]) ? $_POST[format] : 'csv';

switch($format) {
case 'csv': $addrs = exportCSV();
			echo $addrs;
			break; 	
	}
	
	function exportCSV() {
		global $database;  
		$csv_end = "
";  
		$csv_sep = ",";  
		$date = date('Y_m_d_H_i_s', time());
		$csv_file = "../reports/userReport_".$date.".csv";  
		$csv="";  
		$q="SELECT * from ".TBL_USERS."";  
		$res=$database->query($q);
		$csv .= "Nombre".$csv_sep."Apellidos".$csv_sep."Usuario".$csv_sep."Email".$csv_sep."Fecha de Nacimiento".$csv_sep."Tipo de Documento".$csv_sep."Número de Documento".$csv_sep."Género".$csv_sep."Dirección".$csv_sep."Celular".$csv_sep."Facebook".$csv_sep."Twitter".$csv_sep."Tienda".$csv_sep."Ciudad".$csv_sep."Posición".$csv_sep."Recibe Notificaciones".$csv_sep."Última vez activo".$csv_sep."Fecha de registro".$csv_sep.$csv_end;  
		while($row=mysql_fetch_array($res))  
		{  
			$activo = date('Y-m-d H:i:s',$row[timestamp]);
			$registro = date('Y-m-d H:i:s',$row[regtime]);
			$city = getCity($row[city]);
    		$csv.=$row[name].$csv_sep.$row[lastname].$csv_sep.$row['username'].$csv_sep.$row['email'].$csv_sep.$row[age].$csv_sep.$row[documenttype].$csv_sep.$row[document].$csv_sep.$row[gender].$csv_sep.$row[address].$csv_sep.$row[mobile].$csv_sep.$row[facebook].$csv_sep.$row[twitter].$csv_sep.$row[store].$csv_sep.$city.$csv_sep.$row[position].$csv_sep.$row[notifications].$csv_sep.$activo.$csv_sep.$registro.$csv_end;  
		}  
		//Generamos el csv de todos los datos  
		if (!$handle = fopen($csv_file, "w")) {  
    	echo "Cannot open file";  
    	exit;  
		}	  
		if (fwrite($handle, utf8_decode($csv)) === FALSE) {  
    		echo "Cannot write to file";  
    		exit;  
		}		  
	fclose($handle);
	return $csv_file;  
	}
	
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
?>