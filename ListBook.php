<?php
header ("Content-Type: text/html; charset=utf-8");

	$dom = new domDocument();
	libxml_use_internal_errors(true);
    $dom->loadHTMLFile ('http://royallib.com/genre/fantastika-ru-29.html');
    libxml_use_internal_errors(false);
    $xpath = new DOMXPath($dom);
    $results = $xpath->query("//div[@class='well']/a/@href");
    $links = array();
    for($i = 1; $i < $results->length-1; $i++){
    	$links[] = $results->item($i)->nodeValue;
    }
    $books = array();
    foreach ($links as $linkk){
    	$dom2 = new domDocument();
    	libxml_use_internal_errors(true);
    	$dom2->loadHTMLFile ($linkk);
    	libxml_use_internal_errors(false);
    	$xpath = new DOMXPath($dom2);
    	$results = $xpath->query("//div[@class='content']/a");
    	foreach ($results as $item){
    		$books[] = $item->nodeValue . "\n";
    		//echo $item->nodeValue . "<br>";
    	}
    }
   file_put_contents("books.txt", $books, FILE_APPEND)
    


?>
