<?php include $pageType.'Config.php' ?> 
<?php include $pageType.'Functions.php' ?> 

<form name="form" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		
<input type="hidden" name="action" value="submitted">
<input type="hidden" name="active" value="0" />
<input type="hidden" name="cms_uid" value="<?php echo $cms_uid; ?>" />
<input type="hidden" name="pageType" value="<?php echo $pageType; ?>" />
<input type="hidden" name="maxThumbSize" value="<?php echo $thumbMaxSizeVar ?>" />
<input type="hidden" name="maxImageSize" value="<?php echo $imageMaxSizeVar ?>" />
<input type="hidden" name="thumbFolder" value="<?php echo $thumbFolder ?>" />
<input type="hidden" name="video" value="<?php echo $row["video"] ; ?>" />
<input type="hidden" name="origimage" value="<?php echo $row["image"] ?>" />	
<input type="hidden" name="origthumb" value="<?php echo $row["thumb"] ?>" />					
<table>    

<tr height="30">
<td class="title1" align="right" > File Name </td>
<td> 
<select name="fileVar" class="formbox" >   <?php echo $row["fileVar"] ?>   
<?php listFiles ('files/downloads',$row["fileVar"]); ?>
</select>

</td>
</tr> 						 



<tr height="30">
<td class="title1" align="right" >  Category  </td>
<td> <select name="category" class="formbox" >   

<!-- do the query to get all existing galleries-->
								
<?Php

					
dbConnect();
$category = 'downloadIds';
$sql_listCategories = "SELECT * FROM $category ORDER BY uid ";									
$catResult = mysql_query($sql_listCategories);
								
if (!$catResult) {
die (' (Line 17) I cannot connect to the database because : ' . mysql_error()); 
error('A database error occurred  ');
}
		
// return the results 

while ($rowData = mysql_fetch_array($catResult, MYSQL_BOTH)) { ?> 
<option value="<?php echo $rowData["uid"]; ?>" <?php if ($row["category"] == $rowData["uid"]) {echo "selected";} ?> > <?php echo $rowData["categoryName"]; ?></option>
<?php }
mysql_free_result($catResult);
?> 
</select> 

<p> <?php echo $rowData["uid"] ?> </p>

</td>

</tr> 	

<tr height="30">
<td class="title1" align="right" >Title </td>
<td> 
<input type="text" class="formbox" name="title" value="<?php echo $row["title"] ?>" size="40"></td>
</tr> 

<tr height="30">
	<td class="title1" align="right" > Description </td>
	<td> 
	
	
	<?php  include("wysiwyg/fckeditor.php") ;
	       $oFCKeditor = new FCKeditor('description') ;
		   $oFCKeditor->Width = "400" ; // 250 pixels
		   $oFCKeditor->Height = "250" ; // 250 pixels
		   $oFCKeditor->ToolbarSet = 'Flash';
		   $oFCKeditor->BasePath = 'wysiwyg/' ;	// '/fckeditor/' is the default value.
		   $oFCKeditor->Value = $row["description"];
		   $oFCKeditor->Create() ;
	?>	 
	
</td>
</tr>




<tr height="30">
<td class="title1" align="right" > File Attached <br/>(Does this item have a file attached?) </td>
<td> 

<select name="isFile" class="formbox" >   <?php echo $row["isFile"] ?>   
<option value="0" <?php if ($row["isFile"]==0) {echo "selected";} if ($newItem==1) {echo "selected";}?>> No
<option value="1" <?php if ($row["isFile"]==1) {echo "selected";} ?> > Yes
</select>

</td>
</tr> 
									

<tr height="30">
<td class="title1" align="right" > Status </td>
<td> 

<select name="status" class="formbox" >   <?php echo $row["status"] ?>   
<option value="0" <?php if ($row["status"]==0) {echo "selected";} ?>> Inactive
<option value="1" <?php if ($row["status"]==1) {echo "selected";} if ($newItem==1) {echo "selected";}?> > Active
</select>

</td>
</tr> 

<tr height="30">
<td class="title1" align="right" > Restricted </td>
<td> 

<select name="restricted" class="formbox" >   <?php echo $row["restricted"] ?>   
<option value="0" <?php if ($row["restricted"]==0) {echo "selected";} if ($newItem==1) {echo "selected";} ?>> Free
<option value="1" <?php if ($row["restricted"]==1) {echo "selected";} ?> > Restricted
</select>

</td>
</tr> 


<?php //} ?>
																
<tr>
<td>&nbsp;</td>
<td style="padding-left:175px; height: 20px; margin-bottom:0px; " >
<input type="submit" name="submit" class="formbox" value="submit">
</form>
</td>
</tr>
								
</Table> 
