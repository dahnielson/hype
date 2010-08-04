<?php
/**
 * @package Hype
 * @subpackage UnitTests
 */

require_once('../action_view.php');

/**
 * @ignore
 */
class ActionViewTest extends UnitTestCase
{
	function ActionViewTest()
	{
		$this->UnitTestCase('ActionView test');
	}

	function testActionView()
	{
		$view = new ActionView();
		$this->assertNotNull($view);
	}
}

?>