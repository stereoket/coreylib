<?php require_once('../src/coreylib.php'); clAPI::configure('debug', true); ?>
<?php $api = new clAPI('http://feeds.feedburner.com/typepad/sethsmainblog'); ?>
<?php $api->curlopt(CURLOPT_USERAGENT, "feedburnerclient") ?>
<?php if ($api->parse()): ?>
	<?php $api->info(); ?>
	<h4><a href="<?php echo $api->get('link[0]@href') ?>"><?php echo $api->get('title') ?></a></h4>
	<ul>
		<?php foreach($api->get('entry', 10) as $entry): ?>
			<li><a href="<?php echo $entry->get('link[0]@href') ?>"><?php echo $entry->get('title') ?></a></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>