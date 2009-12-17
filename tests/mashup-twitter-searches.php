<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once("../src/coreylib.php"); 
clAPI::configure('debug', false);
?>

<?php 
$mashup = new clMashup();

$mashup->add('anthony jackson', new clAPI('http://search.twitter.com/search.atom?q=anthony+jackson'))
	->items_at('entry')
	->sort_by('updated');

$mashup->add('adam nitti', new clAPI('http://search.twitter.com/search.atom?q=adam+nitti'))
	->items_at('entry')
	->sort_by('updated');

$mashup->add('john patitucci', new clAPI('http://search.twitter.com/search.atom?q=john+patitucci'))
	->items_at('entry')
	->sort_by('updated');	

$mashup->add('jaco pastorious', new clAPI('http://search.twitter.com/search.atom?q=jaco+pastorious'))
	->items_at('entry')
	->sort_by('updated');

$mashup->parse('2 seconds');
$mashup->info();
$mashup->sort();
?>

<?php if ($mashup->count()): ?>
	<ul>
		<?php foreach($mashup as $item): ?>
			<li><b><?php echo $item->get('updated') ?></b> <em><?php echo $item->source ?></em> <?php echo $item->get('title')?></li>
		<?php endforeach; ?>
	</ul>
<?php endif ?>
