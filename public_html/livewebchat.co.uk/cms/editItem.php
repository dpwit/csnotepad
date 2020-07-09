<?php include 'requiredConnections.php' ?>


<!-- Start of Body -->

<?php 
	$dir = cms_module_resolve($pageType);
	$model = Model::cmsLoadModel();
	$modelName = $model ? $model->getModelName(true) : $pageType;
	$errors = array();
	if(!$_SESSION['uid']) $errors['USER_LEVEL'] = 'You must log in to edit items';
	$access_denied = cms_call_hook('check_access',$errors,array('pageType'=>$pageType,'uid'=>$cms_uid,'action'=>'editItem','modelName'=>$modelName,'model'=>$model));
	if (!$access_denied) {
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
				if(!cms_call_hook('handle_save_'.$modelName,false)) {
 			include $dir.'/'.$pageType.'Links.php';	
			?>
			
			
			
			
			<?php
			
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
			?> 
			
			
			<? include 'includes/imageVideoUploadScript.php' ;
			?>
			
		   <?php // password security 
	       if ($password) 
		   {   //only encode if it has been changed
		   if ($password!=$origPassword)
		   {
		   //echo 'new password ='.$password;
		   //echo 'origPassword ='.$origPassword;
		   echo 'password has changed';
		   $enc= md5($password);
		   $password = $enc;
		   }	
		   }
		   ?>
			
			<?
			//do sql statement
	//do the edit in the MYSQL Database 
			
	$done=cms_call_hook('sql_handle_edit',false,$pageType,$preprocessData,$cms_uid);
	$done=cms_call_hook('sql_handle_edit_'.$pageType,$done,$preprocessData,$cms_uid);
	if(!$done){
		if ($specialSql != true){
			include $dir.'/'.$pageType.'Sql.php';
		} else {
			include cms_resolve_module($specialSqlType).'/'.$specialSqlType.'Sql.php';
			//echo 'special sql triggerd '; 
		}
		$result = mysql_query($sql_edit) or die (' But I cannot connect do the sql query because: ' . mysql_error());
		if ($dest || $video) {
			//echo 'updating sortfield';
			$resultNew = mysql_query($sql_setSortField);
		}
	}
	cms_call_hook('sql_edit',array($pageType,$cms_uid));
	cms_call_hook('sql_edit_'.$pageType,$cms_uid);
	
	?>
	
			
			<p>Thanks For the Ammendments</p> 
	
			</table>
<? 
redirectLastPage(); ?>
<?php 
				}
	} else {

		if(!cms_call_hook('handle_editform_'.$modelName)) {
			include $dir.'/'.$pageType.'Links.php';		
			
			$sql = "SELECT * FROM $pageType WHERE uid = '$cms_uid'  ";
			
			$result = mysql_query($sql);
			
			if (!$result) {
			  $sql = "SELECT * FROM $pageType WHERE id = '$cms_uid'  ";
			  $result = mysql_query($sql);
				  if (!$result) {
				  die ('I cannot connect to the database because: ' . mysql_error()); 
				  error('A database error occurred  ');
				  }			
			}
			
			  ?>
			  
			  <div style=""> 

					<!-- return the results -->
				
					<?php 
					
					while ($row = mysql_fetch_array($result, MYSQL_BOTH)) { 
					$newItem = include_once $dir.'/'.$pageType.'ItemForm.php'; 

					 }
					
					mysql_free_result($result);
					?> 
			  </div>
			<?php
		}
	}
			?>

<?php }else {

	foreach($access_denied as $error){
?> 
	<p><?=$error?></p> 
<?php 
	}
}
?> 		 

<?php include("footer.php"); ?>  
			
 <!-- End of Body -->
 
