<?php
/**
 * @package Hype
 * @subpackage UnitTests
 */

$base = dirname(__FILE__).'/../..';

require_once("$base/simpletest/unit_tester.php");
require_once("$base/simpletest/reporter.php");

$test = &new GroupTest('Hype tests');
$test->addTestFile('action_router_test.php');
//$test->addTestFile('action_controller_test.php');
//$test->addTestFile('action_view_test.php');
//$test->addTestFile('active_record_test.php');
$test->run(new HtmlReporter());

?>