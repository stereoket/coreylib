<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once("../src/coreylib.php"); 
clAPI::configure('debug', false);
?>

<?php 
$delicious_username = '';
$delicious_password = '';

$flickr_api_key = '';
$flickr_user_id = '';

$mashup = new clMashup();

// tweets:
$twitter = 
	$mashup->add('twitter', new clAPI("http://twitter.com/statuses/public_timeline.xml"))
	->items_at('status')
	->sort_by('created_at');

// social bookmarks:
$delicious = 
	$mashup->add('delicious', new clAPI('https://api.del.icio.us/v1/posts/recent'))
	->items_at('post')
	->sort_by('@time')
	->api()
		->basicAuth($delicious_username, $delicious_password);
		
// photos:
$flicker = 
	$mashup->add('flickr', new clAPI('http://api.flickr.com/services/rest'))
	->items_at('photos/photo')
	->sort_by('@dateupload')
	->api()
		->param('method', 'flickr.people.getPublicPhotos')
		->param('extras', 'date_upload')
		->param('api_key', $flickr_api_key)
		->param('user_id', $flickr_user_id)
		->param('page', 1)
		->param('per_page', 12);
		
// blogs:
$notreble = 
	$mashup->add('notreble', new clAPI('http://feeds.feedburner.com/bassistscom'))
	->items_at('channel/item')
	->sort_by('pubDate');
	
$mashup->parse('10 minutes');
$mashup->info();
$mashup->sort();
?>

<?php if ($mashup->count()): ?>
	<ul>
		<?php foreach($mashup as $item): ?>
			<?php if ($item->source == 'twitter'): ?>
				<li><?php echo $item->get('text')?></li>
			<?php elseif ($item->source == 'delicious'): ?>
				<li><?php echo $item->get('@description') ?></li>
			<?php elseif ($item->source == 'flickr'): ?>
				<li>http://www.flickr.com/photos/<?php echo $item->get('@owner') ?>/<?php echo $item->get('@id') ?></li>
			<?php elseif ($item->source == 'notreble'): ?>
				<li><?php echo $item->get('title') ?></li>
			<?php endif ?>
		<?php endforeach; ?>
	</ul>
<?php endif ?>
