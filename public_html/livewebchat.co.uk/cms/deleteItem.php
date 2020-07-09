<?php 
/**
* @package BozBoz_CMS
*/

include 'requiredConnections.php';
	$dir = cms_module_resolve($pageType);
function deleteItem ($cms_uid,$pageType) {

			//echo "form submitted";
			
			include $dir.'/'.$pageType.'Sql.php';
			$result = mysql_query($sql_delete);
			cms_call_hook('sql_delete',array($pageType,$cms_id));
			cms_call_hook('sql_delete_'.$pageType,$cms_uid);
			
			if (!$result) {
			
			die ('I cannot connect to the database because: ' . mysql_error()); 
			error('A database error occurred  ');
			  
			}
}
			
//if ($_SESSION['level']>=2) {
//do the delete in the MYSQL database

		$model = Model::cmsLoadModel();
		$modelName = $model ? $model->getModelName(true) : $pageType;
		

		if(cms_call_hook('handle_delete_'.$modelName)){
		
		} elseif ( @$action == "submitted") {
			
			//echo "submitted";
			include $dir.'/'.$pageType.'Links.php';	
			 ?>
			 
			
			</div> <h1> Successfully deleted</h1>
<? redirectLastPage(); ?>
			</div>

			<?php deleteItem ($cms_uid,$pageType); }else
			 {
			 
			include $dir.'/'.$pageType.'Links.php';	
						
			?>
			<div style="width:100%" > 


			<br/>
			<br/>
			<div style=" margin-top:50px; margin-left:auto; margin-right:auto;"> 
			<form name="form" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ;?>" method="post">
		
			<input type="hidden" name="action" value="submitted">
			<input type="hidden" name="cms_uid" value= "<?php echo $cms_uid ?>">
			<input type="hidden" name="pageType" value= "<?php echo $pageType?>">
				
 			<input type="submit"  class=" formbox "value="Click here if you are sure you want to delete this Item" />
										
 			</form> </div>
			</div>

			<?php }?>
  
			<!-- Start of Body -->
 
				  
				  
	 <!-- End of Body -->

	<?php include("footer.php"); ?>  
	

