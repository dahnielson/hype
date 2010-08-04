<?php
/**
 * ActionRouter
 *
 * @author Anders Dahnielson <anders@dahnielson.com>
 * @copyright Anders Dahnielson 2006
 * @package Hype
 */

/**
 * ActionRouter
 *
 * @package Hype
 */
class ActionRouter 
{
	/**#@+
	 * @access private
	 * @var array
	 */
	var $_routes;
	var $_search;
	var $_replace;
	/**#@-*/
	
	var $pattern;
	var $regex;
	var $controller;
	var $action;
	var $id;
	var $type;
	var $resource;
	var $controller_template;
	var $action_template;

	function ActionRouter()
	{
		$this->_routes = array();

		$this->_search = array(
			'/',
			'-',
			'.',
			':controller',
			':action',
			':id',
			':type',
			':resource'
			);

		$this->_replace = array(
			'\/?',
			'-?',
			'\.?',
			'([a-z]+)',
			'([a-z]*)',
			'([0-9]*)',  
			'([a-z]*)',
			'([a-z]*)'
			);

		$this->pattern = "";
		$this->regex = "";
		$this->controller = "";
		$this->action = "";
		$this->id = 0;
		$this->type = "";
		$this->resource = "";
		$this->controller_template = "";
		$this->action_template = "";
	}

	/**
	 * Create route for requests
	 * @param string $pattern route pattern
	 * @param string $params optional action parameters
	 */
	function connect($pattern, $params='')
	{
		$args = parse_params($params);

		$this->_routes[] = array( 
			'pattern' => $pattern,
			'regex' => '/^\\'.REWRITEBASE.'\/'.str_replace($this->_search, $this->_replace, $pattern).'$/',
			'controller' => $args['controller'],
			'action' => $args['action']
			);
	}

	/**
	 * Resolve request URI to action parameters
	 * @param string $request_uri request uri
	 */
	function resolve($request_uri)
	{
		if (!($pos = strpos($request_uri, '?')) === false)
			$request_uri = substr($request_uri, 0, $pos);
		
		foreach ($this->_routes as $route)
		{
			if (preg_match($route['regex'], $request_uri, $results))
			{
				$maps = array();
				if (!(($pos = strpos($route['pattern'], ':controller')) === false))
					$maps['controller'] = $pos;
				if (!(($pos = strpos($route['pattern'], ':action')) === true))
					$maps['action'] = $pos;
				if (!(($pos = strpos($route['pattern'], ':id')) === true))
					$maps['id'] = $pos;
				if (!(($pos = strpos($route['pattern'], ':type')) === true))
					$maps['type'] = $pos;
				if (!(($pos = strpos($route['pattern'], ':resource')) === true))
					$maps['resource'] = $pos;
				$maps = array_diff($maps, array(''));
				asort( $maps );
				$maps = array_keys($maps);

				$this->pattern = $route['pattern'];
				$this->regex = $route['regex'];
				$this->controller = $route['controller'];
				$this->action = $route['action'];

				$i = 1;
				foreach ($maps as $map)
				{
					$this->$map = $results[$i];
					$i += 1;
				}

				if ( empty($this->action) ) $this->action = 'index';
				if ( empty($this->type) ) $this->type = 'html';
				$this->controller_template = $this->controller;
				$this->action_template = $this->action;
			}
		}
	}

	/**
	 * Build a request URI from action parameters
	 * @param $params optional action parameters
	 * @return request uri
	 */
	function build($params)
	{
		$search = $this->_search;
		$search[] = '//';

		$replace = array(
			'/', 
			'-', 
			'.',
			$this->controller,
			($this->action == 'index') ? '' : $this->action,
			$this->id,
			$this->type,
			$this->resource,
			'/'
			);
		
		if (!empty($params))
		{
			$args = parse_params($params);

			if (array_key_exists('controller', $args))
			{
				$replace[3] = $args['controller'];
				$replace[4] = '';
				unset($args['controller']);
			}
			if (array_key_exists('action', $args))
			{
				$replace[4] = ($args['action'] == 'index') ? '' : $args['action'];
				unset($args['action']);
			}
			if (array_key_exists('id', $args))
			{
				$replace[5] = $args['id'];
				unset($args['id']);
			}
			if (array_key_exists('type', $args))
			{
				$replace[6] = $args['type'];
				unset($args['type']);
			}
			if (array_key_exists('resource', $args))
			{
				$replace[7] = $args['resource'];
				unset($args['resource']);
			}

			if (!empty($args))
				$query = "?".http_build_query($args);
			else
				$query = '';
		}

		//FIXME: Also params not represented in the current
		//       pattern should be included in the query string.
		
		return str_replace($search, $replace, REWRITEBASE.'/'.$this->pattern) . $query;
	}
}
?>