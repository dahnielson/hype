<?php
/**
 * @package Hype
 * @subpackage UnitTests
 */

require_once('../active_record.php');

/**
 * @ignore
 */
class ActiveRecordTest extends UnitTestCase
{
	function ActiveRecordTest()
	{
		$this->UnitTestCase('ActiveRecord test');
	}

	function testActiveRecord()
	{
		$record = new ActiveRecord();
		$this->assertNotNull($record);
	}
}

?>