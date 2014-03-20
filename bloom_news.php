<?php
	//-------------------------WEB SCRAPE---------------------------
	$page = $_POST["bloom_url"];    //get url of the page to scrape from index.html

	$html = file_get_contents($page); //get the source code returned from the page selected

	$park_doc = new DOMDocument();  //declare a new DOM object

	libxml_use_internal_errors(TRUE); //disable libxml errors

	if(!empty($html))    //if any html is actually returned
	{
			$park_doc->loadHTML($html);
	 	     libxml_clear_errors(); //remove html errors
	  
	 	     $xpath = new DOMXPath($park_doc);  //DOMXPath allows queries with the DOM document. 
	  
	 	 	 //perform queries to find information
	 		 $event_desc = $xpath->query('//*[contains(@class, "fl oh pr")]');  //gets the event description
			 $link = $page;   //link to event
		
			//convert scraped data from DOMNodeList to string
			$full_event_title = "Bloom in the Park 2014";
		    echo $full_event_title;
		    
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
	        }
		    
		    $full_event_desc = iconv("UTF-8", "ISO-8859-1//IGNORE", $full_event_desc);      //ignore non UTF-8 characters
		    $full_event_desc = substr($full_event_desc, 0, -14);    //remove unwanted "your comments"
		    echo $full_event_desc;
		    
		    echo '<br/><br/>';

            $location = "Visitor Centre";
		    
		    echo "link: $link";
	
	
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
	
    		$sql = "INSERT INTO news_updates (title, description, location, link)
    		VALUES
    		('$full_event_title', '$full_event_desc', '$location', '$link')";

    		mysql_query($sql);
	
    		print "Inserted";
    	}
    	else 
    		print "Database NOT Found ";
	
    	mysql_close($connection); 
	}
	else
		print "<br/>Invalid URL";

    echo "</br>Length of description: ";
    echo strlen($full_event_desc);
?>