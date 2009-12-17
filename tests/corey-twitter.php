<?php
require_once('../src/coreylib.php');
$twitter_username = '';
$twitter_password = '';
$api = new clAPI('twitter.com/statuses/user_timeline.xml');
$api->param('count', 5);
$api->basicAuth($twitter_username, $twitter_password);
echo date('r', time());
?>

    <div id="twitter">
      <div id="twitter_div">
      <h2 class="twitter">Latest Updates <span>  &#187; Twitter</span></h2>
      <ul id="twitter_update_list">


<?php if ($api->parse('1 hour')): ?>
      <ul>
<?php foreach($api->get('status') as $post): ?>

<?php $tweet = $post->get('text'); 

// Convert URL's with protocol prefix
    $tweet = ereg_replace("[a-zA-Z]+://([-]*[.]?[a-zA-Z0-9_/-?&%])*", "<a href=\"\\0\">\\0</a>", $tweet);

//Convert URL with just www.
    $tweet = ereg_replace("(^| |\n)(www([-]*[.]?[a-zA-Z0-9_/-?&%])*)", "\\1<a href=\"http://\\2\">\\2</a>", $tweet);

//Convert # hashtags
    $tweet = ereg_replace("(^| |\n)(\#([-]*[.]?[a-zA-Z0-9_/-?&%])*)", "\\1<a href=\"http://search.twitter.com/search?q=\\2\">\\2</a>", $tweet);
    $tweet = str_replace("/#", "/", $tweet);

//Convert @ replies
    $tweet = ereg_replace("(^| |\n)(\@([-]*[.]?[a-zA-Z0-9_/-?&%])*)", "\\1@<a href=\"http://www.twitter.com/\\2\">\\2</a>", $tweet);
    $tweet = str_replace("/@", "/", $tweet);
    $tweet = str_replace(">@", ">", $tweet);

// Make the time prettier
  $createstamp = $post->get('created_at');
  $relative_time = niceTime(strtotime($createstamp));
?>

        <li><?php echo $tweet ?> <span>posted <a href="http://twitter.com/<?php echo $twitter_username ?>/status/<?php echo $post->get('id'); ?>"><?php echo $relative_time ?></a></span></li>
<?php endforeach; ?>
      </ul>
<?php endif; ?>


<?php
//twitter's time stamp format = Thu Jan 01 18:16:48 +0000 2009

function niceTime($time) {
  $delta = time() - $time;
  if ($delta < 60) {
    return 'less than a minute ago';
  } else if ($delta < 120) {
    return 'about a minute ago';
  } else if ($delta < (45 * 60)) {
    return floor($delta / 60) . ' minutes ago';
  } else if ($delta < (90 * 60)) {
    return 'about an hour ago';
  } else if ($delta < (24 * 60 * 60)) {
    return 'about ' . floor($delta / 3600) . ' hours ago';
  } else if ($delta < (48 * 60 * 60)) {
    return 'yesterday';
  } else {
    return floor($delta / 86400) . ' days ago';
  }
}
?>

      </div>  
      <p class="more"><a href="http://twitter.com/<?php echo $twitter_username ?>">follow me on twitter</a></p>
    </div><!-- /twitter -->