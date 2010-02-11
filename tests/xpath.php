<?php
require_once('../src/coreylib.php'); 
clAPI::configure('debug', true);
clAPI::configure('trace', false);
$api = new clAPI('http://buzz.googleapis.com/feeds/thepythonist/public/posted');
$api->parse();
$api->info();
echo $api->first('//feed:author/feed:name');


?>