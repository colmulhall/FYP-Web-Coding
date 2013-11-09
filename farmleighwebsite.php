<?php
	$html = file_get_contents('http://www.phoenixpark.ie/newsevents/2013/title,24194,en.html'); //get the html returned from the following url

	$park_doc = new DOMDocument();  //declare a new DOM object

	libxml_use_internal_errors(TRUE); //disable libxml errors

	if(!empty($html))    //if any html is actually returned
	{
	  $park_doc->loadHTML($html);
	  libxml_clear_errors(); //remove html errors
	  
	  $xpath = new DOMXPath($park_doc);  //DOMXPath allows queries with the DOM document. 
	  
	  //perform queries to find information
	  $event_title = $xpath->query('//h1[not(@class)]');  //gets the event title, ignores any other h1 headings on the page
	  $event_desc = $xpath->query('//div[@id!="copyrighttext"]/p | //div[@id="contentcolumn1"]/ul | //h5');  //gets the event description
	  
	  //display contents
	  if($event_desc->length > 0)
	  {
		  foreach($event_title as $row)
		  {
			  echo $row->nodeValue . "<br/>";
		  }
		  echo "<br/>";
		  foreach($event_desc as $row)
		  {
			  echo $row->nodeValue . "<br/>";
		  }
	  }
	}
?>