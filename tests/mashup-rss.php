<?php
require('../src/coreylib.php');

$mashup = new clMashup(
	'channel/item',
	'pubDate',
	array(
		'http://feeds.feedburner.com/nettuts',
		'http://feeds2.feedburner.com/TheWhyAndTheHow',
		'http://feeds.feedburner.com/37signals/beMH'	
	)
);

$mashup->parse();
$mashup->info();
$mashup->sort();
?>


<ul>
<?php foreach ($mashup as $item): ?>
	<li><?php echo $item->get('pubDate') ?>: <?php echo $item->get('title') ?><br />
		<a href="<?php echo $item->get('link') ?>"><?php echo $item->get('link') ?></a></li>
<?php endforeach ?>
</ul>