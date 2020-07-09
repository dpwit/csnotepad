<?
	class Fuga_Import extends BozModel {
		function __construct($obj=null){
			parent::__construct($obj,'fuga_import');
			$this->hasOne('product');
			$this->hasMany('previous',array('model'=>'Fuga_Import','field'=>'import_id','ref_field'=>'import_id'));
		}
	}
