<?
	class Config extends BozModel {
		function cms_save(){
			$page = $_POST['page'];
			$with_under = str_replace(' ','_',$page);
			foreach($_POST as $k=>$v){
				if(strpos($k,$with_under)===0){
					$name=substr($k,strlen($with_under)+1);
				} else {
					continue;
				}
				$cf = $this->getFirst(array('section'=>$page,'key'=>$name));
				if(!$cf) $cf = $this->createNew(array('section'=>$page,'key'=>$name));
				$cf->value=$v;
				$cf->writeToDB();
			}
			$this->showView('confirmation');
		}
		function getTableName(){
			return 'config';
		}
		function on_model_saved(){
			$GLOBALS['CONFIG'][$this->section][$this->key] = 
				$GLOBALS['CONFIG'][''][$this->key] = 
				$this->value;
		}
		static function value($key,$section=''){
			return @$GLOBALS['CONFIG'][$section][$key];
		}
	}
?>
