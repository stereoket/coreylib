<?php 
require_once('../src/coreylib.php');
clAPI::configure('debug', true);

$associate_tag = '';
$access_key_id = '';
$secret_code = '';

$api = new clAWSECS($associate_tag, $access_key_id, $secret_code);
$api->param("Keywords", "Jaco Pastorious");
$api->parse();
$api->info();