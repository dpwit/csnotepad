<?
/**
* @package Boz_Orders
*/

	class BaseOrder extends BozModel {
		var $adminEmail = 'hello@concorde2.co.uk';
		function __construct($obj=null,$table='order'){
			parent::__construct($obj,'order');
			$this->hasMany('order_items',array('model'=>'Order_Item'));
			$this->hasOne('order_state',array('model'=>'OrderState','add-filter'=>true,'default-filter'=>'complete'));
			$this->hasOne('user');
			if(!@$this->order_state_uid) $this->order_state_uid=1;
			if($key = @$_POST['token'][$this->uid]){
				$this->deCrypt($key);
			}
			$this->hasMany('notes',array('model'=>'OrderNote','show-count'=>true,'ref_field'=>'ref_id'));
		}

		function filter_cms_actions($actions){
			if(!$this->user_uid){
				foreach($actions as $k=>$v){
					if($v=='View User') unset($actions[$k]);
				}
			}
			return $actions;
		}

		function getPaymentGateway(){
			return cms_apply_filter('get_payment_gateway',null);
		}
		function getModelNamesForHooks(){
			return array_merge(parent::getModelNamesForHooks(),array('order'));
		}

		function getVatRate(){
			if(Config::value('use_vat','orders')) return Config::value('vat_rate','orders')*0.01;
			return 0;
		}
		function deductVat($price){
			$orig_price=$price;
			$price = $price*(1/(1+$this->getVatRate()));
			$price = floor($price*100)/100;
			return $price;
		}
		function addVat($price){
			$price = number_format($price*(1+$this->getVatRate()),2);
			return $price;
		}

		function getParent(){
			return false;
		}
		function getAssignArray($obj=null){
			if(!$obj) $obj=$this;
			$array = parent::getAssignArray($obj);
			@list($gw,$method) = explode(".",$obj->payment_method);
			if(@$method) {
				$array['payment_gateway'] = $obj->payment_gateway = $gw;
				$array['payment_method'] = $obj->payment_method = $method;
			}
			return $array;
		}

		function create($class,$r,$table=false){
			if($r) {
				switch($r->payment_type){
				case 'oneoff':
					$class='OneOffOrder';
					break;
				case 'subscription_start':
					$class='SubscriptionOrder';
					break;
				case 'subscription_repeat':
					$class='SubscriptionRepeatOrder';
					break;
				}
			}
			if(!class_exists($class)) Model::loadModel($class);
			return parent::create($class,$r,$table);
		}
		function updateToUser($user){
			$user->title = $this->customer_title;
			$user->firstName = $this->customer_firstname;
			$user->lastName = $this->customer_lastname;
			$user->realName = "$this->customer_firstname $this->customer_lastname";
			$user->address = $this->customer_address;
			$user->email = $this->customer_email;
			$user->city = $this->customer_city;
			$user->state = $this->customer_state;
			$user->country = $this->customer_country;
			$user->phone = $this->customer_phone;
			$user->postcode = $this->customer_postcode;
			$user->writeToDB();
		}

		function updateFromUser($user){
			$this->customer_title = @$user->title;
			@list($this->customer_firstname,$this->customer_lastname) = @explode(" ",$user->realName,2);
			$this->customer_address = @$user->address ;
			$this->customer_email = @$user->email ;
			$this->customer_city = @$user->city ;
			$this->customer_country = @$user->country ;
			$this->customer_state = @$user->state ;
			$this->customer_phone = @$user->phone ;
			$this->customer_postcode = @$user->postcode ;
			$this->card_title = @$user->title;
			@list($this->card_firstname,$this->card_lastname) = @explode(" ",$user->realName,2);
			$this->card_address = @$user->address ;
			$this->card_email = @$user->email ;
			$this->card_city = @$user->city ;
			$this->card_country = @$user->country ;
			$this->card_state = @$user->state ;
			$this->card_phone = @$user->phone ;
			$this->card_postcode = @$user->postcode ;
			$this->user_uid = @$user->id;
		}

		function getUrlField(){
			return 'uid';
		}

		function on_before_write(){
			$this->payment_data = @json_encode($this->payment_data);
		}
		function on_model_saved(){
			$this->payment_data = @json_decode($this->payment_data,true);
		}
		function on_model_instantiated(){
			$this->payment_data = @json_decode($this->payment_data,true);
		}

		var $new_items = array();
		function addItem($name,$price=false,$qty=1,$ref=null,$id=null){
			if($this->order_state_uid>1) throw new Exception("Cannot Add Items To Order in state ".$this->order_state()->name);
			if(is_object($name)){
				$new = $name;
			} else {
				$new = Model::loadModel('Order_Item')->createNew($values = array(
					"name"=>$name,
					"price"=>$price,
					"quantity"=>$qty,
					"ref_table"=>$ref,
					"ref_id"=>$id,
					"total"=>$price*$qty
				));
			}
			$new->order_uid=$this->getId();
			if($this->exists()){
				$new->writeToDB();
			} else {
				$this->new_items[] = $new;
			}
			$this->triggerAction('items_added',$new); // Added $new to the params so that handlers know whats been added.
			return $new;
		}
		function order_items($where=array(),$params=array()){
			return array_merge($this->new_items,$this->getRelated('order_items',$where,$params));
		}
		function getLabelField(){
			return 'customer_lastname';
		}
		function getDefaultOrder(){
			return "mtime DESC";
		}
		function getLabel() {
			return "$this->customer_lastname, $this->customer_firstname";
		}
		function cms_refund(){
			$this->refund();
		}
		function refund(){
			$this->getPaymentGateway()->refund($this);
		}

		function getFullName() { return $this->getLabel(); }
		function getFields(){
			parent::getFields();
			$this->fields['history'] = new HistoryField();
			$this->fields['ip'] = new ConstantField('ip',array('default'=>@$_SERVER['REMOTE_ADDR']));
			$this->fields['customer_address'] = new TextArea('customer_address');
			$this->fields['card_address'] = new TextArea('card_address');
			$this->fields['payment_data'] = new HiddenField('payment_data');
			if($user = Model::loadModel('User')->getLoggedInUser()){
				$this->fields['user_uid']->setDefault($user->getId());
			}
			return $this->fields;
		}
		function filter_fields_built($fields){
			$fields['total']->setParam('default',0);
			return $fields;
		}
		function isComplete(){
			return $this->order_state()->name=='Complete';
		}
		function validateUserDetails(){
			$errors = array();
			if(!@$this->errors) $this->errors=array();

			$required = array('firstname','lastname','email','address','postcode','title','country','city');
			$validPhone=false;
			foreach($required as $shortField){
				$field = "customer_$shortField";
				if(!$this->$field) $errors[$field] = "Please Enter Your ".ucwords($shortField);
			}
			if(!preg_match("/.@.*\..*/",$this->customer_email)) $this->errors['customer_email'] = "Please enter a valid email address";
			foreach(array('mobile','phone') as $field){
				$field = "customer_$field";
				if(preg_match("/([0-9].*){6}/",$this->$field)){
					$validPhone=true;
				}
			}
			if(!$validPhone) $errors['customer_phone'] = $this->errors['customer_mobile'] = "Please provide at least one phone number";
			$this->errors=array_merge($this->errors,$errors);
			return !$errors;
		}

		function getHiddenFields(){
			if(@$this->cardPost && !$this->crypt){
				$this->storeEncrypted($this->cardPost);
			}
			if(@$this->crypt){
				return "<input type='hidden' name='token[$this->uid]' value='".$this->crypt->getKey()."'/>";
			}
		}
		function deCrypt($key){
			require_once(dirname(__FILE__).'/encrypt.php');
			$crypt = new MyCrypt($key);
			$data = unserialize($crypt->decrypt($_SESSION['data'][$this->getID()]));
			$this->crypt = $crypt;
			if($data){
				foreach($data as $k=>$v){
					$this->$k=$v;
				}
				$this->validateCardDetails($data);
			}
		}
		function storeEncrypted($data){
			foreach($data as $k=>$v) $this->$k=$v;
			require_once(dirname(__FILE__).'/encrypt.php');
			$crypt = new MyCrypt();
			$_SESSION['data'][$this->getID()] = $crypt->encrypt(serialize($data));
			$this->crypt = $crypt;
		}
		function validateCardDetails(){
			$required = array('name','number','expiry','type','cvv');
			$typeRequired = array(
				"Solo"=>array("issue_number"),
			);
			if($this->card_type){
				$extra = @$typeRequired[$this->card_type];
				if($extra) $required = array_merge($extra,$required);
			}
			foreach($required as $shortField){
				$field = ($shortField=='issue_number') ? $shortField : "card_$shortField";
				if(!$this->$field) $this->errors[$field] = "Please Enter Your ".ucwords($shortField);
			}
			return !$this->errors;
		}
		function getErrors(){
			return $this->errors;
		}
		function card_expiry($format){
			if(!@$this->card_expiry) return '';
			list($month,$year) = explode("/",$this->card_expiry);
			$tstamp = strtotime("$month/01/$year");
			return date($format,$tstamp);
		}
		function card_start($format){
			if(!@$this->card_start) return '';
			@list($month,$year) = @explode("/",$this->card_start);
			if((!$month)||(!$year)) return '';
			$tstamp = strtotime("1/$month/$year");
			return date($format,$tstamp);
		}
		function lockTablesRead(){
			$this->lockTablesWrite();
		}
		function getReadLockTables(){
			$tables = array('order_states','user','usergroups');
			foreach($this->order_items() as $o)
				$tables = array_merge($tables,$o->getReadLockTables());
			return array_unique($tables);
		}
		function getWriteLockTables(){
			$tables = array('orders','histories');
			foreach($this->order_items() as $o)
				$tables = array_merge($tables,$o->getWriteLockTables());
			return array_unique($tables);
		}
		function lockTablesWrite(){
			$this->holdQueue();
			$read = $this->getReadLockTables();
			$write = $this->getWriteLockTables();
			$locks = array();
			foreach($read as $table){
				$locks[] = "$table READ";
			}
			foreach($write as $table){
				$locks[] = "$table WRITE";
			}
			$q = mysql_query("LOCK TABLES ".join(",",$locks));
			if(!$q) throw new Exception("LOCK FAILED ".mysql_error());
		}
		function unlockTables(){
			$res = mysql_query("UNLOCK TABLES");
			if(!$res) throw new Exception("UNLOCK FAILED");
			$this->processQueue();
		}
		function getAvailabilityErrors(){
			if($this->isComplete()) return false;
			$errors=array();
			foreach($this->order_items() as $item){
				$error = $item->getAvailabilityErrors();
				if($error) $errors[] = $error;
			}
			return join("\n",$errors);
		}
		function correctAvailabilityErrors(){
			foreach($this->order_items() as $item)
				$item->correctAvailabilityErrors();
			//parent::correctAvailabilityErrors();
		}
		function getGateway(){
			if(!@$this->gateway) $this->gateway = cms_apply_filter('get_payment_gateway',false);
			return $this->gateway;
		}
		function getPaymentMethods(){
			return $this->getGateway()->getPaymentMethods($this->getTotal(true));
		}
		function setPaymentMethod($method){
			$methods = $this->getPaymentMethods();
			if(!$methods[$method]) throw new Exception("No Such Method '$method'");

			$this->payment_method = $method;
		}
		function setGateway($gateway){
			$this->gateway = $gateway;
		}
		var $errors = array();
		function process(){
			try {
			if(!$this->validateUserDetails() && $this->validateCardDetails()) return false;

			$this->lockTablesWrite();
			if($bookingError = $this->getAvailabilityErrors()){
				$this->status_detail = $bookingError;
				$this->order_state_uid = 2;
				$this->writeToDB();
				$this->unlockTables();
				return false;
			}
			$this->writeToDB();
			$this->unlockTables();

			try {
				$response = $this->processPayment();
			} catch(Exception $e){
				$this->errors['processing'] = $e->getMessage();
			}
			$this->writeToDB();
			return $this->isComplete();
			} catch(Exception $e){
				try { $this->unlockTables();} catch(Exception $e2){}
				throw $e;
			}
		}
		function handle3dAuthReturn(){
			switch($this->order_state()->name){
			case '3DAUTH':
				return $this->getGateway()->handle3dAuthReturn($this);
			case 'Complete':
				//In case of refreshes
				return true;
			default:
				//Ummm....
				throw new Exception("Order Failed");
			}
		}
		function processPayment(){
			return $this->getGateway()->process($this);
		}
		function processFree(){
			$this->lockTablesWrite();
			if($bookingError = $this->getAvailabilityErrors()){
				$this->status_detail = $bookingError;
				$this->order_state_uid = 2;
				$this->writeToDB();
				$this->unlockTables();
				return false;
			}
			$this->order_state_uid=3;
			$this->status_detail = "Processed Order Without Payment";
			$this->writeToDB();
			$this->unlockTables();
			return $this->isComplete();
		}
		function delete(){
			foreach($this->order_items() as $item) $item->delete();
			parent::delete();
		}

		function cancel(){
			$this->order_state_uid=4;
			$this->writeToDB();
		}

		function getPrice($withExtras = true){
			$total = $this->getTotal($withExtras);
			return "&pound;".number_format($total,2);
		}
		function getSiteName(){
			return Config::value('title','site');
		}
		function getTotal($withExtras = true){
			$total = 0;
			foreach($withExtras ? $this->order_items() : $this->order_items_no_extras() as $item){
				$total+=$item->getTotalPrice(!$withExtras);
			}
			return $total;
		}
		function canCheckout(){
			return $this->applyFilters('can_checkout',($this->meetsMinimumCheckout() && !$this->getAvailabilityErrors()));
		}
		function meetsMinimumCheckout(){
			return $this->getPaymentMethods($this->getTotal(false));
		}
		function getMinimumCheckout($pretty=true){
			$min = $this->getGateway()->getMinimumCheckout();
			if($pretty) $min = "&pound;".number_format($min,2);
			return $min;
		}
		function order_items_no_extras($where=array(),$params=array()){
			$o = $this->order_items($where,$params);
			foreach($o as $k=>$item){
				if($item->isExtra()) unset($o[$k]);
			}
			return array_values($o);
		}
		function getBookingFee(){
			return "&pound;".number_format($this->quantity*$this->booking_fee,2);
		}
		function afterWrite($obj,$old,$assign){
			parent::afterWrite($obj,$old,$assign);
			foreach($this->new_items as $i){
				$i->order_uid = $this->getID();
				$i->writeToDB();
			}
			$this->new_items = array();
			@error_log("ORDER SAVED $assign[order_state_uid]");
			if(@$assign['order_state_uid']){
				@error_log("ORDER STATE CHANGED $obj->order_state_uid / $old->order_state_uid");
				$this->queueAction('state_changed',@$old->order_state_uid);
				if($obj->order_state_uid==3){
					$this->queueAction('orderConfirmed',$old);
					$this->triggerAction('updateAvailability',$old);
				}
				if(@$old->order_state_uid==3){
					$this->queueAction('orderCancelled',$old);
				}
				if($obj->order_state_uid==2){
					$this->queueAction('orderFailed',$old);
				}
			}
			if(@$obj->status_detail != @$old->status_detail){
				if(preg_match('/^Operation timed out/',$obj->status_detail)){
					$this->sendTimedOutEmail($old);
				}
			}
		}
		var $queued = array(), $queueing=false;
		function holdQueue(){
			Model::loadModel('User')->getLoggedInUser();
			$this->queueing=true;
		}
		function processQueue(){
			$this->queueing = false;
			foreach($this->queued as $action=>$list){
				unset($this->queued[$action]);
				foreach($list as $obj){
					$this->triggerAction($action,$obj);
				}
			}
		}
		function queueAction($action,$old){
			$this->queued[$action][] = $old;
			if(!$this->queueing) $this->processQueue();
		}
		function on_orderConfirmed(){
			$this->sendConfirmationEmail();
			$this->triggerItems('orderConfirmed');
		}

		function on_orderCancelled($oldObj){
			$this->sendCancellationEmail();
			$this->triggerItems('orderCancelled');
		}
		function on_updateAvailability(){
			$this->triggerItems('updateAvailability');
		}
		function on_state_changed($old){
			$this->triggerItems('order_state_changed');
		}

		function triggerItems($event){
			foreach($this->order_items() as $item) $item->triggerAction($event);
		}

		function __sendMail($to,$subject,$textContent,$htmlContent='',$from=false){
			//if(!$from) $from = "orders@".__SERVER_DOMAIN__;
			if(!$from) $from = Config::value('order_reply_email_address','orders');
			cms_module_require('phpmailer','class.phpmailer.php');
			$mail = new phpmailer();
			$mail->From = $from;
			$mail->FromName="Orders";
			$mail->Subject = $subject;
			$footers = $this->getEmailFooters();
			if($htmlContent){
				$mail->IsHtml(true);
				$mail->Body=$htmlContent.$footers['html'];
				$mail->AltBody=$textContent.$footers['text'];
			} else {
				$mail->Body=$textContent.$footers['text'];
			}
			$mail->AddAddress($to);
			$mail->AddBCC("don@don-benjamin.co.uk");
			$mail->AddBCC("webcontact@bozboz.co.uk");
			$mail->AddBCC("rdon11@hotmail.com");
			$mail->AddBCC(Config::value('admin-email','site'));
			$mail->Send();
		}
		function getEmailFooters(){
			try {
				$footer = $this->getView('emailFooter');
				return array(
					'html'=>$footer,
					'text'=>strip_tags($footer),
				);
			} catch(Exception $e){
				return array('html'=>'','text'=>'');
			}
		}
		function sendConfirmationEmail(){
			$order = $this;
			ob_start();
			$this->showView('confirmationEmailHtml');
			$html = ob_get_contents();
			ob_end_clean();
			ob_start();
			$this->showView('confirmationEmailText');
			$text = ob_get_contents();
			ob_end_clean();

			$this->__sendMail($this->customer_email,__SERVER_DOMAIN__." Order Confirmation ",$this->getView('confirmationEmailText'),$this->getView('confirmationEmailHtml'));
		}
		function adminMail($subject,$message){
			$this->__sendMail(Config::value('admin-email','site'),$subject,$message);
		}
		function on_public_note_added($note){
			$this->__sendMail($this->customer_email,
				__SERVER_DOMAIN__." Note Added To Order ","",
						$note->getView('email-summary'));
		}

		function getViewDirectories(){
			$dirs = array_insert(parent::getViewDirectories(),dirname(__FILE__).'/views/order/',1);
			$template_dirs = cms_apply_filter('get_theme_directories',array());
			foreach($template_dirs as $k=>$v){
				$template_dirs[$k].="/modules/orders";
			}
			$dirs = array_merge(array_reverse($template_dirs),$dirs);
			return $dirs;
		}
		function sendCancellationEmail(){
			$label = $this->order_state()->getLabel();
			switch($label){
			case 'Refunded':
				$title = $this->getLabel();
				$order = $this;
				$html = $this->getView('cancellationEmailHtml');
				$text = $this->getView('cancellationEmailText');
	
				$this->__sendMail($this->customer_email,$this->getSiteName()." Order Cancelled - {$title}",$text,$html);
			}
		}
		function sendTimedOutEmail(){
			$title = $this->getLabel();
			$date = date("j/n/Y",strtotime($event->date));
			$order = $this;
			ob_start();
			$this->showView('confirmationEmailHtml');
			$html = ob_get_contents();
			ob_end_clean();
			ob_start();
			$this->showView('confirmationEmailText');
			$text = ob_get_contents();
			ob_end_clean();

			$this->__sendMail("tg1210@hotmail.com"," Order Timed Out - {$title}",$text,$html,'notifications@concorde2.co.uk');
		}
		function getCmsActions(){
			$actions = parent::getCmsActions();
			$actions[Model::loadModel('OrderNote')->urlFor('new',array('about_uid'=>$this->getId()))] = 'Add Note';
			return $actions;
		}
		function getListingColumns(){
			$cols = array(
				'Name'=>$this->getFullName(),
				'Status'=>'',
			);

			if(Config::value('have_subscriptions'))
				$cols['Type']=ucwords($this->payment_type);
			$cols['Date']=date("d/m/Y H:i",$this->ctime);
			$cols['Total']='';
			if($state = $this->order_state())
				$cols['Status'] = $state->name;
			$cols['Total'] = $this->getPrice();
			return $cols;
		}
		function getCSVListingColumns(){
			$cols = parent::getCSVListingColumns();
			$desc = array();
			foreach($this->order_items() as $i){
				$desc[] = $i->getQuantity()." x ".$i->getDescription().'@'.$i->getPrice();
			}
			$cols['Order'] = join(" + ",$desc);
			$myCols = array(
				'customer_email',
				'customer_title',
				'customer_firstname',
				'customer_middlename',
				'customer_lastname',
				'customer_address',
				'customer_city',
				'customer_country',
				'customer_postcode',
				'customer_phone',
				'customer_mobile',
				'ip',
				'total_processed',
				'payment_method',
				'payment_gateway',
				'payment_version',
				'payment_environment',
				'payment_message',
				'payment_status',
				'payment_type',
			);
			foreach($myCols as $col){
				$cols[$this->variableToEnglish($col)] = $this->$col;
			}
			
			return $cols;
		}

		function allStates(){
			static $res;
			if(!$res){
				$state = Model::loadModel('Order_State')->getAll();
				foreach($state as $state){
					$res[$state->name] = $state->name;
				}
			}
			return $res;
		}
		function showListing($params=array()){
			$states = $this->allStates();
			$states = array_diff($states,array('New','NEW','Cancelled'));
			$restrict = array(
				"order_state.name IN"=>$states,
			);
			$params['restrict']=  $restrict;
			return parent::showListing($params);
		}
		function state(){
			return $this->order_state()->name;
		}

		function getCompletionState(){
			$state = Config::value($key = $this->getPaymentGateway()->getEngineName($this)."/".$this->payment_method."/completion_state");
			if(!is_numeric($state)){
				$state = Model::loadModel('OrderState')->getFirst(array('name'=>$state))->uid;
			}
			return $state;
		}

		function doTransition($state){
			if(!$this->canTransition($state)) throw new Exception("Bad Order Transition");
			if($state=='Complete'){
				$state = $this->getCompletionState();
			} else {
				$state = Model::loadModel('OrderState')->getFirst(array('name'=>$state))->uid;
			} 
			$this->order_state_uid = $state;
			$this->writeToDB();
		}

		function getAllowedTransitions(){
			$end_states = array();
			foreach(Model::loadModel('Order_State')->getAll(array('end_state'=>1)) as $state){
				$end_states[] = $state->name;
			}
			return array(
				"New"=>array_merge($end_states,array(
					"Complete",
					"Failed",
					"Cancelled",
					"In Process",
					"3DAUTH"
				)),
				"In Process"=>array_merge($end_states,array(
					"Pending",
					"Complete",
					"Failed",
					"Cancelled",
					"In Process",
					"3DAUTH"
				)),
				"Pending" => array_merge($end_states,array(
					"Complete",
					"Failed",
					"Cancelled",
				)),
				"3DAUTH"=>array_merge($end_states,array(
					"Failed",
					"Cancelled",
				)),
				"Complete"=>array(
					"Refunded",
					"Cancelled"
				)
			);
		}
		function hidden3DAuthStuff(){
			return $this->getGateway()->hidden3DAuthForOrder($this);
			$html = "
			<script>
				var ACSURL='".$p['ACSURL']."';
				var MD='".$p['MD']."';
				var PAReq='".$p['PAReq']."';
				var TermURL='".SECUREURL."/includes/modules/protx/3dauth-return.php?txId={$this->uid}';
			</script>
			";
			return $html;
		}
		function canTransition($toState){
			$allowed = $this->getAllowedTransitions();
			$currState = $this->order_state();
			return @in_array($toState,$allowed[$currState->name]);
		}

		function obfuscatedCardDetails(){
			if(!@$this->card_number) return '';
			$card_num = str_pad("",strlen(@$this->card_number)-4,"X").substr(@$this->card_number,-4);
			return @$this->card_name." ".@$this->card_type." $card_num";
		}
		function filter_model_listing_filters($array){
			require_once(dirname(__FILE__).'/fields/OrderFilters.php');
			$array[] = new OrderDateFilter();
			$array[] = new OrderTypeFilter();
			return $array;
		}
		function isSubscription(){
			return false;
		}
		function getTextFields(){
			return array('customer_email','customer_firstname','customer_lastname','user.userid','user.realName','customer_postcode','customer_city','customer_phone');
		}

		function on_items_modified(){
		}
		function requiresBillingAddress(){
			return !$this->getGateway()->hasFeature('no-billing-address',$this);
		}
	}
	class OneOffOrder extends BaseOrder {
		function __construct($obj=null,$table='order'){
			parent::__construct($obj,$table);
			$this->payment_type='oneoff';
		}
		function getDeletedWhere(){
			return array('payment_type !='=>'oneoff');
		}
	}
	class OrderState extends BozModel {
		function __construct($obj=null){
			parent::__construct($obj,'order_state');
		}
		function getSortField(){
			return $this->getIDField();
		}
	}

	class Order_Item extends SortableModel {
		function __construct($obj=null,$table=null){
			parent::__construct($obj,'order_item');
			$this->hasOne('order',array('model'=>'GenericOrder'));
			$this->hasThrough('user','order');
		}
		function filter_fields_built($fields){
			$fields = parent::filter_fields_built($fields);
			$fields['total']->setParam('default',0);
			unset($fields['params']);
			return $fields;
		}
		function getModelNamesForHooks(){
			$names = parent::getModelNamesForHooks();
			$names[]='order_item';
			return $names;
		}
		function getDefaultOrder(){
			return array('order_uid','sorting');
		}
		function create($class,$r,$table=false){
			if($r) {
				$class = $this->applyFilters('order_item_class',$class,$r,$table);
			}
			if(!class_exists($class)) Model::loadModel($class);
			return parent::create($class,$r,$table);
		}
		function overrideFields(){
			$this->setField(new HistoryField());
		}

		function referenced($where=array(),$params=array()){
			$factory = Model::loadModel(self::unpluralize($this->ref_table));
			$where[$factory->getIdField()] = $this->ref_id;
			if($factory) return $factory->getFirst($where,$params);
		}
		function getPriceBeforeVat(){
			return $this->getPrice(false);
		}
		function getPrice($incVat=true){
			$price = $this->price;
			if(!$incVat) $price = $this->deductVATIfNecessary($price);
			return $price;
		}
		function deductVATIfNecessary($price){
			if($this->isTaxable()){
				if($order = $this->order())
					$price = $order->deductVat($price);
			}
			return $price;
		}
		function getQuantity(){
			return preg_replace("/\.0+$/","",number_format($this->quantity,2));
		}
		function setQuantity($qty){
			$this->quantity=$qty;
		}
		function setPrice($price){
			$this->price=$price;
		}
		function getTotalPriceFormatted($incVat=true){
			return "&pound;".number_format($this->getTotalPrice($incVat),2);
		}
		function getTotalBeforeVat(){
			return $this->getTotalPrice(false);
		}
		function getTotalPrice($incVat=true){
			$price = $this->getQuantity()*$this->getPrice();
			if(!$incVat) $price = $this->deductVATIfNecessary($price);
			return $price;
		}
		function getOldTotalBeforeVAT(){
			$price = $this->getPrice();
			$price = $this->deductVATIfNecessary($price);
			$price*=$this->getQuantity();
			return $price;
		}
		function getReadLockTables(){
			return array($this->getTableName());
		}
		function getWriteLockTables(){
			return array();
		}

		function getAvailabilityErrors(){
			return false;
		}
		function correctAvailabilityErrors(){
			$this->triggerAction('correct_errors');
		}

		function on_model_instantiated(){
			$this->params = @json_decode($this->params,true);
		}
		function on_before_write(){
			$this->params = @json_encode($this->params);
			$order = $this->order();
			if($order && !$order->isComplete()){
				$this->nett = $this->getTotalBeforeVat();
				if($order->requiresVAT()){
					$this->gross = $this->isTax() ? 0 : $this->getTotalPrice();
				} else {
					$this->gross = $this->nett;
				}
				$this->total = $this->getTotalPrice();
			}
		}
		function on_model_saved(){
			$this->params = @json_decode($this->params,true);
			$this->order()->triggerAction('items_modified',$this);
		}
		
		function on_model_deleted(){
					$this->order()->triggerAction('items_modified',$this);
		}

		function isExtra(){
			return false;
		}
		function isTax(){
			return false;
		}
		function isTaxable(){
			return !$this->isTax();
		}
		function getDisplayQuantity(){
			return $this->getQuantity();
		}
		function getListingColumns(){
			return array("Name"=>$this->name,"Qty"=>$this->getDisplayQuantity(),"Price"=>$this->getPrice(false));
		}
		function requiresShipping(){
			return false;
		}
	}

	class Extra_Charge extends Order_Item {
		function isExtra(){
			return true;
		}
		function requiresShipping(){
			return false;
		}
		function getDisplayQuantity(){
			return '';
		}
	}
?>
