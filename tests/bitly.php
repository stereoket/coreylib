<?php 
require_once('../src/coreylib.php');
clAPI::configure('debug', true);

$api_key = '';
$login = '';

$api = new clAPI('http://api.bit.ly/shorten');
$api->param('longUrl', 'http://collegeman.net');
$api->param('version', '2.0.1');
$api->param('apiKey', $api_key);
$api->param('login', $login);
$api->param('format', 'xml');
?>

<?php if ($api->parse()): ?>
	<?php if ($api->get('errorCode') == '0'): ?>
		<?php $api->info('results') ?>
		<?php echo $api->get('results/nodeKeyVal/shortUrl')?>
	<?php else: ?>
		<?php $api->info(); ?>
	<?php endif; ?>
<?php endif; ?>