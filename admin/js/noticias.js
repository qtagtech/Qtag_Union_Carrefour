$(document).ready(function(){
	$( '#textEditor' ).ckeditor(
	{
	filebrowserBrowseUrl : '/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '/ckfinder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl : '/ckfinder/ckfinder.html?Type=Flash',
        filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
        height: '600px'
       
	}			
	);
	$( '#titleEditor' ).ckeditor(
	{
		toolbar : 'titleToolbar',
		width: '50%',
		height: '60px',
		toolbar: [
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','-','Undo','Redo' ] },
		{ name: 'styles', items : [ 'Styles','Format' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
		
	]
		
	});
			

$("#submitNews").click(function(){
	var titulo = $("#titleEditor").val();
	var content = $("#textEditor").val();
	validate(titulo,content,function(valido,msj){
		if(valido)
		{
			$("#loading").show(50);
			saveArticle(titulo,content,function(data){
				$("#loading").hide(20);
				if(confirm("ArtÃ­culo guardado con Ã©xito. \n Si deseas publicarlo ahora, presiona aceptar, de lo contrario presiona cancelar y serÃ¡s llevado al inicio del panel de administraciÃ³n."))
				{
					window.location = "publish.php";
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
	
	
	$("#submitUserNews").click(function(){
	var titulo = $("#titleEditor").val();
	var content = $("#textEditor").val();
	validate(titulo,content,function(valido,msj){
		if(valido)
		{
			$("#loading").show(50);
			saveUserArticle(titulo,content,function(data){
				$("#loading").hide(20);
				console.log(data);
				if(confirm("Artículo guardado con éxito. \n Si deseas publicarlo ahora, presiona aceptar, de lo contrario presiona cancelar y serás redireccionado a la págna de inicio"))
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
	

function validate(t,c,f){
	var bien = true;	
	var msj = "";
	if(t == "") { bien = false; msj = "El tÃ­tulo no puede estar vacÃ­o."};
	if(c == "") { bien = false; msj = "El contenido del artÃ­culo no puede estar vacÃ­o."};
	
	if (typeof f == "function") f(bien,msj);
	};

function saveArticle(tit,cont,f)
{
	
	$.post("/admin/saveArticle.php", { title: tit, content: cont }, function(data){
		
		if( (data) && (data != "ERROR"))
		{
			
			if (typeof f == "function") f(data)
			
		}
		else
		{
			alert("Hubo algÃºn error guardando el artÃ­culo, intentalo de nuevo por favor.")
		}
	});
};


function updateArticle(tit,cont,id,f)
{
	
	$.post("/admin/updateArticle.php", { title: tit, content: cont, id : id }, function(data){
		
		if( (data) && (data != "ERROR"))
		{
			
			if (typeof f == "function") f(data)
			
		}
		else
		{
			alert("Hubo algÃºn error guardando el artÃ­culo, intpentalo de nuevo por favor.")
		}
	});
};
function saveUserArticle(tit,cont,f)
{
	
	$.post("saveUserArticle.php", { title: tit, content: cont }, function(data){
		
		if( (data) && (data != "ERROR"))
		{
			
			if (typeof f == "function") f(data)
			
		}
		else
		{
			alert("Hubo algúnn error guardando el artículo, intentalo de nuevo por favor.")
		}
	});
};
