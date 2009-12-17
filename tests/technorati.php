<?php require_once('../src/coreylib.php'); clAPI::configure('debug', true); ?>
<?php $api = new clAPI('http://feeds.technorati.com/search/iphone?language=n') ?>
<?php if ($api->parse()): ?>
	<?php $api->info(); ?>
<?php endif; ?>


