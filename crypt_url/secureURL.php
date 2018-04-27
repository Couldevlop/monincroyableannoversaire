<?php

/**
 * SecureURL
 * Auto encode and decode URL query string
 * 
 * You can use this class in your application or
 * modify it to suite your need as long as you keep
 * my name as orginal author.
 * 
 * If you find any bugs or have new ideas, feel
 * free to contact me ;)
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 * @version 2.0
 */

/**
 * SecureURL class
 * Auto encode and decode URL query string
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
class SecureURL
{
	/**
	 * URL Filter array
	 *
	 * @var array of URL_Filter
	 */
	protected static $filters = array();
	
	/**
	 * URL Parser
	 *
	 * @var array of URL_Parser
	 */
	protected static $parsers = array();
	
	/**
	 * Encoder
	 *
	 * @var Encoder
	 */
	protected static $encoder = null;
	
	/**
	 * Query key
	 *
	 * @var string
	 */
	protected static $query_key = "crypt";
	
	/**
	 * Public variables array
	 *
	 * @var string
	 */
	protected static $public_variables = array();
	
	/**
	 * Default include flag for filter checking
	 *
	 * @var bool
	 */
	protected static $default_filter_include = true;
	
	/**
	 * ForceEncode option
	 *
	 * @var bool
	 */
	protected static $force_encode_url = true;
	
	/**
	 * ProtectMode option
	 *
	 * @var bool
	 */
	protected static $protect_mode = true;
	
	/**
	 * Initialize SecureURL class
	 *
	 * @param URL_Encoder $encoder
	 */
	public static function Initialize(URL_Encoder $encoder)
	{
		self::$encoder = $encoder;
		$public_variables = self::$public_variables;
		$query_key = self::$query_key;
		$protect_mode = self::$protect_mode;
		
		ob_start("__secureURL_output_callback");
		
		//-- begin decode --//
		global $HTTP_GET_VARS,$HTTP_SERVER_VARS;
		$global_flag = (ini_get("register_globals"));
			
		//remove $_REQUEST index from $_GET
		foreach (array_keys($_GET) as $key)
		{
			if (@$_REQUEST[$key] == $_GET[$key])
			{
				unset($_REQUEST[$key]);
			}
			if ($global_flag && @$GLOBALS[$key] == $_GET[$key])
			{
				unset($GLOBALS[$key]);
			}
		}
		
		if (isset($_GET[$query_key]))
		{
			$encodedquery = $_GET[$query_key];
			unset($_GET[$query_key]);
		}
		
		$old_query = $_GET;
		
		if (isset($encodedquery) && $encoder->isValidEncodedString($encodedquery))
		{
			$query = $encoder->decodeString($encodedquery);
			$query = html_entity_decode($query,ENT_QUOTES);
			@parse_str($query,$_GET);
			
			foreach ($public_variables as $key)
			{
				if (array_key_exists($key,$old_query))
				{
					$_GET[$key] = $old_query[$key];
				}
				
				unset($old_query[$key]);
			}
			
			if (!$protect_mode)
			{
				foreach ($old_query as $key => $value)
				{
					$_GET[$key] = $value;
				}
			}
		}
		else
		{
			$encodedquery = null;
			
			if ($protect_mode)
			{
				$_GET = array();
			}
		}
		
		//rebuild the query
		$query = "";
		foreach ($_GET as $key => $value)
		{
			$query .= urlencode($key) . "=" . urlencode($value) . "&";
		}
			
		//fix the $_REQUEST variable
		foreach ($_GET as $key => $value)
		{
			if (!array_key_exists($key,$_REQUEST))
			{
				$_REQUEST[$key] = $value;
			}
			if ($global_flag && !array_key_exists($key,$GLOBALS))
			{
				$GLOBALS[$key] = $value;
			}
		}
		$HTTP_GET_VARS = $_GET;
			
		//fix the $_SERVER variable
		$bits = @parse_url($_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = @$bits['path'] . "?" . $query;
		$_SERVER['QUERY_STRING'] = $query;
		$_SERVER['argv'] = array($query);
		$HTTP_SERVER_VARS['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
		$HTTP_SERVER_VARS['QUERY_STRING'] = $_SERVER['QUERY_STRING'];
		$HTTP_SERVER_VARS['argv'] = $_SERVER['argv'];
		if ($global_flag)
		{
			$GLOBALS['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
			$GLOBALS['QUERY_STRING'] = $_SERVER['QUERY_STRING'];
		}
		//-- end decode --//
	}
	
	/**
	 * Set public variables
	 * Variables accepted from query string
	 *
	 * @param array $vars
	 */
	public static function setPublicVariables($vars)
	{
		if (!is_array($vars))
		{
			$vars = array();
		}
		self::$public_variables = $vars;
	}
	
	/**
	 * Add public variable
	 *
	 * @param string $var
	 */
	public static function addPublicVariable($var)
	{
		self::$public_variables[] = $var;
	}
	
	/**
	 * Set query key
	 *
	 * @param string $key
	 */
	public static function setQueryKey($key)
	{
		self::$query_key = $key;
	}
	
	/**
	 * When no filter matchs the given URL
	 * secureURL will use this option to decide
	 * whether to encode the URL or not
	 *
	 * @param bool $include
	 */
	public static function setFilterIncludeOption($include)
	{
		self::$default_filter_include = $include;
	}
	
	/**
	 * Force secureURL to encode URL through their are
	 * no parser can read the text
	 *
	 * @param bool $force
	 */
	public static function setForceEncodeOption($force)
	{
		self::$force_encode_url = $force;
	}
	
	/**
	 * Enable protect mode
	 * When protect mode is enabled, only encrypted
	 * variables and public variables are accepted
	 *
	 * @param bool $enable
	 */
	public static function setProtectMode($enable)
	{
		self::$protect_mode = $enable;
	}
	
	/**
	 * Add an URL Filter
	 *
	 * @param URL_Filter $filter
	 */
	public static function addFilter(URL_Filter $filter)
	{
		self::$filters[] = $filter;
	}
	
	/**
	 * Add an URL Parser
	 *
	 * @param URL_Parser $parser
	 */
	public static function addParser(URL_Parser $parser)
	{
		self::$parsers[] = $parser;
	}
	
	/**
	 * Process URL and encode it
	 *
	 * @param string $url
	 * @return string
	 */
	public static function processURL($url)
	{
		/* @var $filter URL_Filter */
		$parser = null;
		$filter = null;
		
		$url = html_entity_decode($url);
		
		foreach (self::$parsers as $check_parser)
		{
			if ($check_parser->isReadable($url))
			{
				$parser = $check_parser;
				break;
			}
		}
		
		if ($parser == null)
		{
			if (self::$force_encode_url)
			{
				$parser = new URL_Parser_Simple();
				self::$parsers[] = $parser;
			}
			else
			{
				return $url;
			}
		}
		
		$read_url = $parser->Read($url);
		
		if (count(self::$filters))
		{
			foreach (self::$filters as $check_filter)
			{
				if ($check_filter->match($read_url))
				{
					$filter = $check_filter;
					break;
				}
			}
		}
		
		if ((!isset($filter) && self::$default_filter_include) || (isset($filter) && $filter->isAllow()))
		{
			$read_url = self::encodeURL($read_url,(isset($filter) ? $filter->getPublicVariables() : array()));
		}
		
		return htmlspecialchars($parser->Render($read_url),ENT_QUOTES);
	}
	
	/**
	 * Encode URL
	 *
	 * @param string $url
	 * @param array $public_variables
	 * 
	 * @return string
	 */
	public static function encodeURL($url,$public_variables=array())
	{		
		if (($pos = strpos($url,"?")) !== false)
		{
			$query = substr($url,$pos + 1);
			$public_query = "";
			
			if ($public_variables)
			{
				@parse_str($query,$vars);
				
				foreach ($public_variables as $var)
				{
					if (array_key_exists($var,$vars))
					{
						$public_query .= "&$var=" . urlencode($vars[$var]);
					}
				}
				
			}
			
			//-- begin encode --//
			$encoder =& self::$encoder;
			$query = self::$query_key . "=" . urlencode($encoder->encodeString($query)) . $public_query;
			//-- end encode --//
			
			$url = substr($url,0,$pos) . "?" . $query;
		}
		
		return $url;
	}
}

/*----------------------------------------
 URL Parser class
----------------------------------------*/

/**
 * URL Parser class
 * Read and render custom url format (eg: URL in javascript)
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
abstract class URL_Parser
{
	/**
	 * Return TRUE if the URL can be
	 * read by this parser
	 *
	 * @param string $text
	 * @return bool
	 */
	abstract public function isReadable($text);
	
	/**
	 * Read and return the URL
	 *
	 * @param string $url
	 * @return string
	 */
	abstract public function read($text);
	
	/**
	 * Rerender the text from URL
	 *
	 * @param string $url
	 * @return string
	 */
	abstract public function render($url);
}

/**
 * Default URL Reader
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
class URL_Parser_Simple extends URL_Parser
{
	public function IsReadAble($text)
	{
		//only encode HTTP Link
		if (strtolower(substr($text,0,7)) == "http://" || strtolower(substr($text,0,8)) == "https://")
		{
			return true;
		}
		if (strtolower(substr($text,0,11)) == "javascript:")
		{
			return false;
		}
		if (strtolower(substr($text,0,7) == "mailto:"))
		{
			return false;
		}
		
		return (strpos($text,"://") === false);
	}
	
	public function Read($text)
	{
		return ($text);
	}
	
	public function Render($url)
	{
		return ($url);
	}
}


/*----------------------------------------
 URL Filter class
----------------------------------------*/

/**
 * URL Filter class
 * Add filter to include or exclue URL being encoded
 * 
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
abstract class URL_Filter
{
	/**
	 * Public query variables
	 *
	 * @var array
	 */
	protected $public_variables = array();
	
	/**
	 * Include this filter or not
	 *
	 * @var string
	 */
	protected $filter_include = true;
	
	/**
	 * Set public variables
	 *
	 * @param array $vars
	 */
	public function setPublicVariables($vars)
	{
		if (!is_array($vars))
		{
			$vars = array();
		}
		$this->public_variables = $vars;
	}
	
	/**
	 * Return the array of public variables
	 *
	 * @return array
	 */
	public function getPublicVariables()
	{
		return $this->public_variables;
	}
	
	/**
	 * Add public variable
	 *
	 * @param string $var
	 */
	public function addPublicVariable($var)
	{
		$this->public_variables[] = $var;
	}
	
	/**
	 * Set filter include option
	 *
	 * @param bool $include
	 */
	public function setFilterIncludeOption($include)
	{
		$this->filter_include = $include;
	}

	/**
	 * Return TRUE if this URL is allow
	 * to include
	 *
	 * @return bool
	 */
	public function isAllow()
	{
		return $this->filter_include;
	}
	
	/**
	 * Match the URL with pattern
	 *
	 * @param string $url
	 * @return bool
	 */
	public abstract function match($url);
}

