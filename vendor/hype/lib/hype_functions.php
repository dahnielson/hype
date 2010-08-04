<?php
/**
 * HypeFunctions
 *
 * @author Anders Dahnielson <anders@dahnielson.com>
 * @copyright Anders Dahnielson 2006
 * @package Hype
 * @subpackage HypeFunctions
 */

/**
 * Parse param string into an args array
 * @param string $params parameters
 * @return array arguments
 */
function parse_params($params)
{
	parse_str($params, $args);
	return $args;
}

/**
 * Build a param string from an args array
 * @param array $args arguments
 * @return string parameters
 */
function build_params($args)
{
	return http_build_query($args);
}

/**
 * Redirect to a 404 Not Found
 */
function redirect_to_404()
{
 	if (file_exists(HYPE_ROOT.'/public/404.html'))
 	{
 		// Fancy ErrorDoc
 		header('HTTP/1.1 404 Not Found');
 		$GLOBALS['view']->template_dir = HYPE_ROOT.'/public/';
 		$GLOBALS['view']->display('404.html');
 		exit;
 	}
 	else
 	{
		// Not-so-fancy ErrorDoc
		header('HTTP/1.1 404 Not Found');
		echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><HTML><HEAD><TITLE>404 Not Found</TITLE></HEAD><BODY><H1>Not Found</H1>The requested URL '.$_SERVER['REQUEST_URI'].' was not found on this server.<P><HR>'.$_SERVER['SERVER_SIGNATURE'].'</BODY></HTML>';
		exit;
	}
}

/**
 * Redirect to a 500 Internal Server Error
 */
function redirect_to_500()
{
 	if (file_exists(HYPE_ROOT.'/public/500.html'))
 	{
 		// Fancy ErrorDoc
 		header('HTTP/1.1 500 Internal Server Error');
 		$GLOBALS['view']->template_dir = HYPE_ROOT.'/public/';
 		$GLOBALS['view']->display('500.html');
 		exit;
 	}
 	else
 	{
		// Not-so-fancy ErrorDoc
		header('HTTP/1.1 500 Internal Server Error');
		echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><HTML><HEAD><TITLE>500 Application Error</TITLE></HEAD><BODY><H1>Application Error</H1>The application encountered an internal error and was unable to fulfill the request.<P><HR>'.$_SERVER['SERVER_SIGNATURE'].'</BODY></HTML>';
		exit;
	}
}

/**
 * Fix any trailing slashes and redirect
 * @param string $request_uri request uri
 * @return boolean return false if no redirection was needed
 * @deprecated
 */
function fix_trailing_slash($request_uri)
{
	$uri = $GLOBALS['map']->build();
	if ($uri != $request_uri)
	{
		$host = $_SERVER['HTTP_HOST'];
		$query = empty($_SERVER['QUERY_STRING']) ? '' : '?'.$_SERVER['QUERY_STRING'];

		if ($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: http://$host$uri$query");
			exit;
		}
	}

	return false;
}

/**
 * Returns a URL that has been rewritten according to the parameters
 * and the defined routes.
 * @param string $params parameters
 * @return string url
 */
function url_for($params)
{
	$args = parse_params($params);
	
	$protocol = (isset($args['protocol'])) ? $args['protocol'] : 'http';
	$host = (isset($args['host'])) ? $args['host'] : $_SERVER['HTTP_HOST'];
	$url = $GLOBALS['map']->build($params);
	$anchor = (isset($args['anchor'])) ? '#'.$args['anchor'] : '';
	
	if ($args['only_path'])
		return "$url$anchor";
	else
		return "$protocol://$host$url$anchor";
}

?>