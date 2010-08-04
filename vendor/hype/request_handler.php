<?php
/**
 * RequestHandler
 *
 * @author Anders Dahnielson <anders@dahnielson.com>
 * @copyright Anders Dahnielson 2006
 * @package Hype
 */

ob_start();

// Paths
define('APP_ROOT', HYPE_ROOT.'/app');
define('CONFIG_ROOT', HYPE_ROOT.'/config');
define('LIB_ROOT', HYPE_ROOT.'/lib');
define('TMP_ROOT', HYPE_ROOT.'/tmp');
define('VENDOR_ROOT', HYPE_ROOT.'/vendor');
ini_set('include_path', ini_get('include_path').':'.LIB_ROOT.':'.VENDOR_ROOT.':');

// Functions
include('hype/lib/compat_functions.php');
include('hype/lib/hype_functions.php');

// Routes -- connect and resolve
include('hype/action_router.php');
/**
 * Global singleton mapping requests to controllers and actions
 * @global object $map
 */
$map = new ActionRouter();
include(CONFIG_ROOT.'/routes.php');
$map->resolve($_SERVER['REQUEST_URI']);

// Database -- initiate the database
include('adodb_lite/adodb.inc.php');
include(CONFIG_ROOT.'/database.php');
/**
 * Global singleton handling the database connection.
 * @global object $database
 */
$database = ADONewConnection(DB_ADAPTER);
$database->PConnect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$database->debug = false;

// Template -- initiate the view
include('smarty/Smarty.class.php');
include('hype/action_view.php');
/**
 * Global singleton handling the view.
 * @global object $view
 */
$view = new ActionView();

// Model -- include the models
include('hype/active_record.php');
foreach (glob(APP_ROOT.'/models/*.php') as $filename) include($filename);

// Controller -- initiate the controller
include('hype/action_controller.php');
include(APP_ROOT.'/controllers/'.$map->controller.'_controller.php');
$controller_class = ucwords($map->controller).'Controller';
if ( !class_exists($controller_class) ) redirect_to_404();
$controller = new $controller_class();

// View -- display the view
$view->template_dir = APP_ROOT.'/views/'.$map->controller_template.'/';
if (!$view->template_exists($map->action_template.'.'.$map->type)) redirect_to_500();
$view->assign($controller->_globals);
include(CONFIG_ROOT.'/mime.php');
header('Content-type: '.$MIME[$map->type]);
foreach (glob(VENDOR_ROOT.'/hype/action_view/helpers/*_helper.php') as $filename) @include($filename);
@include(APP_ROOT.'/helpers/'.$map->controller_template.'_helper.php');
$view->display($map->action_template.'.'.$map->type);

ob_end_flush();

?>