<?php

/**
 * SecureURL (PHP4 version)
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
	var $filters = array();
	
	/**
	 * URL Parser
	 *
	 * @var array of URL_Parser
	 */
	var $parsers = array();
	
	/**
	 * Encoder
	 *
	 * @var Encoder
	 */
	var $encoder = null;
	
	/**
	 * Query key
	 *
	 * @var string
	 */
	var $query_key = "crypt";
	
	/**
	 * Public variables array
	 *
	 * @var string
	 */
	var $public_variables = array();
	
	/**
	 * Default include flag for filter checking
	 *
	 * @var bool
	 */
	var $default_filter_include = true;
	
	/**
	 * ForceEncode option
	 *
	 * @var bool
	 */
	var $force_encode_url = true;
	
	/**
	 * ProtectMode option
	 *
	 * @var bool
	 */
	var $protect_mode = true;
	
	/**
	 * Initialize SecureURL class
	 *
	 * @param URL_Encoder $encoder
	 */
	function Initialize($encoder)
	{
		$secureURL = &secureURL::getInstanse();
		
		$secureURL->encoder = $encoder;
		$public_variables = $secureURL->public_variables;
		$query_key = $secureURL->query_key;
		$protect_mode = $secureURL->protect_mode;
		
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
	function setPublicVariables($vars)
	{
		$secureURL = &secureURL::getInstanse();
		
		if (!is_array($vars))
		{
			$vars = array();
		}
		$secureURL->public_variables = $vars;
	}
	
	/**
	 * Add public variable
	 *
	 * @param string $var
	 */
	function addPublicVariable($var)
	{
		$secureURL = &secureURL::getInstanse();
		
		$secureURL->public_variables[] = $var;
	}
	
	/**
	 * Set query key
	 *
	 * @param string $key
	 */
	function setQueryKey($key)
	{
		$secureURL = &secureURL::getInstanse();
		$secureURL->query_key = $key;
	}
	
	/**
	 * When no filter matchs the given URL
	 * secureURL will use this option to decide
	 * whether to encode the URL or not
	 *
	 * @param bool $include
	 */
	function setFilterIncludeOption($include)
	{
		$secureURL = &secureURL::getInstanse();
		$secureURL->default_filter_include = $include;
	}
	
	/**
	 * Force secureURL to encode URL through their are
	 * no parser can read the text
	 *
	 * @param bool $force
	 */
	function setForceEncodeOption($force)
	{
		$secureURL = &secureURL::getInstanse();
		$secureURL->force_encode_url = $force;
	}
	
	/**
	 * Enable protect mode
	 * When protect mode is enabled, only encrypted
	 * variables and public variables are accepted
	 *
	 * @param bool $enable
	 */
	function setProtectMode($enable)
	{
		$secureURL = &secureURL::getInstanse();
		$secureURL->protect_mode = $enable;
	}
	
	/**
	 * Add an URL Filter
	 *
	 * @param URL_Filter $filter
	 */
	function addFilter($filter)
	{
		$secureURL = &secureURL::getInstanse();
		$secureURL->filters[] = $filter;
	}
	
	/**
	 * Add an URL Parser
	 *
	 * @param URL_Parser $parser
	 */
	function addParser($parser)
	{
		$secureURL = &secureURL::getInstanse();
		$secureURL->parsers[] = $parser;
	}
	
	/**
	 * Process URL and encode it
	 *
	 * @param string $url
	 * @return string
	 */
	function processURL($url)
	{
		$secureURL = &secureURL::getInstanse();
		
		/* @var $filter URL_Filter */
		$parser = null;
		$filter = null;
		
		$url = html_entity_decode($url);
		
		foreach ($secureURL->parsers as $check_parser)
		{
			if ($check_parser->isReadable($url))
			{
				$parser = $check_parser;
				break;
			}
		}
		
		if ($parser == null)
		{
			if ($secureURL->force_encode_url)
			{
				$parser = new URL_Parser_Simple();
				$secureURL->parsers[] = $parser;
			}
			else
			{
				return $url;
			}
		}
		
		$read_url = $parser->Read($url);
		
		if (count($secureURL->filters))
		{
			foreach ($secureURL->filters as $check_filter)
			{
				if ($check_filter->match($read_url))
				{
					$filter = $check_filter;
					break;
				}
			}
		}
		
		if ((!isset($filter) && $secureURL->default_filter_include) || (isset($filter) && $filter->isAllow()))
		{
			$read_url = $secureURL->encodeURL($read_url,(isset($filter) ? $filter->getPublicVariables() : array()));
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
	function encodeURL($url,$public_variables=array())
	{
		$secureURL = &secureURL::getInstanse();
		
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
			$encoder =& $secureURL->encoder;
			$query = $secureURL->query_key . "=" . urlencode($encoder->encodeString($query)) . $public_query;
			//-- end encode --//
			
			$url = substr($url,0,$pos) . "?" . $query;
		}
		
		return $url;
	}
	
	function &getInstanse()
	{
		static $obj = null;
		if (!$obj)
		{
			$obj = new SecureURL();
		}
		
		return $obj;
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
class URL_Parser
{
	/**
	 * Return TRUE if the URL can be
	 * read by this parser
	 *
	 * @param string $text
	 * @return bool
	 */
	function isReadable($text) {}
	
	/**
	 * Read and return the URL
	 *
	 * @param string $url
	 * @return string
	 */
	function read($text) {}
	
	/**
	 * Rerender the text from URL
	 *
	 * @param string $url
	 * @return string
	 */
	function render($url) {}
}

/**
 * Default URL Reader
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
class URL_Parser_Simple extends URL_Parser
{
	function IsReadAble($text)
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
	
	function Read($text)
	{
		return $text;
	}
	
	function Render($url)
	{
		return $url;
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
class URL_Filter
{
	/**
	 * Public query variables
	 *
	 * @var array
	 */
	var $public_variables = array();
	
	/**
	 * Include this filter or not
	 *
	 * @var string
	 */
	var $filter_include = true;
	
	/**
	 * Set public variables
	 *
	 * @param array $vars
	 */
	function setPublicVariables($vars)
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
	function getPublicVariables()
	{
		return $this->public_variables;
	}
	
	/**
	 * Add public variable
	 *
	 * @param string $var
	 */
	function addPublicVariable($var)
	{
		$this->public_variables[] = $var;
	}
	
	/**
	 * Set filter include option
	 *
	 * @param bool $include
	 */
	function setFilterIncludeOption($include)
	{
		$this->filter_include = $include;
	}

	/**
	 * Return TRUE if this URL is allow
	 * to include
	 *
	 * @return bool
	 */
	function isAllow()
	{
		return $this->filter_include;
	}
	
	/**
	 * Match the URL with pattern
	 *
	 * @param string $url
	 * @return bool
	 */
	function match($url)
	{
		
	}
}

/**
 * Simple filter, compare by host and path of the URL
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
class URL_Filter_Simple extends URL_Filter
{
	var $host,$path,$check_www;
	
	function URL_Filter_Simple($host,$path=null,$check_www=true,$include=true)
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
	
	function match($url)
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
class URL_Encoder
{
	function encodeString($string)
	{
		
	}
	function decodeString($string)
	{
		
	}
	function isValidEncodedString($string)
	{
		
	}
}

/**
 * Base64 encoder
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
class URL_Encoder_Base64 extends URL_Encoder
{
	function encodeString($string)
	{
		return base64_encode($string);
	}
	
	function decodeString($string)
	{
		return base64_decode($string);
	}
	
	function isValidEncodedString($string)
	{
		return true;
	}
}

/**
 * Encoder using XOR Algorism
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 */
class URL_Encoder_XOR extends URL_Encoder
{
	var $key = "";
	var $use_hash = false;
	var $seperator = ":";
	
	/**
	 * Constructor
	 *
	 * @param string $key
	 * @param bool $use_hash
	 */
	function URL_Encoder_XOR($key,$use_hash=true)
	{
		$this->key = $key;
		$this->use_hash = $use_hash;
	}
	
	function encodeString($string)
	{
		$crypt = $this->crypt($string,$this->key);
		
		if ($this->use_hash)
		{
			$crypt .= $this->seperator . $this->hash($crypt);
		}
		
		return base64_encode($crypt);
	}
	
	function decodeString($string)
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
	
	function isValidEncodedString($string)
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
	
	function hash($text)
	{
		return dechex(crc32(md5($text) . md5($this->key)));
	}
	
	function crypt($text,$key)
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