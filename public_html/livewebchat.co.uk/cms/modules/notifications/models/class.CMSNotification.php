<?
	class CMSNotification extends BozModel {
		function __construct($obj=null){
			parent::__construct($obj,'cms_notification');
			if(!@$this->priority) $this->priority = 'low';
			if(!@$this->status) $this->status = 'new';
		}

		function filter_model_listing_filters($array){
			cms_module_require('listing_filters','EnumFilter.php');
			$array[] = $status = new EnumFilter($this->getTableName(),'status');
			$array[] = new EnumFilter($this->getTableName(),'priority');
			$status->default='new';

			return $array;
		}
		function getTextFields(){
			return array('summary','message','source','url');
		}

		function getCmsActions(){
			return array(
				$this->urlFor('clickThrough')=>'Handle',
				$this->urlFor('markViewed')=>'Mark Viewed',
			);
		}

		function filter_list_params($params){
			$params['title'] = 'System Notifications';
			return $params;
		}

		function getModelName(){
			return 'CMSNotification';
		}

		function getCmsBulkActions(){
			return array('bulkMarkViewed'=>'Mark Viewed');
		}

		function getListingColumns(){
			$cols = array_merge(array('source'=>ucwords($this->source)),parent::getListingColumns());
			$cols['Priority'] = ucwords($this->priority);
			$cols['Status'] = ucwords($this->status);
			$cols['source'] = $this->applyFilters('cms_notification_source',$cols['source']);
			return $cols;
		}

		function getLabelField(){
			return "summary";
		}

		function getDefaultOrder(){
			return array('priority','uid desc');
		}

		function getDeletedWhere(){
			return array('status'=>'archive');
		}


		function cms_bulkMarkViewed($params){
			foreach(array_keys($_REQUEST['cms_uid']) as $id){
				$this->get($id)->markViewed();
			}
			redirectReferer();
		}
		function cms_clickThrough(){
			$this->get($_REQUEST['cms_uid'])->clickThrough();
		}
		function clickThrough(){
			if($this->status=='new') {
				$this->status='seen';
				$this->writeToDB();
			}
			redirectTo($this->url);
		}
		function cms_markViewed(){
			$this->markViewed();
			redirectLastPage();
		}
		function markViewed(){
			$this->status='archive';
			$this->writeToDB();
		}
	}
?>
