<?php
/**
 * FormHelper
 *
 * Template tags related to HTML forms.
 *
 * @author Anders Dahnielson <anders@dahnielson.com>
 * @copyright Anders Dahnielson 2006
 * @package Hype
 * @subpackage ActionViewHelpers
 */

/**
 * <?tpl form name="foobar" controller="mycontroller" action="myaction" method="post" ?>
 */
function hype_tpl_start_form_tag($args, &$tpl)
{
	$base = REWRITEBASE;
	$controller = (empty($args['controller'])) ? $GLOBALS['map']->controller : $args['controller'];
	$action = $args['action'];
	$method = (empty($args['method'])) ? 'post' : $args['method'];

	if (!empty($args['name']))
		$name = 'name="'.$args['name'].'"';

	return "<form $name action=\"$base/$controller/$action\" method=\"$method\" >";
}

$view->register_function('form', 'hype_tpl_start_form_tag');

/**
 * <?tpl /form ?>
 */
function hype_tpl_end_form_tag($args, &$tpl)
{
	return '</form>';
}

$view->register_function('/form', 'hype_tpl_end_form_tag');

/**
 * <?tpl text_field name="foo[bar]" value="somevalue" ?>
 */
function hype_tpl_text_field($args, &$tpl)
{
	$id = str_replace(array('[', ']'), array('_', ''), $args['name']);
	$name = $args['name'];
	$value = $args['value'];

	return "<input id=\"$id\" type=\"text\" name=\"$name\" value=\"$value\" />";
}

$view->register_function('text_field', 'hype_tpl_text_field');

/**
 * <?tpl submit name="foobar" value="somevalue" ?>
 */
function hype_tpl_submit($args, &$tpl)
{
	$id = $args['name'];
	$name = $args['name'];

	$value = $args['value'];
	if (empty($value))
		$value = "Submit";

	return "<input id=\"$id\" type=\"submit\" name=\"$name\" value=\"$value\" />";
}

$view->register_function('submit', 'hype_tpl_submit');

?>