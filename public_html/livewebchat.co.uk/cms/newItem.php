<?php 
/**
* @package BozBoz_CMS
*/

include 'requiredConnections.php' ?>

<!-- Start of Body -->

<?php 
	$dir = cms_module_resolve($pageType);
	$model = Model::cmsLoadModel();
	$modelName = $model ? $model->getModelName(true) : $pageType;
	$errors = array();
	if(!$_SESSION['uid']) $errors['USER_LEVEL'] = 'You must log in to create items';
	$access_denied = cms_call_hook('check_access',$errors,array('pageType'=>$pageType,'action'=>'newItem','modelName'=>$modelName,'model'=>$model));
	if (!$access_denied) {
			//if(!$_POST) $_SESSION['lastRealPage'] = str_replace('newItem','editItem',$_SERVER['REQUEST_URI']).'?cms_uid=###INS_UID###';

			if(@$action=="submitted"){
				$preprocessData = cms_call_hooks(
					array('preprocess_form','preprocess_form_'.$pageType)
					,$_POST);
				extract($preprocessData);

				$validationErrors = cms_call_hooks(
					array('validate_form','validate_form_'.$pageType)
					,array(),$preprocessData);
			}
			if (@$action == "submitted" && !$validationErrors) {
				if(!cms_call_hook('handle_save_'.$modelName)) {

 			include $dir.'/'.$pageType.'Links.php';	

			//$filename = BASEPATH.'cms/modules/'.$pageType.'/'.$pageType.'/'.'Config.php';
			$specialActions =  $dir.'/'.$pageType.'SpecialSubmissionActions.php';
			//echo $specialActions;
			
			if (file_exists($specialActions)) {
    		//echo "The file $filename exists";
			echo "<p>Special actions triggered</p>";
			include $dir.'/'.$pageType.'SpecialSubmissionActions.php';
			} else {
    		//echo "The file $filename does not exist";
			}
				
			
			include 'includes/imageVideoUploadScript.php' 
			?>
			
		   <?php // password security 
	       if ($password) 
		   {   //only encode if it has been changed
		   if ($password!=$origPassword)
		   {
		   //echo 'new password ='.$password;
		   //echo 'origPassword ='.$origPassword;
		   //  echo 'password has changed';
		   $enc= md5($password);
		   $password = $enc;
		   }	
		   }
		   ?>
			
	
	<?php 
	
	//do sql statement
	//do the edit in the MYSQL Database 
	$ins_id=cms_call_hook('sql_handle_new',false,$pageType,$preprocessData);
	$ins_id=cms_call_hook('sql_handle_new_'.$pageType,$ins_id,$preprocessData);

	if(!$ins_id){
		if ($specialSql != true){
			include $dir.'/'.$pageType.'Sql.php';
		} else {
			include cms_resolve_module($specialSqlType).'/'.$specialSqlType.'Sql.php';
			//echo 'special sql triggerd '; 
		}
		$result = mysql_query($sql_newItem) or die (' But I cannot connect do the sql query because: ' . mysql_error());
		$ins_id=mysql_insert_id();
	}
	cms_call_hook('sql_new',array($pageType,$ins_id));
	cms_call_hook('sql_new_'.$pageType,$ins_id);
	
	?>
	
	<?php if ($dest || $video || $sql_setSortField) {
	//echo 'updating sortfield';
	$resultNew = mysql_query($sql_setSortField);
	
	}?>
	
	<!-- End of Body -->
	<p> New Information added</p>
<? redirectLastPage($ins_id); ?>
	

<?php 
		}
	} else { 
		if(!cms_call_hook('handle_newform_'.$modelName)) {
			cms_call_hooks(array('start_action',"start_action_$pageType"),'newForm');
			include $dir.'/'.$pageType.'Links.php';	
		?>
			
	 <div style="">
	 <?php  $newItem =1;
	 if(file_exists($file=$dir.'/'.$pageType.'ItemDefaults.php')) require($file); 
	 include_once $dir.'/'.$pageType.'ItemForm.php'; ?>
	 </div>

							
	 <!-- End of Body -->

	
<?php } 
	}
?>
<?php }else {
	foreach($access_denied as $error){
		?> <p><?=$error?></p> <?php 
	}
}
?> 		 

<?php include("footer.php"); ?>  




