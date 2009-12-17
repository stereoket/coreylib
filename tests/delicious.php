<?php 
require_once('../src/coreylib.php'); 
clAPI::configure('debug', true);
clAPI::configure('trace', false);
?>

<?php 
$delicious_username = '';
$delicious_password = '';
$api = new clAPI('https://api.del.icio.us/v1/posts/recent');
$api->basicAuth($delicious_username, $delicious_password);
?>
<?php if ($api->parse('5 minutes')): ?>
	<?php $api->info(); ?>
	<h4><a href="http://delicious.com/"<?php echo $delicious_username ?>">Delicious/<?php echo $delicious_username ?></a></h4>
	<ul>
		<?php foreach($api->get('post') as $post): ?>
			<li style="clear:both;">
				<a href="<?php echo $post->get('@href') ?>"><?php echo $post->get('@description'); ?></a><br />
				<?php if ($post->has('@tag')): $tags = split(' ', $post->get('@tag')); ?>
					<span style="display:block; float: left;">[&nbsp;&nbsp;</span><ul style="list-style-type:none; padding:0; margin:0;">
						<?php foreach($tags as $tag): ?>
							<li style="float:left; margin-right:10px; padding-bottom: 10px;"><a href="http://delicious.com/<?php echo $delicious_username ?>/<?php echo $tag ?>"><?php echo $tag ?></a></li>
						<?php endforeach; ?>
					</ul>]
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>