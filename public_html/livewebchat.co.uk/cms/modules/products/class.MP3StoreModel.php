<?
	class MP3StoreModel extends SortableModel {
		var $prefix='our-services';
		function getBulkActions(){
			return array('delete'=>'Delete');
		}
		function do_delete(){
			$this->status=-1;
			$this->writeToDB();
		}
		function getDeletedWhere(){
			return array('status <'=>0);
		}

		function cms_toggleActive(){
			$this->status = !$this->status;
			$this->writeToDB();
			$this->showView('confirmation');
		}
	}
?>
