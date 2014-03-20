<?php
  $json_string = file_get_contents("http://api.wunderground.com/api/be6c54d2a7c7bf86/geolookup/conditions/q/IE/Dublin.json");

  echo $json_string;

  $parsed_json = json_decode($json_string);
  $location = $parsed_json->{'location'}->{'city'};
  $temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
  $feelslike_c = $parsed_json->{'current_observation'}->{'feelslike_c'};

  print "</br></br>";
  echo "Current temperature in ${location} is: ${temp_c} degrees celsius. It feels like ${feelslike_c}.\n";
?>




<!-- Example of getting weather information for Dublin using Wunderground >