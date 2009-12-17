<?php require_once('../src/coreylib.php'); clAPI::configure('debug', true); ?>
<?php $api = new clAPI('http://feeds.feedburner.com/bassistscom') ?>
<?php if ($api->parse('1 hour')): ?>
	<?php $api->info(); ?>
	<h4><a href="<?php echo $api->get('channel/link') ?>"><?php echo $api->get('channel/title') ?></a></h4>
	<ul>
		<?php foreach($api->get('channel/item', 10) as $item): ?>
			<li><a href="<?php echo $item->get('link') ?>"><?php echo $item->get('title') ?></a></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>