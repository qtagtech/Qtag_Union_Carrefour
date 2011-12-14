$(document).ready(function(){
	$("#submitImage").click(function(){
	var name = $("#txtNom").val();
	var ruta = $("#ruta").val();
	var desc = $("#txtDes").val();	
	validate(name, ruta, desc, function(valido, msj){
		if(valido)
		{			
			saveImage(name, ruta, desc, function(data){
				$("#loading").show(20);
				if(confirm("Imágen guardada con éxito."))
				{
					window.location = "gallery.php";
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
		}
	)
	return false;
});
});// JavaScript Document
function validate (name, ruta, desc, f)
{
	var bien = true;
	var msj = "";
	if(name == "") { bien = false; msj = "El nombre no puede estar vacÃ­o."};
	if(ruta == "") { bien = false; msj = "La ruta del archivo no puede estar vacía."};
	if(desc == "") { bien = false; msj = "La descripción de la imágen no puede estar vacía."};	
	
	if (typeof f == "function") f(bien,msj);
};
	
function saveImage(name, ruta, desc, f)
{
	$.post("/admin/saveImage.php", {name: name, ruta: ruta, desc: desc },  function(data){
		if( (data) && (data != "ERROR"))
		{
			if(typeof f == "function") f(data)
		}
		else
		{
			alert("Hubo algÃºn error guardando el artÃ­culo, intentalo de nuevo por favor.")
		}
	});
};