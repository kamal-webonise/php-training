<?php
	$url = $argv[1];
	$depth = $argv[2];
	$current_links = array();
	include_once('./simple_html_dom.php'); 

  	function crawler($url, $depth, $current_links){
		$html = file_get_html($url);
  		$links = array();
		$titles = array();
		$images = array();
	    global $current_links;
	  	if($depth > 0) {

		  	foreach ( $html -> find('title') as $element ) {
		  		$titles[] = $element->plaintext;
		  	}
		  	foreach ( $html -> find('img') as $element ) {
		  		$images[] = $element->src;
		  	}
		  	foreach ( $html -> find('a') as $element ) {
		  		// stops the traversing of the same link again
		  		if( ! in_array($element->href, $current_links) ) {
			  		$current_links[] = $element->href;
			  		$links[] = array('title' => $titles, 'image' => $images, 'Link' => $element->href, 'sublinks' => crawler($element->href,$depth-1,$current_links));
		  		}
		  		else {
		  			echo "Repeated Links";
		  		}
		  	}
	  		return $links;
  	 	}
  	 	else
  	 		return;
  	}
    $result = crawler($url, $depth, $current_links);
    // print_r($result);
    $json_content = json_encode($result,JSON_PRETTY_PRINT);
    $file = 'data1.json';
    file_put_contents($file , $json_content);
?>