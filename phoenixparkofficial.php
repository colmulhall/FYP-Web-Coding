<?php
     //-------------------------WEB SCRAPE---------------------------
	$html = file_get_contents('http://www.phoenixpark.ie/newsevents/title,22296,en.html'); //get the html returned from the following url

	$park_doc = new DOMDocument();  //declare a new DOM object

	libxml_use_internal_errors(TRUE); //disable libxml errors

	if(!empty($html))    //if any html is actually returned
	{
	  $park_doc->loadHTML($html);
	  libxml_clear_errors(); //remove html errors
	  
	  $xpath = new DOMXPath($park_doc);  //DOMXPath allows queries with the DOM document. 
	  
	  //perform queries to find information
	  $event_title = $xpath->query('//h1[not(@class)]');  //gets the event title, ignores any other h1 headings on the page
	  $event_desc = $xpath->query('//div[@id!="copyrighttext"]/p | //div[@id="contentcolumn1"]/ul | //h5');  //get the event description
	  
	  /*if($event_desc->length > 0)
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
	  }*/
	}
	
	//convert scraped data from DOMNodeList to string
	if($event_title->length > 0) 
	{
		//get event title
	    $node = $event_title->item(0);
	    $event_title = "{$node->nodeName} - {$node->nodeValue}";  //convert to string
	    $event_title = iconv("UTF-8", "ISO-8859-1//IGNORE", $event_title);   //ignore non UTF-8 characters
	    $event_title = substr($event_title, 5);  //remove the tag at the beginning of the string
	    
	    
	    //get event description -- Still some problems with iterating over the sentences from the web scrape
	    foreach($node as $item)
	    {
	    	   $node = $event_desc->item();
	        $event_desc = "{$node->nodeName} - {$node->nodeValue}";
	    }
	    
	    
	    $node = $event_desc->item(0);
	    $event_desc = "{$node->nodeName} - {$node->nodeValue}";   //convert to string
	    $event_desc = iconv("UTF-8", "ISO-8859-1//IGNORE", $event_desc);   //ignore non UTF-8 characters
	    $event_desc = substr($event_desc, 3);  //remove the tag at the beginning of the string
		
	}
	
	
	//-------------------------CONNECTION AND INSERTION INTO DATABASE---------------------------
	$user_name = 'root';
	$password = '';
	$database = 'park_events';
	$server = '127.0.0.1';

	$connection = mysql_connect($server, $user_name, $password);

	//Check connection-------------------------------------------------
	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	else
		echo "</br></br>Connected...</br>";

	//Check if database is found
	$db_found = mysql_select_db($database, $connection);
	if ($db_found)
	{
		print "Database Found ";
	}
	else 
	{
		print "Database NOT Found ";
	}
	
	
	//Insert into the database
	mysql_select_db($database, $connection);
	
	$sql = "INSERT INTO event_list (title, description)
	VALUES
	('$event_title', '$event_desc')";

	mysql_query($sql);

	mysql_close($connection);

?>