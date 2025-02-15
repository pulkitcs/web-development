<?php
 $URL = getenv('bmb_URL') ? getenv('bmb_URL') : "localhost";
 $DATABASE = getenv('bmb_DATABASE', true) ? getenv('bmb_DATABASE', true) : "bmb";
 $USERNAME = getenv('bmb_USERNAME', true) ? getenv('bmb_USERNAME', true) : "root";
 $PASSWORD = getenv('bmb_PASSWORD', true) ? getenv('bmb_PASSWORD', true) : "";

 $appConfig = array("url" => $URL, "database" => $DATABASE, "username" => $USERNAME, "password" => $PASSWORD);
?>