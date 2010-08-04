<?php
/**
 * ViewHelper
 *
 * @author Anders Dahnielson <anders@dahnielson.com>
 * @copyright Anders Dahnielson 2006
 * @package Hype
 * @subpackage ActionViewHelpers
 */

$view->assign('hype', array(
		      'base' => REWRITEBASE,
		      'controller' => $map->controller,
		      'action' => $map->action,
		      'id' => $map->id,
		      'type' => $map->type,
		      'resource' => $map->resource,
		      'query' => $_GET
		      )
	);

?>