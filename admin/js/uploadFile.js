$(document).ready(function() {
	$("#submitFile").click(function(){
		var name = $("#txtNom").val();
		var ruta = $("#ruta").val();
		var desc = $("#txtDes").val();
		validate(name, ruta, desc, function(valido, msj){
			if(valido)
			{
				saveFile(name, ruta, desc, function(data){
					$("#loading").show(20);
					if(confirm ("Archivo subido con éxito!"))
					{
						window.location = "uploadFile.php";
					}
					else
					{
						window.location = "index.php"
					}
				});
			}
			else
			{
				alert(msj);
			}
		}
		)
		return false;
	});
    
});
function validate(name, ruta, desc, f)
{
	var bien = true;
	var msj = "";
	if(name == ""){bien = false; msj ="Debe ingresar el nombre del archivo"};
	if(ruta == ""){bien = false; msj = "La ruta del archivo no puede estar vac&iacute:a"};
	if(desc == ""){bien = false; msj = "Debe ingresar una descripción para el archivo"};
	
	if(typeof f == "function") f(bien, msj);
};

function saveFile(name, ruta, desc, f)
{
	$.post("/admin/saveFile.php", {name: name, ruta: ruta, desc: desc}, function(data){
		if( (data) && (data != "ERROR"))
		{
			if(typeof f == "function") f(data);
		}
		else
		{
			alert("Hubo algún error guardando el artículo, intentalo de nuevo por favor")
		}
	});
};
	
	
	
	
	
	
	
	
	
	
	
	