<?php
/**
 * @package Hype
 * @subpackage UnitTests
 */

require_once('../action_controller.php');

/**
 * @ignore
 */
class ActionControllerTest extends UnitTestCase
{
	function ActionControllerTest()
	{
		$this->UnitTestCase('ActionController test');
	}

	function testActionController()
	{
		$controller = new ActionController();
		$this->assertNotNull($controller);
	}
}

?>