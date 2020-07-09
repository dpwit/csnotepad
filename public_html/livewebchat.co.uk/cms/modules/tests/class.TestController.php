<?
/**
* @package BozBoz_CMS
*/


	interface Test {
		function getName();
		function success();
		function getFailureReason();
	}
	interface TestSuite extends Test{
		function tests();
	}

	abstract class BaseTest implements Test {
		function __construct($name=false){
			if(!$name) $name = get_class($this);
			$this->name = $name;
		}

		function getName(){ 
			return $this->name;
		}
		function fail($reason){
			$this->failureReason[] = $reason;
		}
		function getFailureReason(){
			return @join("\n",$this->failureReason);
		}

		function success(){
			try {
				$this->failureReason=array();
				if($this->run() && !$this->getFailureReason()) {
					return true;
				}
			} catch(Exception $e){
				if(error_reporting()){
					var_dump($e->getMessage());
					var_dump($e->getTraceAsString());
				}
				
				$this->fail($e->getMessage());
			}
		}

		abstract function run();

		function __call($func,$args){
			throw new Exception("Call to undefined function ".get_class($this).".$func");
		}

		function getCallingPosition(){
			$trace = debug_backtrace();
			$frame = $trace[2];
			return "$frame[file]:$frame[line] $frame[class].$frame[function]";
		}
		function assertEqual($v1,$v2,$message = ''){
			if($v1!=$v2){
				if(!$message) $message = "Assertion failed '$v1' != '$v2' in ".$this->getCallingPosition();
				$message = sprintf($message,$v1,$v2);
				echo "$message\n";
				throw new AssertionFailedException($message);
			}
		}
		function assert($v1,$message = ''){
			if(!$v1){
				if(!$message) $message = "Assertion failed '$v1' in ".$this->getCallingPosition();
				echo "$message\n";
				throw new AssertionFailedException($message);
			}
		}
	}
	class AssertionFailedException extends Exception{}
	class MethodCaller extends BaseTest {
		function __construct($obj,$method,$name=false){
			if(!$name) $name = $method;
			parent::__construct($name);
			$this->obj = $obj;
			$this->method = $method;
		}

		function run(){
			return call_user_func(array($this->obj,$this->method),$this);
		}
		function getFailureReason(){
			$fail = parent::getFailureReason();
			if($fail) return $fail;
			if(!method_exists($this->obj,$this->method)) 
				return "Possibly Missing Function ".get_class($this->obj).".".$this->method;
			return "";
		}
	}

	class BaseTestSuite implements TestSuite {
		function __construct($name = false,$tests = array()){
			if(!$name) $name=get_class($this);
			$this->name = $name;
			$this->tests = $tests;
		}
		function getName(){
			return $this->name;
		}
		function tests(){
			foreach($this->tests as $k=>$v)
				if(is_string($v))
					$this->tests[$k] = new MethodCaller($this,$v);
			return $this->tests;
		}

		function success(){
			$this->fail = array();
			foreach($this->tests() as $t){
				if(!$t->success())
					$this->fail[$t->getName()] = $t->getName()."\n".$t->getFailureReason();
			}
			return !$this->getFailureReason();
		}
		function getFailureReason(){
			return join("\n",$this->fail);
		}
		function __call($func,$args){
			throw new Exception("Call to undefined function ".get_class($this).".$func");
		}
	}


	class TestController extends Controller {
		function cms_runTests(){
			set_error_handler(array($this,'handle_error'));
			error_reporting(E_ALL);
			$suites = cms_apply_filter('get_test_suites',array());
			$this->runAll($suites);
		}
		function runAll($suites){
			$ran = 0;
			$success = 0 ;
			$failed = array();
			$failures = array();
			foreach($suites as $suite){
				echo "Running ".$suite->getName()."\n";
				$failed = array();
				foreach($suite->tests() as $test){
					$ran++;
					try {
						if($test->success()){
							$success++;
						} else {
							$failed[] = $test;
						}
					} catch(Exception $e){
						$failed[] = $test;
					}
				}
				if($failed) $failures[] = array('suite'=>$suite,'tests'=>$failed);
			}
			$this->showView('testResults',array('failures'=>$failures,'ran'=>$ran,'success'=>$success,'suites'=>$suites));
			restore_error_handler();
		}

		function cms_runTest($args){
			ini_set('display_errors','on');
			set_error_handler(array($this,'handle_error'));
			error_reporting(E_ALL);
			$suites = cms_apply_filter('get_test_suites',array());
			$name = $args[0];
			foreach($suites as $k=>$suite) if($suite->getName()!=$name) unset($suites[$k]);
			if(!count($suites)){
				die("Could not find Test Suite '$name'\n");
			} else {
				try {
					$this->runAll($suites);
				} catch(Exception $e){
					restore_error_handler();
					throw $e;
				}
			}
			restore_error_handler();
		}
		function handle_error($level,$message,$file,$line,$context){
			if(!error_reporting()) return;
			throw new Exception("$message in $file:$line");
		}
	}
?>
