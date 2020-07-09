<?

/**	This class contains the functionality for exporting DB definitions
 * from the model system into a database schema, rather than vice-versa.
 */	
	class AutoCreateModel extends BaseModel {
		// Default to old system (for now)
		var $exportsSchema=false;

		// Deprecated - see exportSchema
		function doInternalSQL(){
			$this->exportSchema();
		}

		// Mark this model as exporting it's schema to the db.
		function exportSchema(){
			$this->exportsSchema=true;
			$this->slugField='slug';
			$this->spaceCharacter='-';
		}

		// Mark this model as importing it's schema from the db (default at present).
		function importSchema(){
			$this->exportsSchema = false;
		}

		// Deprecated - see exportsSchema
		function doesInternalSQL(){
			return $this->exportsSchema();
		}

		// bool - true if this model should generate it's own schema
		function exportsSchema(){
			return $this->exportsSchema;
		}

		function createTable(){
			if(!$this->exportsSchema()) return;
			
			$this->engine()->createTable($this);

			foreach($this->relationships as $k=>$v){
				switch($v['type']){
				case __REL_MM__:
					$this->createMM($k);
					break;
				case __REL_EXTERNAL__:
					$man = $this->manager($k);
					if(method_exists($man,'createTable'))
						$man->createTable();
					break;
				}
			}
			$this->updateTable();
		}

		function updateTable(){
			if(!$this->exportsSchema()) return;

			if($fields = $this->getMissingDBFields()){
				$this->engine()->createFields($this,$fields);
				$this->triggerAction('fields_created',$fields);
			}
			$this->createIndexes();
		}

		function standardiseFields($fields){
			foreach($fields as $k=>$v){
				if($v=='decimal') $fields[$k]='decimal.2';
				if(is_array($v)) {
					$fields[$k] = array_values($v);
					foreach($fields[$k] as $k2=>$v2){
						$fields[$k][$k2] = str_replace("'","''",$v2);
					}
				}
			}
			$fields = $this->applyFilters('db_fields',$fields);
			return $fields;
		}
		function getMissingDBFields(){
			if(!$this->engine()->hasSchema()) return array();
			$fields = $this->getDBFields();
			$fields = $this->standardiseFields($fields);
			$wrong=array();
			foreach($this->engine()->listFields($this) as $name=>$type){
				if(@$fields[$name]==$type) unset($fields[$name]);
				else if(@$fields[$name]) $wrong[$name] = array(@$fields[$name],$type,@array_diff($fields[$name],$type),@array_diff($type,$fields[$name]));
				else $extra[$name] = $type;
			}
			return $fields;
		}
		function createMM($k){
			$rel = $this->loadRel($k);
			$existing = $this->engine()->listFields($rel['table']);
			$this->engine()->createTable($rel['table']);
			$fields = array(
				$rel['local_id']=>'int',
				$rel['foreign_id']=>'int',
			);
			if(@$rel['order']){
				$fields[$rel['order']] = 'int';
			}
			foreach($fields as $k=>$v){
				if(@$existing[$k]==$v)
					unset($fields[$k]);
			}
			if($fields)
				$this->engine()->createFields($rel['table'],$fields);
		}

		function getExtraDBFields(){
			if(!$this->engine()->hasSchema()) return array();
			$fields = $this->engine()->listFields($this);;
			foreach($this->getDBFields() as $name=>$type){
				unset($fields[$name]);
			}
			return $fields;
		}

		function defaultFields(){
			return array(
				'uid'=>new IDField('uid'),
				'name'=>new Field('name'),
				'status'=>new CheckBoxField('status',array('default'=>0)),
				'slug'=>new URLSlugField('slug'),
				'ctime'=>new CreatedDateField('ctime',array('dbFormat'=>'int')),
				'mtime'=>new ModifiedDateField('mtime',array('dbFormat'=>'int')),
			);
		}

		function createIndexes(){
			if(!$this->engine()->hasIndexes()) return array();
			$indexes = $this->engine()->getIndexes($this);
			$required = $this->requiredIndexes();
			foreach($required as $k=>$v){
				if(!in_array($v,$indexes)) $this->engine()->createIndex($this,$v);
			}
		}
		function requiredIndexes(){
			$indexes = array();
			foreach($this->relationships as $k=>$rel){
				$rel=$this->loadRel($k);
				if(@$rel['field']){
					$indexes[] = array($rel['field']);
				}
				if(@$rel['manager'] && method_exists($rel['manager'],'getIndexes')){
					$indexes[] = $rel['manager']->getIndexes();
				}
			}
			return array_unique($indexes);
		}

		function getDBFields(){
			$fields = array();
			foreach($this->getFields() as $k=>$v){
				if(is_object($v)){
					$fields = array_merge($fields,$v->getDBFields());
				}
			}
			foreach($this->relationships as $k=>$v){
				switch($v['type']){
				case __REL_BELONGS_TO__:
					$v = $this->loadRel($k);
					$fields[$v['field']] = 'int';
					break;
				case __REL_EXTERNAL__:
					$man = $this->manager($k);
					if(method_exists($man,'getDBFields')){
						$fields = array_merge($fields,$man->getDBFields());
					}
					break;
				}
			}
			return $this->applyFilters('db_fields',$fields);
		}
	}
