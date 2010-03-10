<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once("../src/coreylib.php");
clAPI::configure('debug', true);
?>

<?php 
$mashup = new clMashup();

// tweets:
$stevejobs = 
        $mashup->add('twitter', new clAPI("http://search.twitter.com/search.atom?q=steve+jobs"))
        ->items_at('entry')
        ->sort_by('updated');

$jacopastorius = 
        $mashup->add('twitter', new clAPI("http://search.twitter.com/search.atom?q=jaco+pastorius"))
        ->items_at('entry')
        ->sort_by('updated');

$sethgodin = 
        $mashup->add('twitter', new clAPI("http://search.twitter.com/search.atom?q=seth+godin"))
        ->items_at('entry')
        ->sort_by('updated');
                
// blogs:
$notreble = 
        $mashup->add('notreble', new clAPI('http://feeds.feedburner.com/bassistscom'))
        ->items_at('channel/item')
        ->sort_by('pubDate');
        
$mashup->parse('10 minutes');
$mashup->info();
$mashup->sort();
?>

<?php if ($mashup->count()): ?>
        <ul>
                <?php foreach($mashup as $item): ?>
                        <?php if ($item->source == 'twitter'): ?>
                                <li><?php echo $item->get('title')?></li>
                        <?php elseif ($item->source == 'notreble'): ?>
                                <li><?php echo $item->get('title') ?></li>
                        <?php endif ?>
                <?php endforeach; ?>
        </ul>
<?php endif ?>




</body>
</html>
