<?
/**
* @package BozBoz_CMS
*/

class TestModel extends BozModel {
	function __construct($obj=null){
		parent::__construct($obj,'test');
		$this->hasMM('test2s',array('composition'=>true));
	}
}
class OtherTestModel extends BozModel {
	function __construct($obj=null){
		parent::__construct($obj,'test');
		$this->hasMM('test2s',array('composition'=>true,'order'=>'sorting'));
	}
}
class TestModel2 extends BozModel {
	function __construct($obj=null){
		parent::__construct($obj,'test2');
		$this->hasMM('tests',array('table'=>'tests_mm_test2s'));
	}
}
	class ModelSystemTestSuite extends BaseTestSuite {
		function __construct(){
			parent::__construct('Model System Tester', array('createTables','createTest','mmTest','nocompositionTest','sortedMMTest','countTest','deleteTables'));
		}

		function noError($test,$message=''){
			$e=mysql_error();
			$test->assert(!$e,"MySQL Error '$e' $message");
		}
		function createTables($test){
			mysql_query("CREATE TEMPORARY TABLE tests (uid int(11) auto_increment primary key, name varchar(255),test_field bool)");
			$this->noError($test);
			mysql_query("CREATE TEMPORARY TABLE test2s (uid int(11) auto_increment primary key, name varchar(255))");
			$this->noError($test);
			mysql_query("CREATE TEMPORARY TABLE tests_mm_test2s (test_uid int(11),test2_uid int(11), primary key(test_uid,test2_uid),sorting int(11) DEFAULT 0)");
			$this->noError($test);
			Model::addModel('Test',false,'TestModel');
			Model::addModel('Test2',false,'TestModel2');
			return true;
		}
		function deleteTables($test){
			return true;
		}

		function createTest($test){
			foreach(array('Test','Test2') as $table){
				$obj = Model::loadModel($table);
				for($a = 1 ; $a<5 ; $a++){
					$t1 = $obj->createNew(array('name'=>"$table $a",'test_field'=>$a%2));
					$t1->writeToDB();
					$t1->__destroy();
				}
				for($a = 1 ; $a<5 ; $a++){
					$t1 = $obj->get($a);
					$test->assertEqual($t1->name,"$table $a","Name should be '$table $a' actually '$t1->name'");
				}
			}
			return true;
		}

		function mmTest($test){
			$t1 = Model::g('Test',1);
			$test->assert(!$t1->test2s,"Test 2 Relationship should be empty");

			$t1->test2s[] = 1;
			$t1->test2s[] = 2;

			$t1->writeToDB();

			$test->assertEqual(count($t1->test2s),2,"Should be 2 related objects actually ".count($t1->test2s));
			$t1->__destroy();

			$t1 = Model::g('Test',1);
			$test->assertEqual(count($t1->test2s),2,"Should be 2 related objects after recreate actually ".count($t1->test2s));
			$test->assertEqual(count($t1->test2s()),2,"Should be 2 related objects after recreate (through function) actually ".count($t1->test2s()));

			$t1->test2s[] = 3;
			$t1->test2s[] = 4;

			$t1->writeToDB();
			$test->assertEqual(count($t1->test2s),4,"Should be 4 related objects actually ".count($t1->test2s));

			$t1->__destroy();
			$t1 = Model::g('Test',1);
			$test->assertEqual(count($t1->test2s),4,"Should be 4 related objects actually ".count($t1->test2s));
			$test->assertEqual(count($t1->test2s()),4,"Should be 4 related objects after recreate (through function) actually ".count($t1->test2s()));

			$t1->__destroy();
			$t2 = Model::g('Test2',1);
			$t2->writeToDB();
			$t1 = Model::g('Test',1);

			$test->assertEqual(count($t1->test2s),4,'Should be %2$s related objects after save of test2 actually %1$s');
			$test->assertEqual(count($t1->test2s()),4,'Should be %2$s related objects (through function) after save of test2 actually %1$s');



			$t1->test2s = array();
			$t1->test2s[] = 3;
			$t1->test2s[] = 4;
			$t1->writeToDB();
			$test->assertEqual(count($t1->test2s),2,"Should be 2 related objects after delete actually ".count($t1->test2s));
			$t1->__destroy();

			$t1 = Model::g('Test',1);
			$test->assertEqual(count($t1->test2s),2,"Should be 2 related objects after delete/recreate actually ".count($t1->test2s));
			$test->assertEqual(count($t1->test2s()),2,"Should be 2 related objects after delete/recreate (through function) actually ".count($t1->test2s()));

			$t1->test2s = array();
			$t1->writeToDB();
			$test->assertEqual(count($t1->test2s),0,"Should be 0 related objects after delete actually ".count($t1->test2s));
			$t1->__destroy();

			$t1 = Model::g('Test',1);
			$test->assertEqual(count($t1->test2s),0,"Should be 0 related objects after delete/recreate actually ".count($t1->test2s));
			$test->assertEqual(count($t1->test2s()),0,"Should be 0 related objects after delete/recreate (through function) actually ".count($t1->test2s()));

			return true;
		}
		function sortedMmTest($test){
			Model::addModel('Test',false,'OtherTestModel');
			$t1 = Model::g('Test',1);
			$test->assert(get_class($t1)=='OtherTestModel');
			$test->assert(!$t1->test2s,"Test 2 Relationship should be empty");

			$t1->test2s[] = 1;
			$t1->test2s[] = 2;

			$t1->writeToDB();

			$test->assertEqual(count($t1->test2s),2,"Should be 2 related objects actually ".count($t1->test2s));
			$t1->__destroy();

			$t1 = Model::g('Test',1);
			$test->assertEqual(count($t1->test2s),2,"Should be 2 related objects after recreate actually ".count($t1->test2s));
			$test->assertEqual(count($t1->test2s()),2,"Should be 2 related objects after recreate (through function) actually ".count($t1->test2s()));

			$t1->test2s[] = 3;
			$t1->test2s[] = 4;

			$t1->writeToDB();
			$test->assertEqual(count($t1->test2s),4,"Should be 4 related objects actually ".count($t1->test2s));

			$t1->__destroy();
			$t1 = Model::g('Test',1);
			$test->assertEqual(count($t1->test2s),4,"Should be 4 related objects actually ".count($t1->test2s));
			$test->assertEqual(count($t1->test2s()),4,"Should be 4 related objects after recreate (through function) actually ".count($t1->test2s()));

			$t1->test2s = array();
			$t1->test2s[] = 3;
			$t1->test2s[] = 4;
			$t1->writeToDB();
			$test->assertEqual(count($t1->test2s),2,"Should be 2 related objects after delete actually ".count($t1->test2s));
			$t1->__destroy();

			$t1 = Model::g('Test',1);
			$test->assertEqual(count($t1->test2s),2,"Should be 2 related objects after delete/recreate actually ".count($t1->test2s));
			$test->assertEqual(count($t1->test2s()),2,"Should be 2 related objects after delete/recreate (through function) actually ".count($t1->test2s()));

			return true;
		}
		function noCompositionTest($test){
			$t1 = Model::g('Test',1);
			$t1->test2s = array(1,2);
			$t1->writeToDB();
			$t1->__destroy();

			$t1 = Model::g('Test',1);
			$test->assertEqual(count($t1->test2s),2,"Should be 2 related objects after delete/recreate actually ".count($t1->test2s));
			$test->assertEqual(count($t1->test2s()),2,"Should be 2 related objects after delete/recreate (through function) actually ".count($t1->test2s()));
			$t1->__destroy();

			$t2 = Model::g('Test2',1);
			$t2->writeToDB();

			$t1 = Model::g('Test',1);
			$test->assertEqual(count($t1->test2s),2,"Should be 2 related objects after delete/recreate actually ".count($t1->test2s));
			$test->assertEqual(count($t1->test2s()),2,"Should be 2 related objects after delete/recreate (through function) actually ".count($t1->test2s()));
			$t1->test2s = array();
			$t1->writeToDB();
			$t1->__destroy();

			return true;
		}

		function countTest($test){
			$tm = Model::loadModel('Test');
			$test->assertEqual($tm->countMatching(),4,"Should be 4 records actually '{$tm->countMatching()}'");
			$test->assertEqual($tm->countMatching(array('test_field'=>0)),2,"Should be 2 records actually '{$tm->countMatching(array('test_field'=>0))}'");
			$results = $tm->countMatching(array(),array('test_field'));
			$test->assertEqual(count($results),2,"Should be 2 groups for tests by test_field actually '".count($results)."'");
			foreach($results as $k=>$v){
				$expect = 2;
				$test->assertEqual($v['count'],$expect,"Should be $expect results for group $v[key] actually $v[count]");
			}
			return true;
		}
	}
?>
