<?
	class EnumFilter extends ListingFilter {
		function __construct($table,$field,$label=null){
			if(!$label) $label = ucwords(str_replace('_',' ',$field));
			parent::__construct($label,self::enumOptions($table,$field));
			$this->table = $table;
			$this->field = $field;
		}

		function enumOptions($table,$field){
			$q = mysql_query("DESCRIBE `".mysql_escape_string($table)."`");
			while($r = mysql_fetch_assoc($q)){
				if($r['Field'] == $field){
					preg_match("/enum\('(.*)'\)/i",$r['Type'],$matches);
					$values = explode("','",$matches[1]);
					return array_combine($values,$values);
				}
			}
		}

		function restrict($model,$restrict,$selected=null){
			if(is_null($selected)) $selected = $this->getSelected();
			if($selected!='any'){
				$restrict[$this->field]=$selected;
			}
			return $restrict;
		}
	}
