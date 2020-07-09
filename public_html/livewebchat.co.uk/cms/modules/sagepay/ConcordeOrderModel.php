<?
	class Order extends BozModel {
		var $adminEmail = 'hello@concorde2.co.uk';

		function __construct($obj=null){
			parent::__construct($obj,'orders');
			$this->hasOne('ticket');
			$this->hasOne('order_state',array('model'=>'OrderState'));
			if(!$this->order_state_uid) $this->order_state_uid=1;
			if($key = $_POST['token'][$this->uid]){
				$this->deCrypt($key);
			}
		}
		function stateTransition(){
			$old = $this->origObj->order_state_uid;
			if(!$old) $old=1;
			$new = $this->order_state_uid;
			return array($old,$new);
		}
		function getTextFields(){
			return array("customer_lastname","customer_firstname","customer_postcode");
		}
		function writeToDB(){
			list($old,$new) = $this->stateTransition();
			if($old!=$new){
				switch($old){
					case '3'://SUCCESS
					switch($new){
					case 5://REFUND
						//IGNORE;
					break;
					default:
						$this->debugMail("Attempted order changed from complete",json_encode($this));
						return true;
						//throw new Exception("Cannot Edit Successfull Orders");
					break;
					}
				}
			}
			return parent::writeToDB();
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
		function overrideFields(){
			require_once(dirname(__FILE__).'/../events/TicketFields.php');
			$this->setField(new ConstantForeignField('ticket',array('default'=>$_GET['event'],'obj'=>$this)));
			$this->setField(new SkippedField('event_uid'));
			$this->setField(new HistoryField());
			parent::overrideFields();
			$fixed = array('status','status_detail','vpstxid','tx_auth_no','avscv2','address_result','postcode_result','cv2_result','auth3d_status','cavv','total_processed','vendor_tx_code','display_card');
			foreach($fixed as $k){
				$this->setField(new ConstantField($k));
			}
			$this->setField(new ConstantField('ip',array('default'=>$_SERVER['REMOTE_ADDR'])));
		}
		function getByTXCode($txCode){
			list($vendor,$id,$time) = explode("-",$txCode);
			return $this->get($id);
		}
		function setFromProtxFormResponse($values){
			$this->total_processed=$values["Amount"];
			$this->setFromProtxDirectResponse($values);
		}
		function setFrom3DResponse($values){
			require_once(dirname(__FILE__).'/ProtxDirectRequest.php');
			$request = new Auth3DRequest($values);
			$request->process();
			$values = $request->body;
			$this->status = $values['Status'];
			$this->status_detail = $values['StatusDetail'];
			$value = $request->isSuccessful();
			$this->setFromProtxDirectResponse($request->body);
			$this->request = $request;
		}
		function isComplete(){
			return $this->status=='OK';
		}
		function setFromProtxDirectResponse($values){
			$this->tx_auth_no=$values["TxAuthNo"];
			$this->vpstxid=$values["VPSTxId"];
			$this->status=$values['Status'];
			$this->status_detail=$values['StatusDetail'];
			$this->avscs2=$values["AVSCV2"];
			$this->address_result=$values["AddressResult"];
			$this->postcode_result=$values["PostCodeResult"];
			$this->cv2_result=$values["CV2Result"];
			$this->auth3d_status=$values["3DSecureStatus"];
			$this->security_key=$values["SecurityKey"];
			$this->cavv=$values["CAVV"];
			if(!$this->order_ref){
				$code = strtoupper(md5($this->ctime));
				$code = substr($code,0,4)."-".substr($code,4,4);
				$this->order_ref = $code;
			}
			$orderModel = $this->loadModel('OrderState');
			if($this->status=='OK'){
				$this->order_state_uid = $orderModel->getFirst(array('name'=>'Complete'))->getID();
			} elseif($this->status!='3DAUTH') {
				$this->order_state_uid = $orderModel->getFirst(array('name'=>'Failed'))->getID();
			}
			$this->writeToDB();
		}
		function getFullName(){
			return "$this->customer_firstname $this->customer_lastname";
		}
		function validateUserDetails($post){
			$this->errors=array();
			$this->customer_title = $post['CustomerTitle'];
			$this->customer_firstname = $post['CustomerFirstName'];
			$this->customer_middlename = $post['CustomerMiddleName'];
			$this->customer_lastname = $post['CustomerLastName'];
			$this->customer_email = $post['CustomerEMail'];
			$this->customer_address = $post['BillingAddress'];
			$this->customer_city = $post['BillingCity'];
			$this->customer_country = $post['BillingCountry'];
			$this->customer_postcode = $post['BillingPostCode'];
			$this->customer_mobile = $post['ContactMobile'];
			$this->customer_phone = $post['ContactPhone'];
			$this->writeToDB();
			$required = array('firstname','lastname','email','address','postcode','title','country','city');
			foreach($required as $shortField){
				$field = "customer_$shortField";
				if(!$this->$field) $this->errors[$field] = "Please Enter Your ".ucwords($shortField);
			}
			if(!preg_match("/.@.*\..*/",$this->customer_email)) $this->errors['customer_email'] = "Please enter a valid email address";
			foreach(array('mobile','phone') as $field){
				$field = "customer_$field";
				if(preg_match("/([0-9].*){6}/",$this->$field)){
					$validPhone=true;
				}
			}
			if(!$validPhone) $this->errors['customer_phone'] = $this->errors['customer_mobile'] = "Please provide at least one phone number";
			return !$this->errors;
		}

		function getHiddenFields(){
			if($this->cardPost && !$this->crypt){
				$this->storeEncrypted($this->cardPost);
			}
			if($this->crypt){
				return "<input type='hidden' name='token[$this->uid]' value='".$this->crypt->getKey()."'/>";
			}
		}
		function deCrypt($key){
			require_once(dirname(__FILE__).'/encrypt.php');
			$crypt = new MyCrypt($key);
			$data = unserialize($crypt->decrypt($_SESSION['data'][$this->getID()]));
			$this->crypt = $crypt;
			if($data){
				$this->validateCardDetails($data);
			}
		}
		function storeEncrypted($data){
			require_once(dirname(__FILE__).'/encrypt.php');
			$crypt = new MyCrypt();
			$_SESSION['data'][$this->getID()] = $crypt->encrypt(serialize($data));
			$this->crypt = $crypt;
		}
		function validateCardDetails($post){
			$this->card_name = $post['card_name'];
			$this->card_number = $post['card_number'];
			$this->display_card = substr($this->card_number,-4);
			$this->card_start = $post['card_start'];
			$this->card_expiry = $post['card_expiry'];
			$this->card_type = $post['card_type'];
			$this->card_issue_number = $post['card_issue_number'];
			$this->card_cvv = $post['card_cvv'];
			$this->cardPost = $post;
			$required = array('name','number','expiry','type','cvv');
			foreach($required as $shortField){
				$field = "card_$shortField";
				if(!$this->$field) $this->errors[$field] = "Please Enter Your ".ucwords($shortField);
			}
			return !$this->errors;
		}
		function cantBookReasonNoCache(){
			return $this->__cantBookReason(true);
		}
		function cantBookReason(){
			return $this->__cantBookReason(false);
		}
		function __cantBookReason($clearCache=false){
			Model::disableCache();
			if($this->ticket()->getBookableTickets($this->uid)<$this->quantity){
				Model::enableCache();
				return "These tickets have been sold";
			}
			Model::enableCache();
			if($this->order_state_uid==3) return "This order has been processed already";

		}
		function writeLockTables(){
			$q = mysql_query("LOCK TABLES orders WRITE , tickets WRITE , events READ");
			if(!$q) die("LOCK FAILED");
		}
		function readLockTables(){
			$q = mysql_query("LOCK TABLES orders READ , tickets READ , events READ");
			if(!$q) die("LOCK FAILED");
		}
		function writeUnlocktables(){
			return $this->unlockTables();
		}
		function readUnlocktables(){
			return $this->unlockTables();
		}
		function unlockTables(){
			$res = mysql_query("UNLOCK TABLES");
			if(!$res) die("UNLOCK FAILED");
			if($e = mysql_error())
				die($e);
		}
		function process(){
			$this->writeLockTables();
			if($e = mysql_error())
				die($e);
			if($bookingError = $this->cantBookReasonNoCache()){
				if($this->isComplete()){
					$this->status_detail = $bookingError;
					$this->order_state_uid = 2;
					$this->writeToDB();
				} else {
                                        $this->debugMail('Not Cancelling Order');
                                         return true;
                                }

				$this->writeUnlockTables();
				return false;
			}
			$this->writeToDB();
			$this->writeUnlockTables();

			require_once(dirname(__FILE__).'/ProtxDirectRequest.php');
			$request = new ProtxProcessRequest($data = $this->getOrderDetailsForProtxDirect());
			$this->vendor_tx_code = $request->post['VendorTxCode'];
			$this->writeToDB();

			$value = $request->isSuccessful();
			$this->setFromProtxDirectResponse($request->body);
			$this->request = $request;
			return $value;
		}
                function debugMail($message,$long=''){
                        $message.=" #$this->uid";
                        mail("don@don-benjamin.co.uk","CONCORDE ISSUE $message","$message\n$long");
                }
		function cms_refund(){
			$this->refund();
		}
		function refund($retry = false){
			require_once(dirname(__FILE__).'/ProtxDirectRequest.php');
			$request = new ProtxRefundRequest($this,array('amount'=>$this->total-($this->booking_fee*$this->quantity)));
			if($request->isSuccessful()){
				$this->order_state_uid = Model::loadModel('OrderState')->getFirst(array('name'=>'Refunded'))->getID();
				$this->writeToDB();
				if($retry) return true;
				$this->showView('confirmation');
			} else {
				if($retry) return false;
				if(($this->uid<10508) && (strlen($this->vendor_tx_code)==24)){
					$tx = $this->vendor_tx_code;
					for($a=0;$a<10;$a++){
						$this->vendor_tx_code = $tx.$a;
						if($this->refund(true)){
							$this->showView('confirmation');
							return true;
						}
					}
				}
				$this->showView('editErrors');
			}
		}
		function requires3DAuth(){
			return $this->status=='3DAUTH';
		}
		function hidden3DAuthStuff(){
			$p = $this->request->body;
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
		function event(){
			$ticket = $this->ticket();
			return $ticket ? $ticket->event() : null;
		}
		function getOrderDetailsForProtxForm(){
			$details = array(
				'Amount'=>number_format($this->total,2),
				'Currency'=>'GBP',
				'Description'=>$this->quantity.' x '.$this->ticket()->description().' "'.$this->event()->title.'" on '.$this->event()->niceDate(),
				'CustomerName'=>$this->getFullName(),
				'CustomerEMail'=>$this->customer_email,
				'BillingAddress'=>$this->customer_address,
				'BillingPostCode'=>$this->customer_postcode,
				'SuccessURL'=>__SITE_URL__."/bookingConfirmation.php",
				'FailureURL'=>__SITE_URL__."/bookingFailure.php",
				'ContactNumber'=>$this->customer_mobile?$this->customer_mobile:$this->customer_phone,
			);
			return $details;
		}
		function formatProtxDate($date){
			extract($date);
			$mfield = substr(str_pad($month,2,'0',STR_PAD_LEFT),0,2);
			$yfield = str_pad(substr($year,-2),2,'0',STR_PAD_LEFT);
			return $mfield.$yfield;
		}
                function formatProtxCardType($f){
			$paymentArr = array('Visa'=>'VISA','Mastercard'=>'MC','Maestro/Switch'=>'MAESTRO','Delta'=>'DELTA','Solo'=>'SOLO');
			return $paymentArr[$f];
		}
		        
		function getOrderDetailsForProtxDirect(){
			$details = array (
				'ID'		=>$this->uid,
				'CardNumber'	=>$this->card_number,
				'CardHolder'	=>$this->card_name,
				'ExpiryDate'	=>$this->formatProtxDate($this->card_expiry),
				'CV2'		=>$this->card_cvv,
				'CardType'	=>$this->formatProtxCardType($this->card_type),
				'BillingSurname'=>$this->customer_lastname,
				'BillingFirstnames'=>$this->customer_firstname,
				'BillingCity'=>$this->customer_city,
				'BillingCountry'=>$this->customer_country,
			);
			$address=explode("\n",$this->customer_address);
			$count=1;
			foreach($address as $line){
				$details["BillingAddress$count"] = $line;
				if(++$count>2) break;
			}
			if($this->card_start){
				$details['StartDate']=$this->formatProtxDate($this->card_start);
			}
			if($this->card_issue_number){
				$details['IssueNumber']=$this->card_issue_number;
			}
			$details = array_merge($details,$this->getOrderDetailsForProtxForm());
			foreach($details as $k=>$v){
				$k = str_replace("Billing","Delivery",$k);
				$details[$k]=$v;
			}
			unset($details['SuccessURL']);
			unset($details['FailureURL']);
			return $details;
		}
		function cancel(){
			$this->order_state_uid=4;
			$this->writeToDB();
		}
		function getMainLinks(){
			return array_merge(parent::getMainLinks(),array(
				"despatch.php?model=Order&action=willcall"=>"Will Call",
				"despatch.php?model=Order&action=eventsales"=>"Sales By Event"
			));
		}
		function cms_willcall(){
			if($_GET['event']) return $this->showView('willcall',
				array('event'=>$this->loadModel('Event')->get($_GET['event'])));
			else return $this->showView('event_select',array(
				'link'=>"despatch.php?action=willcall&model=Order&event=" , 
				'events' => $this->loadModel('Event')->getAll(array('date >='=>date("Y-m-d",time()-24*3600*7)),array('order'=>'date'))
			));
		}
		function cms_eventsales(){
			return $this->showView('eventsales');
		}
		function getPrice($withBookingFee=true){
			if($withBookingFee) return "&pound;".number_format($this->total,2);
			return "&pound;".number_format($this->quantity*$this->price,2);
		}
		function getBookingFee(){
			return "&pound;".number_format($this->quantity*$this->booking_fee,2);
		}
		function afterWrite($obj,$oldObj){
			parent::afterWrite($obj,$oldObj);
			if($obj->order_state_uid != $oldObj->order_state_uid){
				if($obj->order_state_uid==3){
					$this->__orderConfirmed($oldObj);
				}
				if($oldObj->order_state_uid==3){
					$this->__orderCancelled($oldObj);
				}
			}
			if($obj->status_detail != $oldObj->status_detail){
				if(preg_match('/^Operation timed out/',$obj->status_detail)){
					$this->sendTimedOutEmail($oldObj);
				}
			}
		}
		function __orderConfirmed(){
			$this->sendConfirmationEmail();
			$ticket = $this->ticket();
			$ticket->ticketsAvailable -= $this->quantity;
			$ticket->writeToDB();
			if($ticket->ticketsAvailable<=5){
				$msg = "$ticket->ticketsAvailable tickets left for {$this->event()->title}";
				$this->__sendMail($this->adminEmail,
					"Concorde 2 Bookings - $msg",
					"$msg");
			}
			$this->subscribePHPList();
		}

		function subscribePHPList(){
			$listId = 0;
			$genre = $this->event()->eventGenre();
			if($genre) $listId = $genre->php_list_uid;
			else {
				var_dump($genre);
				die("NO GENRE");
			}
			mysql_query("USE ".__MYSQL_LIST__);

			$email = $this->customer_email;
			$confirmed =1;
			$htmlemail = 1;
			if(!$telNo) $telNo = $this->customer_mobile;

			$userId = @mysql_result(mysql_query("SELECT id FROM phplist_user_user WHERE email='$email'"),0);
			$sql_addUser ="INSERT INTO phplist_user_user  (  email, confirmed, htmlemail) VALUES ( '$email', '$confirmed', '$htmlemail')";

			if(!$userId){
				$result = mysql_query($sql_addUser) or die (' But I cannot connect do the sql query because: ' . mysql_error());
				$userId = mysql_insert_id();
			}

			//stick user in appropriate list and other bitties

                        $sql_addToList ="INSERT INTO phplist_listuser  (  userid, listid) VALUES ( '$userId', '$listId')";
			$result = mysql_query($sql_addToList);// or die (' But I cannot connect do the sql query because: ' . mysql_error());


			$attributes = array(
				1=>$this->customer_firstname,
				2=>$this->customer_lastname,
				3=>$this->customer_phone ? $this->customer_phone : $this->customer_mobile,


			);
			foreach($attributes as $k=>$v){
				$sql_addFistName ="INSERT INTO phplist_user_user_attribute  (  userid, attributeid,value) VALUES ( '$userId','$k', '$v' ) ON DUPLICATE KEY UPDATE value='$v'";
				mysql_query($sql_addFistName);
			}

			mysql_query("USE ".__MYSQL_NAME__);
		}

		function __orderCancelled($oldObj){
			$this->sendCancellationEmail();
			$ticket = $this->ticket()->get($oldObj->ticket_uid);
			if($ticket)	{
				$ticket->ticketsAvailable += $oldObj->quantity;
				$ticket->writeToDB();
			}
		}
		function __sendMail($to,$subject,$textContent,$htmlContent='',$from='orders@concorde2.co.uk'){
			require_once(dirname(__FILE__)."/phpmailer/class.phpmailer.php");
			$mail = new phpmailer();
			$mail->From = $from;
			$mail->FromName="Orders";
			$mail->Subject = $subject;
			if($htmlContent){
				$mail->IsHtml(true);
				$mail->Body=$htmlContent;
				$mail->AltBody=$textContent;
			} else {
				$mail->Body=$textContent;
			}
			$mail->AddAddress($to);
			$mail->AddBCC("don@don-benjamin.co.uk");
			$mail->AddBCC("webcontact@bozboz.co.uk");
			//$mail->AddBCC("mike@bozboz.co.uk");
			$mail->Send();
		}
		function sendConfirmationEmail(){
			$event = $this->event();
			$title = $event->title;
			$date = date("j/n/Y",strtotime($event->date));
			$order = $this;
			ob_start();
			$this->showView('confirmationEmailHtml',array('event'=>$event,'title'=>$title,'date'=>$date));
			$html = ob_get_contents();
			ob_end_clean();
			ob_start();
			$this->showView('confirmationEmailText',array('event'=>$event,'title'=>$title,'date'=>$date));
			$text = ob_get_contents();
			ob_end_clean();

			$this->__sendMail($this->customer_email,"Concorde 2 Booking Confirmation - {$title}",$text,$html);
		}
		function sendCancellationEmail(){
			$label = $this->order_state()->getLabel();
			switch($label){
			case 'Refunded':
				$event = $this->event();
				$title = $event->title;
				$date = date("j/n/Y",strtotime($event->date));
				$order = $this;
				ob_start();
				$this->showView('cancellationEmailHtml',array('event'=>$event,'title'=>$title,'date'=>$date));
				$html = ob_get_contents();
				ob_end_clean();
				ob_start();
				$this->showView('cancellationEmailText',array('event'=>$event,'title'=>$title,'date'=>$date));
				$text = ob_get_contents();
				ob_end_clean();
	
				$this->__sendMail($this->customer_email,"Concorde 2 Order Cancelled - {$title}",$text,$html);
			}
		}
		function sendTimedOutEmail(){
			$event = $this->event();
			$title = $event->title;
			$date = date("j/n/Y",strtotime($event->date));
			$order = $this;
			ob_start();
			$this->showView('confirmationEmailHtml',array('event'=>$event,'title'=>$title,'date'=>$date));
			$html = ob_get_contents();
			ob_end_clean();
			ob_start();
			$this->showView('confirmationEmailText',array('event'=>$event,'title'=>$title,'date'=>$date));
			$text = ob_get_contents();
			ob_end_clean();

			$this->__sendMail("tg1210@hotmail.com","Concorde 2 Order Timed Out - {$title}",$text,$html,'notifications@concorde2.co.uk');
		}
		function getListingColumns(){
			$cols = array(
				'Name'=>$this->getFullName(),
				'Event'=>'',
				'Event Date'=>'',
				'Status'=>'',
				'Date'=>'',
				'Ticket'=>'',
			);
			$ticket = $this->ticket();
			$event = $this->event();
			if($event){
				$cols['Event'] = $event->title;
				$cols['Event Date'] = $event->niceDate();
				$cols['Date'] = date("j/m/Y",$this->ctime);
				$cols['Ticket'] = $this->quantity."x ".$ticket->description();
			}
			if($state = $this->order_state())
				$cols['Status'] = $state->name;
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
		function showListing(){
			$this->showView('links');

			$states = $this->allStates();
			$states = array_diff($states,array('New','NEW','Cancelled'));

			$restrict = array(
				"order_state.name IN"=>$states,
			);
			if($_GET['event']){
				$event = Model::loadModel('Event')->get($_GET['event']);
				$tids = array();
				foreach($event->tickets() as $ticket){
					$tids[] = $ticket->uid;
				}
				$restrict['ticket.uid in'] = $tids;
			}
			$this->showView('list',array('restrict'=>$restrict));
			return true;
		}
		function collectionInstructions(){
			return "TICKETS ARE FOR VENUE COLLECTION ON THE NIGHT OF THE EVENT ONLY; TICKETS WILL NOT BE SENT IN THE POST IN ADVANCE.";
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
?>
