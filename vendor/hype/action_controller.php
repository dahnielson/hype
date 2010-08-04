<?php
/**
 * ActionController
 *
 * @author Anders Dahnielson <anders@dahnielson.com>
 * @copyright Anders Dahnielson 2006
 * @package Hype
 */

/**
 * ActionController
 *
 * @package Hype
 */
class ActionController
{
	/**#@+
	 * @access private
	 * @var array
	 */
	var $_store = array();
	var $_globals = array();
	/**#@-*/

	function ActionController()
	{
		ActionController::__construc();
	}

	/**
	 * The constructor calls the requested action.
	 */
	function __construct()
	{
		if ( !method_exists($this, $GLOBALS['map']->action) )
			redirect_to_404();

		$action = $GLOBALS['map']->action;

		if ( strtoupper($this->verify['method']) != $_SERVER['REQUEST_METHOD'] )
			if ( in_array($action, $this->verify['only']) )
				$this->redirect_to($this->verify['redirect_to']);
		
		$this->_store = array_keys($GLOBALS);
		$this->$action();
		$this->_globals = array_intersect_key(
			$GLOBALS, 
			array_flip( 
				array_diff( array_keys($GLOBALS), $this->_store )
				) 
			);
		unset($this->_store);
	}

	/**
	 * Default action.
	 */
	function index()
	{
	}

	/**
	 * Returns a URL that has been rewritten according to the parameters and the defined routes.
	 * @param string $params parameters
	 * @return string url
	 */
	function url_for($params)
	{
		return url_for($params);
	}

	/**
	 * Render specified page.
	 * @param string $params parameters
	 */
	function render($params)
	{
		$args = parse_params($params);

		if (!empty($args['action']))
			$GLOBALS['map']->action_template = $args['action'];

		if (!empty($args['layout']))
			$GLOBALS['map']->controller_template = $args['layout'];

		if (!empty($args['type']))
			$GLOBALS['map']->type = $args['type'];
	}

	/**
	 * Redirects the browser to the specified target.
	 * @param string $params Parameters
	 */
	function redirect_to($params)
	{
		$url = $this->url_for($params);
		header("Location: $url");
		exit;
	}

	/**
	 * Return param string for specified parameter.
	 * @param string $label Label identifying the parameter to be returned
	 */
	function params($label)
	{
		$data = array();

		if ($label == 'id')
		{
			$data['id'] = $GLOBALS['map']->id;
		}
		elseif ($label == 'action')
		{
			$data['action'] = $GLOBALS['map']->action;
		}
		elseif ($label == 'controller')
		{
			$data['controller'] = $GLOBALS['map']->controller;
		}
		elseif ($label == 'resource')
		{
			$data['resource'] = $GLOBALS['map']->resource;
		}
		elseif (array_key_exists($label, $_POST))
		{
			if (is_array($_POST[$label]))
				$data = $_POST[$label];
			else
				$data[$label] = $_POST[$label];
		}
		elseif (array_key_exists($label, $_GET))
		{
			if (is_array($_GET[$label]))
				$data = $_GET[$label];
			else
				$data[$label] = $_GET[$label];
		}
		
		return build_params($data);
	}

}
?>