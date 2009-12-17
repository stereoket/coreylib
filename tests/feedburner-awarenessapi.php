<?php require_once('../src/coreylib.php'); clAPI::configure('debug', true); ?>
<?php 
$feedburner_uri = 'coreylib-cookbook';
$api = new clAPI('https://feedburner.google.com/api/awareness/1.0/GetFeedData');
$api->param('uri', $feedburner_uri); 
?>
<?php if ($api->parse('10 minutes')): ?>
	<h4><?php echo $api->get('feed@uri'); ?></h4>
	<p>
		<?php echo $api->get('feed/entry[0]@hits'); ?> hits 
		as of <?php echo date('F j', strtotime($api->get('feed/entry[0]@date'))); ?></p>
	</p>
<?php endif; ?>
