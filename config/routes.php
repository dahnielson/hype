<?php
// The priority is based upon order of creation: first created -> highest priority.

// You can have the root of your site routed by hooking up ''
// $map->connect('', 'controller=welcome');

// Allow downloading Web Service WSDL as a file with an extension
// instead of a file named 'wsdl'
// $map->connect(':controller/service.wsdl', 'action=wsdl');

// Install the default route as the lowest  priority
$map->connect(':controller/:action/:id');
?>