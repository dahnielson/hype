<?php
/**
 * JavascriptHelper
 *
 * @author Anders Dahnielson <anders@dahnielson.com>
 * @copyright Anders Dahnielson 2006
 * @package Hype
 * @subpackage ActionViewHelpers
 */

function hype_tpl_javascript_include_tag($args, &$tpl)
{
	$src = REWRITEBASE.'/javascripts/'.$args['script'].'.js';
	return "<script type=\"text/javascript\" src=\"$src\"></script>";
}

$view->register_function('javascript_include', 'hype_tpl_javascript_include_tag');

?>