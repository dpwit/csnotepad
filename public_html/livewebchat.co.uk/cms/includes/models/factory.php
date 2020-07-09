<?
	class FactoryException extends Exception {}
	class NoMappingException extends FactoryException {}

	class Factory {
		static $mappings = array(), $typeLists = array() , $origins = array(), $constructorArgs=array();

		static function mapClass($name,$params=array()){
			$name = strtolower($name);
			if(!$params) $params=$name;
			self::$mappings[$name] = $params;
			if($type = @$params['type']){
				self::$typeLists[strtolower($type)][strtolower($name)] = true;
			}
		}
		static function hasMapping($name){
			$name = strtolower($name);
			return self::$mappings[$name];
		}

		static function listByType($type){
			return self::$typeLists[strtolower($type)];
		}

		static function loadClass($name){
			$name = strtolower($name);
			$params = @self::$mappings[$name];
			if(!$params) $params=$name;
			if(!$params) throw new NoMappingException("No mapping found for '$name'");
			if(is_array($params)){
				if($file = @$params['file']){
					if(!file_exists($file)) throw new FactoryException("File '$file' not found when loading mapping for '$name'");
					require_once($file);
					self::$origins[$name]=$file;
				}
				for($a=1;$a<=4;$a++){
					$field = "p$a";
					if(@$params[$field]){
						self::$constructorArgs[$name][$field] = $params[$field];
					}
				}
				if($class = @$params['class']) $params=$class;
				else $class=$name;
				self::$mappings[$name] = $params = $class;
			}
			return $params;
		}

		static function newInstance($name,$p1=null,$p2=null,$p3=null,$p4=null){
			$className = self::loadClass($name);
			if(!class_exists($className)){
				throw new FactoryException("Mapped class '$className' not found for '$name'");
			}
			if($args = @self::$constructorArgs[$name]){
				for($a=1;$a<=4;$a++){
					$field = "p$a";
					if(@$args[$field]){
						$$field = $args[$field];
					}
				}
			}
			$instance = new $className($p1,$p2,$p3,$p4);
			if($instance instanceof Viewable){
				$instance->setOrigin(@self::$origins[strtolower($name)]);
				$instance->triggerAction('instantiated');
			}
			return $instance;
		}

		static function getInstance($name,$p1=null,$p2=null,$p3=null,$p4=null){
			static $instances;
			$args = func_get_args();
			$name = strtolower($name);
			$args[0]=$name;
			$args = join(",",$args);
			if(!@$instances[$args]){
				$instances[$args] = self::newInstance($name,$p1,$p2,$p3,$p4);
			}
			return $instances[$args];
		}
	}
?>
