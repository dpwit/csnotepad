<?
/**
* @package BozBoz_CMS
*/

	class SuccessTest extends BaseTest {
		function run(){
			return true;
		}
	}
	class FailureTest extends BaseTest {
		function run(){
			$this->fail("Intentional Failure");
			return true;
		}
	}
	class ExceptionTest extends BaseTest {
		function run(){
			throw new Exception("Intentional Exception");
		}
	}
	class SelfFailingSuite extends BaseTestSuite {
		function __construct(){
			parent::__construct("BOGUS",array('badMethod'));
		}
		function badMethod(){
			$this->fail("Intentional Failure");
		}
	}
	class SelfSucceedingSuite extends BaseTestSuite {
		function __construct(){
			parent::__construct("BOGUS",array('goodMethod'));
		}
		function goodMethod(){
			return true;
		}
	}
	class UnitTestTestSuite extends BaseTestSuite {
		function __construct(){
			parent::__construct('Unit Test Tester', array('successTest','failureTest','exceptionTest'));
		}

		function successTest($test){
			$suite = new BaseTestSuite('',array(new SuccessTest()));
			if(!$suite->success()) {
				$test->fail("Success Test Suite Did Not Succeed");
			}
			return true;
		}

		function failureTest($test){
			$suite = new BaseTestSuite('',array(new FailureTest()));
			if($suite->success()) 
				$test->fail("Failure Test Suite Succeeded");
			return true;

		}
		function exceptionTest($test){
			$suite = new BaseTestSuite('',array(new ExceptionTest()));
			if(@$suite->success()) 
				$test->fail("Exception Test Suite Succeeded");
			return true;
		}
	}
?>
