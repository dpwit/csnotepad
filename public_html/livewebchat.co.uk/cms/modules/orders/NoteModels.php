<?
	class Note extends BozModel {
		var $fixed_table=false;
		function __construct($obj=null,$ref=''){
			if($ref!='note')
				$this->fixed_table = $ref;
			parent::__construct($obj,'note');
			if(!$obj) $this->ref_id=@$_GET['about_uid'];
			$this->hasOne('author',array('model'=>'User'));
		}
		function getViewDirectories(){
			$dirs = array_insert(parent::getViewDirectories(),dirname(__FILE__).'/views/note/',1);
			return $dirs;
		}

		function filter_fields_built($fields){
			$fields['author_uid']=new ForeignLabel('author',array('default'=>Model::loadModel('User')->getLoggedInUser()->getId()));
			$fields['ref_id'] = new ConstantField('ref_id',array('default',@$_GET['about_uid']));
			$fields['ref_table'] = new ConstantField('ref_table');
			if($this->fixed_table)
				$fields['ref_table']->setParam('value',$this->fixed_table);
			$fields['public']->setParam('label','Send to User?');
			$fields = array_merge(array('subject'=>new ForeignLabel('subject',array('db'=>false))),$fields);
			return $fields;
		}

		function getLabel(){
			if($this->exists()){
				return $this->author()->getLabel()." ".$this->subject()->getLabel()." ".date("Y-m-d H:i",$this->ctime);
			}
		}
		function getListingColumns(){
			return array_merge(parent::getListingColumns(),array('brief'=>truncate($this->notes,100)));
		}

		function filter_create_class($class,$record){
			if(class_exists($sub = $this->unpluralize($record->ref_table)."Note")){
				return $sub;
			}
			return $class;
		}

		function subject(){
			try {
				return Model::g($this->ref_table,$this->ref_id);
			} catch(Exception $e){
				return Model::g($this->unpluralize($this->ref_table),$this->ref_id);
			}
		}

		function on_model_instantiated(){
			$this->ref_table=$this->fixed_table;
		}

		function getDeletedWhere(){
			return array('ref_table !='=>$this->fixed_table);
		}

		function on_model_created(){
			if($this->public){
				$this->subject()->triggerAction('public_note_added',$this);
			}
			$this->subject()->triggerAction('note_added',$this);
		}
	}
	class OrderNote extends Note {
		function __construct($obj=null){
			parent::__construct($obj,'orders');
		}
	}
	class UserNote extends Note {
		function __construct($obj=null){
			parent::__construct($obj,'user');
		}
	}
?>
