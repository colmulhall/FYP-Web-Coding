<?php
	//-------------------------WEB SCRAPE---------------------------
	$page = $_POST["heritage_url"];    //get url of the page to scrape from index.html

	$html = file_get_contents($page); //get the source code returned from the page selected

	$park_doc = new DOMDocument();  //declare a new DOM object

	libxml_use_internal_errors(TRUE); //disable libxml errors

	if(!empty($html))    //if any html is actually returned
	{
		$park_doc->loadHTML($html);
 	     libxml_clear_errors(); //remove html errors
  
 	     $xpath = new DOMXPath($park_doc);  //DOMXPath allows queries with the DOM document. 
  
 	 	 //perform queries to find information
 	 	 $event_title = $xpath->query('//h1[not(@class)]');  //gets the event title, ignores any other h1 headings on the page
 		 $event_desc = $xpath->query('//div[@id!="copyrighttext"]/p');  //gets the event description
		 $link = $page;   //link to event
	
	//convert scraped data from DOMNodeList to string
	if($event_title->length > 0)
	{
		//get event title
	    $node = $event_title->item(0);
	    $event_title = "{$node->nodeName} - {$node->nodeValue}";                //convert to string
	    $event_title = iconv("UTF-8", "ISO-8859-1//IGNORE", $event_title);      //ignore non UTF-8 characters
	    $event_title = substr($event_title, 5); 						      //remove the tag at the beginning of the string
            $event_title = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $event_title);
	    echo $event_title;
	    
	    echo '<br/><br/>';
	    
	    //get event description. iterate through the paragraph adding each sentence to the string "full_event_desc"
	    $full_event_desc = '';
            foreach($event_desc as $node) 
            {
                $full_event_desc .= $node->textContent .= " ";

                //replace unreadable characters from the description (e.g. &nbsp;)
                $full_event_desc = utf8_decode($full_event_desc);
                $temp = utf8_decode('Â');
                $full_event_desc = str_replace($temp, '', $full_event_desc);
                $full_event_desc = str_replace("?", " ", $full_event_desc);
                $full_event_desc = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $full_event_desc);
            }
	    
	    $full_event_desc = iconv("UTF-8", "ISO-8859-1//IGNORE", $full_event_desc);      //ignore non UTF-8 characters
	    
	    echo $full_event_desc;
	    
	    echo '<br/><br/>';
	    
	    echo "link: $link";
	}
	
	//-------------------------CONNECTION AND INSERTION INTO DATABASE---------------------------
	$user_name = 'a9517348_colm';
	$password = 'parkdbpass7';
	$database = 'a9517348_parkdb';
	$host = 'mysql5.000webhost.com';

	$connection = mysql_connect($host, $user_name, $password);

	//Check connection-------------------------------------------------
	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	else
		echo "</br></br>Connected...</br>";

	//Check if database is found
	$db_found = mysql_select_db($database, $connection);
	if ($db_found)
	{
		print "Database Found </br>";
		
		//Insert into the database
		mysql_select_db($database, $connection);
	
		$sql = "INSERT INTO event_list (title, description, link)
		VALUES
		('$event_title', '$full_event_desc', '$link')";

		mysql_query($sql);
	
		print "Inserted";
	}
	else 
		print "Database NOT Found ";
	
	mysql_close($connection);
     }
	else
		print "<br/>Invalid URL"
?>