<?php
/**
 * UrlHelper
 *
 * @author Anders Dahnielson <anders@dahnielson.com>
 * @copyright Anders Dahnielson 2006
 * @package Hype
 * @subpackage ActionViewHelpers
 */

function hype_tpl_link_to($args, &$tpl)
{
	$text = $args['text']; unset($args['text']);
	$attrs = parse_params($args['attrs']); unset($args['attrs']);
	$url = url_for(build_params($args));

	foreach ($attrs as $key => $value)
		$attributes = $attributes . " $key=\"$value\"";
	
	return "<a href=\"$url\"$attributes>$text</a>";
}

$view->register_function('link_to', 'hype_tpl_link_to');

?>