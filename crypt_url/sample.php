<?php

if (substr(phpversion(),0,1) == 5)
{
	include_once("secureURL.php");
}
else
{
	include_once("secureURL_php4.php");
}

class URL_Parser_JavaScript extends URL_Parser
{
	var $js = "javascript:gotopage";
	
	function isReadable($text)
	{
		if (strtolower(substr($text,0,strlen($this->js))) == $this->js)
		{
			return true;
		}
		
		return false;
	}
	
	function Read($text)
	{
		$url = substr($text,strlen($this->js) + 2); // ("
		$url = substr($url,0,strlen($url) - 3); // ");
		
		$url = str_replace("\\\"","\"",$url);
		$url = str_replace("\\'","'",$url);
		$url = html_entity_decode($url);
		
		return $url;
	}
	
	function Render($url)
	{
		$url = addslashes($url);
		
		return $this->js . "('" . $url . "');";
	}
}


SecureURL::setFilterIncludeOption(true); //Encode the URL when no filter matches it
SecureURL::addFilter(new URL_Filter_Simple("google.com",null,true,false)); //remove google from list
SecureURL::addParser(new URL_Parser_JavaScript());
SecureURL::Initialize(new URL_Encoder_Base64());

if (count($_GET))
{
	echo "<pre>";
	print_r($_GET);
	echo "</pre>";
}

?>
<html>
<head>
	<title>SecureURL Example</title>
	<script language="javascript">
	function gotopage(url)
	{
		window.location = url;
	}
	</script>
</head>
<body>
<h3>SecureURL Example</h3>
This is an example of using secureURL class.<br/>
All URL parameters are encoded automatically, like this <a href="sample.php?query=hello world">one</a>.<br/>
This <a href="sample.php?var=an%20other%20link">link</a> is also encoded.But this <a href="http://www.google.com/search?q=phpclasses">link</a> is not because it has been filtered.<br/><br/>
To use this class, just include secureURL.php and add to your file :<br/><br/>

<code><span style="color: #000000">
<span style="color: #0000BB">SecureURL::Initialize</span>(<i><span style="color: #ABABAB">$encoder</span><span style="color: #007700"></i>);&nbsp;</span><span style="color: #0000BB"></span>
</span>
<br/><br/>

<i>$encoder</i> must be an URL_Encoder subclass, secureURL use <i>$encoder</i> to encode the URL<br/>
secureURL comes with 2 encoders : <b>URL_Encoder_Base64</b> (using base64 algorism)<br>
and <b>URL_Encoder_XOR</b> (using XOR encryption with hashing). I recommend you to use <br/>
URL_Encoder_XOR for security reason, or you can write your own encoder class.<br>
<br>
Here is the interface of URL_Encoder class : <br/><br/>

<code><span style="color: #000000">
<span style="color: #0000BB"></span><span style="color: #007700">interface&nbsp;</span><span style="color: #0000BB">URL_Encoder<br /></span><span style="color: #007700">{<br />&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;</span><span style="color: #0000BB">encodeString</span><span style="color: #007700">(</span><span style="color: #0000BB">$string</span><span style="color: #007700">);<br />&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;</span><span style="color: #0000BB">decodeString</span><span style="color: #007700">(</span><span style="color: #0000BB">$string</span><span style="color: #007700">);<br />&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;</span><span style="color: #0000BB">isValidEncodedString</span><span style="color: #007700">(</span><span style="color: #0000BB">$string</span><span style="color: #007700">);<br />}<br /><br /></span><span style="color: #0000BB"></span>
</span></code>

You can use filter to control which url will be encoded and which url won't be. The filter is implement<br>
as <i>URL_Filter</i> subclass.i have already implement <i>URL_Filter_Simple</i> class which is a simple filter<br>
based on domain and path. An example of using filter to protect your URL while keeping others unencoded. <br><br>

<code><span style="color: #000000">
<span style="color: #0000BB">SecureURL</span><span style="color: #007700">::</span><span style="color: #0000BB">setFilterIncludeOption</span><span style="color: #007700">(</span><span style="color: #0000BB">false</span><span style="color: #007700">);&nbsp;</span><span style="color: #FF8000">//exculde&nbsp;all&nbsp;URL<br /></span><span style="color: #0000BB">SecureURL</span><span style="color: #007700">::</span><span style="color: #0000BB">addFilter</span><span style="color: #007700">(new&nbsp;</span><span style="color: #0000BB">URL_Filter_Simple</span><span style="color: #007700">(</span><span style="color: #DD0000">"yourdomain.com"</span><span style="color: #007700">,</span><span style="color: #DD0000">"yourpath"</span><span style="color: #007700">));&nbsp;</span><span style="color: #FF8000">//add&nbsp;your&nbsp;site&nbsp;to&nbsp;filter&nbsp;list<br /></span><span style="color: #0000BB">SecureURL</span><span style="color: #007700">::</span><span style="color: #0000BB">Initialize</span><span style="color: #007700">(new&nbsp;</span><span style="color: #0000BB">URL_Encoder_XOR</span><span style="color: #007700">(</span><span style="color: #DD0000">"password"</span><span style="color: #007700">));<br /><br /></span><span style="color: #0000BB"></span>

</span>
</code>

secureURL allows you to add URL parser to read custom styles of URL. This is <a href='javascript:gotopage("sample.php?this=1&is=1&an=1&example=1");'>an example</a> of custom URL format.<br>
You can get more information about using this class by reading its source and example.<br>
If you have any questions, suggestions, or find any bugs, feel free to contact <a href="mailto:quocbao.coder@gmail.com">me</a> :)

</body>
</html>