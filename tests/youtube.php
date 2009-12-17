<?php 
require_once('../src/coreylib.php'); 
$api = new clAPI('http://gdata.youtube.com/feeds/api/standardfeeds/most_viewed');
$api->param('v', 2);
?>

<?php if ($api->parse('1 hour')): ?>
	<h4><?php echo $api->get('title') ?></h4>
	<?php $api->info(); ?>
	<?php foreach($api->get('entry', 10) as $entry): ?>
		<?php 
			// this nasty bit extracts the video id from entry@id:
			preg_match('/video\\:([^\\:]+)/i', $entry->get('id'), $matches);
			$id = $matches[1]; 
			$thumbnail = $entry->get('media:group/media:thumbnail[0]@url');
		?>
		<?php if ($id): ?>
			<a 
				style="display:block; width:130px; height:97px; border:1px solid black; float: left; margin: 0px 10px 10px 0px; background-image:url(<?php echo $thumbnail ?>);" 
				title="<?php echo $entry->get('title') ?>"
				href="http://youtube.com/watch?v=<?php echo $id ?>"
			>&nbsp;</a>
		<?php endif; ?>
	<?php endforeach; ?>
	<div style="clear:both;"></div>
<?php endif; ?>

<?php 
$api = new clAPI('http://gdata.youtube.com/feeds/api/standardfeeds/top_rated');
$api->param('v', 2);
?>
<?php if ($api->parse('1 hour')): ?>
	<h4><?php echo $api->get('title') ?></h4>
	<?php $api->info(); ?>
	<?php foreach($api->get('entry', 10) as $entry): ?>
		<?php 
			// this nasty bit extracts the video id from entry@id:
			preg_match('/video:([^\:]+)/i', $entry->get('id'), $matches);
			$id = $matches[1]; 
		?>
		<?php if ($id): ?>
			<div><a href="http://youtube.com/watch?v=<?php echo $id ?>"><?php echo $entry->get('title') ?></a></div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>

<?php 
$api = new clAPI('http://gdata.youtube.com/feeds/api/standardfeeds/most_recent');
$api->param('v', 2);
?>
<?php if ($api->parse('1 hour')): ?>
	<h4><?php echo $api->get('title') ?></h4>
	<?php $api->info(); ?>
	<?php foreach($api->get('entry', 10) as $entry): ?>
		<?php 
			// this nasty bit extracts the video id from entry@id:
			preg_match('/video:([^\:]+)/i', $entry->get('id'), $matches);
			$id = $matches[1]; 
		?>
		<?php if ($id): ?>
			<div><a href="http://youtube.com/watch?v=<?php echo $id ?>"><?php echo $entry->get('title') ?></a></div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
