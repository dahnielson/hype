<?php
/**
 * @package Hype
 * @subpackage UnitTests
 */

require_once('../action_router.php');

/**
 * @ignore
 */
class ActionRouterTest extends UnitTestCase
{
	function ActionRouterTest()
	{
		$this->UnitTestCase('ActionRouter test');
	}

	function testActionRouter()
	{
		$router = new ActionRouter();
		$this->assertNotNull($router);
	}
}

?>