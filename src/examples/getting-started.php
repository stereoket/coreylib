<?php
require_once('../coreylib.php');

// create a new instance of the coreylib clAPI class
$api = new clAPI(
  'http://twitter.com/statuses/user_timeline.xml?screen_name=collegeman'
);
 
// parse the feed!
$api->parse('10 minutes');
// analyze your feed with the info() method:
$api->info();

?>

<style>
* {
	font-family: Tahoma, sans-serif;
}

ul {
	list-style-type: none;	
	margin: 0;
	padding: 0;
}

ul li {
	padding: 10px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border: 1px solid #ccc;
	margin: 0 0 10px 0;
}
</style>

<ul>
<?php 

/**
 * @param $text The text of a Twitter status update
 * @return The status with typical linking to users and URLs
 */
function tweet($text) {
  $text = preg_replace('#http://[^ ]+#i', '<a href="\\0">\\0</a>', $text);
  $text = preg_replace('/@([a-z0-9_]+)/i', '<a href="http://twitter.com/\\1">\\0</a>', $text);
  return $text;
}

// foreach status update in the feed
foreach($api->get('status') as $status) {
  // start a list item
  echo '<li>';
  // spit out the text of the status update
  echo tweet($status->get('text'));
  // create a link to the tweet
  $author = $status->get('user/screen_name');
  $id = $status->get('id');
  echo " <a href=\"http://twitter.com/$author/statuses/$id\">&raquo;</a>";
  // close the list item
  echo '</li>';
}

?>
</ul>