<?php 
require_once('../../src/coreylib.php');
$sample = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'youtube-gdata.xml');
$content = @file_get_contents($sample);

/*
$doc = new DOMDocument('1.0');
$doc->preserveWhiteSpace = false;
$doc->loadXML($content);
$doc->formatOutput = true;
$geshi = new Geshi($doc->saveXML(), 'xml');
$code = $geshi->parse_code();
echo $code;
*/

$root = @simplexml_load_string($content, null, LIBXML_NOCDATA);

class clNode {
	
	private static $jqueryOut = false;
	
	public $__name;
	public $__value;
	public $__children = array();
	public $__attributes = array();
	
	function __construct(SimpleXMLElement $node, $namespaces = null) {
		
		$this->__name = $node->getName();
		$this->__value = $node;
		
		if ($namespaces === null)
			$namespaces = $node->getNamespaces(true);
		
		foreach($namespaces as $ns => $uri) {
			foreach($node->children($uri) as $child) {
				$childName = ($ns ? "$ns:".$child->getName() : $child->getName());
			
				if (array_key_exists($childName, $this->__children) && is_array($this->__children[$childName])) {
					$this->__children[$childName][] = new clNode($child, $namespaces);
				}
				else if (array_key_exists($childName, $this->__children) && get_class($this->__children[$childName]) == "clNode") {
					$childArray = array();
					$childArray[] = $this->__children[$childName];
					$childArray[] = new clNode($child, $namespaces);
					$this->__children[$childName] = $childArray;
				}
				else
					$this->__children[$childName] = new clNode($child, $namespaces);
			}
			
			foreach($node->attributes($ns) as $a) {
				$a = $a->asXML();
				@list($name, $value) = split('=', $a);
				$this->__attributes[trim($name)] = substr($value, 1, strlen($value)-2);
			}
		}
	}

	function get($path = null, $limit = null, $forceReturnWrapper = false) {
		if ($path)
			clAPI::trace("Searching for <b>&quot;$path&quot;</b>");	
		
		if ($path === null)
			return ($forceReturnWrapper) ? $this : $this->__value; 
			
		$node = $this;
		
		foreach(split('\/', $path) as $childName) {
			$index = $attribute = null;
			
			if (preg_match('/^@(.*)?$/', $childName, $matches)) { // attribute only
				$childName = null;
				$attribute = $matches[1];
				clAPI::trace("Searching for attribute named $attribute");
			}
			else if (preg_match('/(.*)\[(\d+)\](@(.*))?$/', $childName, $matches)) { // array request with/out attribute
				$childName = $matches[1];	
				$index = (int) $matches[2];	
				$attribute = (isset($matches[4])) ? $matches[4] : null;
				clAPI::trace("Searching for element <b>$childName".'['."$index]</b>".($attribute ? ", attribute <b>$attribute</b>" : ''));
			}
			else if (preg_match('/([^@]+)(@(.*))?$/', $childName, $matches)) { // element request with/out attribute
				$childName = $matches[1];	
				$attribute = (isset($matches[3])) ? $matches[3] : null;
				clAPI::trace("Searching for element <b>$childName</b>".($attribute ? ", attribute <b>$attribute</b>" : ''));
			}
			
			if (!$childName && $attribute) {
				/*
				if (!isset($node->__attributes[$attribute])) {
					clAPI::error("<b>$node->__name</b> does not have an attribute named <b>$attribute</b>");
					return null;
				}
				*/
				
				return (isset($node->__attributes[$attribute]) ? $node->__attributes[$attribute] : null);		
			}
			
			if ($childName && is_array($node)) {
				clAPI::error("You are looking for <b>$childName</b> in an array of elements, which isn't possible");
				return null;	
			}
			
			else if (!isset($node->__children[$childName])) {
				clAPI::error("$childName is not a child of $node->__name");
				return null;
			}
			
			else {
				$node = $node->__children[$childName];
				
				if ($index !== null) {
					if (!is_array($node)) {
						clAPI::error("$node->__name is not an array of elements or $index does not exist");
						return null;
					}
					else
						$node = $node[$index];
				}
				
				if ($attribute !== null) {
					
					/* this won't work because sometimes feeds just drop the attribute definition... boo.
					if (!count($node->__attributes)) {
						clAPI::error("$childName does not have any attributes");
						return null;
					}
					
					if (!isset($node->__attributes[$attribute])) {
						clAPI::error("$node->__name does not have an attribute named $attribute");
						return null;
					}
					*/
					
					return isset($node->__attributes[$attribute]) ? $node->__attributes[$attribute] : null;	
				}
			}
		}
		
		if (is_object($node)) {
			if (!count($node->__children) && !$forceReturnWrapper)
				return $node->__value;
			else
				return $node;
		}
		else if (is_array($node) && is_numeric($limit))
			return array_slice($node, 0, $limit);
		else
			return $node;
	}
	
	function text($path = null, $limit = null) {
		$node = $this->get($path, $limit);
		return (get_class($node) == "clNode") ? $node->__value : $node;
	}
	
	function info($path = null, $limit = null) {
		$node = $this->get($path, $limit, true);
		if (is_array($node)) {
			foreach($node as $n)
				self::blockquote($n->__name, $n);
		}
		else if (is_object($node))
			self::blockquote($node->__name, $node);
		else if ($node !== null)
			echo "$path: $node";
		return '';
	}
	
	private static function blockquote($name, $node) {
		if (is_object($node)) {
			echo '<blockquote>&lt;'.$name.(count($node->__attributes) ? ' '.join(' ', array_keys($node->__attributes)) : '').'&gt;';
			foreach($node->__children as $childName => $child)
				self::blockquote($childName, $child);
			echo '&lt;/'.$name.'&gt;</blockquote>';
		}
		else if (is_array($node)) {
			foreach($node as $instance)
				self::blockquote($name, $instance);	
		}
	}	
		
	function __get($name) {
		$sxml = $this->__value;
		return $sxml->$name;
	}
	
	function __toString() {
		$this->blockquote();
		return '';	
	}

}

$node = new clNode($root);
?>

<?php foreach($node->get('entry[0]/category') as $category): ?>
	<?php echo $category->info(); ?>
<?php endforeach; ?>

