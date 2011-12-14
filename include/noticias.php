<?php


class Noticias
{
	var $cantidad;
	var $content;
	

//Constructor
	function Noticias($page)  
	{
		$positions;
		switch($page) 
		{
			case 'noticias': $positions[] = "noticias_left";
								$positions[] = "noticias_center";
								$positions[] = "noticias_right";
			break;
			
			
		}
		$this->getContent($positions);
	}	
	
	
	/**
	* getContent()
	* Trae todo el contenido de la noticia desde la base de datos
	*
	**/
	
	function getContent($positions)
	{
		global $database;
		
		$news = $database->getPositions($positions);
		$this->cantidad = count($news);
		$this->content = $news;	
	}
	function summary($position,$length) {
		
		$content = $this->content[$position][texto];
				
		$end = '...';
	// Clean and explode our content, Strip all HTML tags, and special charactors.
	$words = explode(' ', strip_tags(preg_replace('/[^(\x20-\x7F)]*/','', $content)));
	// Get a count of all words, and check we have less/more than our required amount of words.
	$count = count($words);
	$limit = ($count > $length) ? $length : $count;
	// if we have more words than we want to show, add our ...
	$end   = ($count > $length) ? $finish : '';
	// create output
	for($w = 0;$w <= $limit ; $w++) {
		$output .= $words[$w];
		if($w < $limit) $output .= ' ';
	}
	// return end result.
	return $output.$end;
}
	
	
}
//$noticias = new Noticias;
?>