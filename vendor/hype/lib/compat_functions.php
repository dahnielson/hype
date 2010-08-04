<?php
/**
 * CompatFunctions
 *
 * @author Anders Dahnielson <anders@dahnielson.com>
 * @copyright Anders Dahnielson 2006
 * @package Hype
 * @subpackage HypeFunctions
 */

/**
 * @ignore
 */
include('Compat/Function/array_intersect_key.php');

if(!function_exists('str_split'))
{
	/**
	 * @ignore
	 */
	function str_split($string, $split_length=1) { 
		$count = strlen($string);  
		if ($split_length < 1)
		{ 
			return false;  
		} 
		elseif ($split_length > $count)
		{ 
			return array($string); 
		} 
		else 
		{ 
			$num = (int)ceil($count/$split_length);  
			$ret = array();  
			for($i=0;$i<$num;$i++)
			{  
				$ret[] = substr($string,$i*$split_length,$split_length);  
			}  
			return $ret; 
		}      
	}
}

if (!function_exists('http_build_query')) 
{
	/**
	 * @ignore
	 */
	function http_build_query( $formdata, $numeric_prefix = null, $key = null ) {
		$res = array();
		foreach ((array)$formdata as $k=>$v) 
		{
			$tmp_key = urlencode(is_int($k) ? $numeric_prefix.$k : $k);
			if ($key) $tmp_key = $key.'['.$tmp_key.']';

			if ( is_array($v) || is_object($v) ) 
			{
				$res[] = http_build_query($v, null, $tmp_key);
			} 
			else 
			{
				$res[] = $tmp_key."=".urlencode($v);
			}
		}
		$separator = ini_get('arg_separator.output');
		return implode($separator, $res);
	}
}

?>