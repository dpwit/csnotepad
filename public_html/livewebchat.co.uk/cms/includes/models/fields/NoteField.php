<?
	class NoteField extends ConstantField {
		function defaultParams(){
			$d = parent::defaultParams();
			$d['db'] = false;
			$d['hidden'] = false;
			return $d;
		}

		function renderHTML($obj){
			return '<div class="form-notes">'.$this->param('note','Notes').'</div>';
		}
	}
?>
