<!-- load coreylib -->
<?php require_once('../src/coreylib.php') ?>
<!-- two levels of debugging, should something go wrong... -->
<?php 
//clAPI::configure('debug', true);
//clAPI::configure('trace', false);
?>

<?php if (!clCache::cached('google.buzz.feed', '1 second')): ?>
	<!-- create a new API parser with the feed address -->
	<?php $api = new clAPI('http://buzz.googleapis.com/feeds/108964711519495307614/public/posted') ?>
	<!-- parse it  -->
	<?php if ($api->parse()): ?>
		<!-- uncomment this line if you want a pretty tree to explore -->
		<?php //$api->info() ?>
		<!-- use xpath to grab all of the <entry> elements -->
		<ul>
		<?php foreach($api->xpath('//feed:entry') as $entry): ?>
			<!-- for each entry element, grab the alternate link and the content -->
			<?php 
				$content = $entry->first('feed:content')->__toString();
				$content = substr($content, 5, strlen($content)-5);
				$href = $entry->first('feed:link[@rel="alternate"]/@href'); 
			?>	
			<li><?php echo $content ?> <a href="<?php echo $href ?>">&raquo;</a></li>
		<?php endforeach; ?>
		</ul>
		<?php clCache::save() ?>
	<?php endif; ?>
<?php endif; ?>
