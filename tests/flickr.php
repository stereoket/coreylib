<?php 
require_once('../src/coreylib.php');
clAPI::configure('debug', true);

$flickrCount = (eregi('iPhone', $browser) ? 12 : 10); 
$api = new clAPI('http://api.flickr.com/services/rest'); 
$api->param('method', 'flickr.people.getPublicPhotos');
$api->param('api_key', '');
$api->param('user_id', '');
$api->param('page', 1);
$api->param('per_page', 12);
?>

<?php if ($api->parse('1 hour')): ?>
	<?php $api->info(); ?>
	<?php foreach($api->get('photos/photo', $flickrCount) as $photo): ?>	
		<li><a href="http://www.flickr.com/photos/netgeek/<?php echo $photo->get('@id'); ?>"><img src="http://farm<?php echo $photo->get('@farm'); ?>.static.flickr.com/<?php echo $photo->get('@server'); ?>/<?php echo $photo->get('@id'); ?>_<?php echo $photo->get('@secret'); ?>_s.jpg" border="0" width="75" height="75" alt="<?php echo $photo->get('@title'); ?>" title="<?php echo $photo->get('@title'); ?>" /></a></li>
	<?php endforeach; ?>
<?php endif; ?>