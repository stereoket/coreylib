<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
?>

<?php require_once("../src/coreylib.php"); ?>

<?php $api = new clAPI("http://karlacollegeman.com/feed/") ?>
<?php if ($api->parse('10 minutes')): ?>
	<?php $api->info(); ?>
	
	<?php foreach($api->get('channel/item') as $item): ?>
		<a href="<?php echo $item->get('link') ?>"><?php echo $item->get('title'); ?></a>
		<p><?php echo $item->get('content:encoded'); ?></p>
	<?php endforeach; ?>
<?php endif; ?>