/**
 * Simple filter, compare by host and path of the URL
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
class URL_Filter_Simple extends URL_Filter
{
	protected $host,$path,$check_www;
	
	public function __construct($host,$path=null,$check_www=true,$include=true)
	{
		if ($check_www && substr($host,0,4) == "www.")
		{
			$host = substr($host,4);
		}
		
		if ($path != null)
		{
			$path = strtolower($path);
		}
		
		$this->host = strtolower($host);
		$this->path = $path;
		$this->check_www = $check_www;
		$this->setFilterIncludeOption($include);
	}
	
	public function match($url)
	{
		$bits = @parse_url($url);
		$host = strtolower(@$bits['host']);
		$path = strtolower(@$bits['path']);
		
		if ($host != $this->host && ($this->check_www && $host != "www." . $this->host))
		{
			return false;
		}
		
		if ($this->path !== null)
		{
			if (substr($path,0,strlen($this->path)) != $this->path)
			{
				return false;
			}
		}
		
		return true;
	}
}

/*----------------------------------------
 Encoder class
----------------------------------------*/

/**
 * Encoder Interface
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
interface URL_Encoder
{
	public function encodeString($string);
	public function decodeString($string);
	public function isValidEncodedString($string);
}

/**
 * Base64 encoder
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
class URL_Encoder_Base64 implements URL_Encoder
{
	public function encodeString($string)
	{
		return base64_encode($string);
	}
	
	public function decodeString($string)
	{
		return base64_decode($string);
	}
	
	public function isValidEncodedString($string)
	{
		return true;
	}
}

/**
 * Encoder using XOR Algorism
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
class URL_Encoder_XOR implements URL_Encoder
{
	protected $key = "";
	protected $use_hash = false;
	protected $seperator = ":";
	
	/**
	 * Constructor
	 *
	 * @param string $key
	 * @param bool $use_hash
	 */
	public function __construct($key,$use_hash=true)
	{
		$this->key = $key;
		$this->use_hash = $use_hash;
	}
	
	public function encodeString($string)
	{
		$crypt = $this->crypt($string,$this->key);
		
		if ($this->use_hash)
		{
			$crypt .= $this->seperator . $this->hash($crypt);
		}
		
		return base64_encode($crypt);
	}
	
	public function decodeString($string)
	{
		$string = base64_decode($string);
		
		if ($this->use_hash)
		{
			$string = explode($this->seperator,$string);
			if (count($string) < 2) return null;
			array_pop($string); //remove hash string
			$string = implode($this->seperator,$string);
		}
		
		return $this->crypt($string,$this->key);
	}
	
	public function isValidEncodedString($string)
	{
		if ($this->use_hash)
		{
			$string = base64_decode($string);
			
			$string = explode($this->seperator,$string);
			if (count($string) < 2) return false;
			$hash = array_pop($string); //remove hash string
			$string = implode($this->seperator,$string);
			
			if ($hash != $this->hash($string))
			{
				return false;
			}
		}
		
		return true;
	}
	
	protected function hash($text)
	{
		return dechex(crc32(md5($text) . md5($this->key)));
	}
	
	protected function crypt($text,$key)
	{
		$key = md5($key);
		$crypt = "";
		$j = 0;
		$k = strlen($key);
		
		for ($i=0;$i<strlen($text);$i++)
		{
			$crypt .= chr(ord($text[$i]) ^ ord($key[$j]));
			
			$j++;
			if ($j >= $k) $j = 0;
		}
		
		return $crypt;
	}
}

/*----------------------------------------
 Callback function, used by PHP functions
----------------------------------------*/
 
function __secureURL_output_callback($content)
{
	$content = preg_replace_callback('/(href|src|action)=(["\'])([^<>]+)\\2/iU' , '__secureURL_regexp_callback1' , $content);
	$content = preg_replace_callback('/(href|src|action)=([^" <>\']+)/iU' , '__secureURL_regexp_callback2' , $content);
	
	return $content;
}

function __secureURL_regexp_callback1($matches)
{
	$url = $matches['3'];
	$url = SecureURL::processURL($url);
	return $matches[1] . "=\"" . $url . "\"";
}

function __secureURL_regexp_callback2($matches)
{
	$url = $matches['2'];
	$url = SecureURL::processURL($url);
	return $matches[1] . "=\"" . $url . "\"";
}

?>