<?php require_once("../src/coreylib.php"); ?>

<?php $api = new clAPI("http://twitter.com/statuses/public_timeline.xml") ?>
<?php if ($api->parse('10 minutes')): ?>
	<?php $status = $api->get('status[5]'); ?>
	<div><?php echo $status->renderTwitterLink() ?></div>
<?php endif; ?>