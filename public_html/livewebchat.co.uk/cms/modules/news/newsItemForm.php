<?php include $pageType.'Config.php';?>

<form name="form" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		
<input type="hidden" name="action" value="submitted">
<input type="hidden" name="cms_uid" value="<?php echo $cms_uid; ?>" />
<input type="hidden" name="status" value="1" />
<input type="hidden" name="pageType" value="<?php echo $pageType; ?>" />
<input type="hidden" name="maxThumbSize" value="<?php echo $thumbMaxSizeVar ?>" />
<input type="hidden" name="maxImageSize" value="<?php echo $imageMaxSizeVar ?>" />
<input type="hidden" name="thumbFolder" value="<?php echo $galleryFolder ?>" />
<?php if ($fileExtension=='flv') {?>
<input type="hidden" name="origVideo" value="<?php echo $row["image"] ; ?>" />
<?php }?>
<input type="hidden" name="origimage" value="<?php echo $row["image"] ?>" />	
<input type="hidden" name="origthumb" value="<?php echo $row["thumb"] ?>" />	
		
																									
	<table >   

	<form name="form" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				
							

	<tr height="30">
	<td class="title1" align="right" > Title </td>
	<td> <input type="text" class="formbox" name="title" value="<?php echo $row[1] ?>" size="40"> </td>
	</tr> 

	<tr height="30">
	<td class="title1" align="right" > Short Text </td>
	<td> 
	
	<textarea  class="formbox" name="shorttext" cols="80" rows="10"><?php echo $row["shorttext"] ?> </textarea> 
	

	</td>
	</tr>
								
	<tr height="30">
	<td class="title1" align="right" > Content </td>
	<td> 
	
<!--	<textarea  class="formbox" name="content" cols="100" rows="25"><?php //echo $row["content"] ?> </textarea>  -->
		
	<?php  include("wysiwyg/fckeditor.php") ;
	       $oFCKeditor = new FCKeditor('content') ;
		   $oFCKeditor->Width = "400" ; // 250 pixels
		   $oFCKeditor->Height = "400" ; // 250 pixels
		   $oFCKeditor->ToolbarSet = 'Basic';
		   $oFCKeditor->BasePath = 'wysiwyg/' ;	// '/fckeditor/' is the default value.
		   $oFCKeditor->Value = $row["content"];
		   $oFCKeditor->Create() ;
	?>	
	
	</td>
	</tr>
								
	<?php  //This is the data for displaying images 
	
	if ($row["image"]!="") {
	$imagepath = '../images/'.$pageType;
	$fullImagepath = $imagepath."/".$row["image"];?>
	<tr height="30">
	<td class="title1" align="right" > Current Image </td>
	<td>
									
	<?php
	
	//this include has a function to determine the images size and generate its new target size 
	//include ("image_resize.php");
	//get the image size of the picture and load it into an array value[0] is width value[1] is height value[2] is type
	// imageresize functionn returns new width and height in  html format
	//$myimageArray= getimagesize( $fullImagepath) ;?>
											
	<img src="<?php echo $fullImagepath ;?>"	 <?php //echo imageResize($myimageArray[0], $myimageArray[1], 250); ?>    />
	</td>
	</tr> 
									
	<tr height="30">
	<td class="title1" align="right" > </td>
	<td>
									
	<?php if (!$changepage==1) { ?>
	<a href="<?php echo $_SERVER['PHP_SELF'] ?>?cms_uid=<?php echo $cms_uid ?>&changepage=1&pageType=<?php echo $pageType ?>"><p>Change Image</p></a> <?php } ?>
	<?php if ($changepage==1) { ?> <input type="file" class="formbox" name="file1" value="<?php $row["image"] ?>"> <?php } ?>
	</td>
	</tr> 
																																										
	<?php }else {?>
									
	<tr height="30">
	<td class="title1" align="right" > Image </td>
	<td>
									
	<input type="file" class="formbox" name="file1" value="<?php $row["image"] ?>" size="40">
	</td>
	</tr> 

	<?php }  ?>

 	<tr height="30">
	<td class="title1" align="right" > Status </td>
	<td>
	
<select name="status" class="formbox" >   <?php echo $row["status"] ?>   
<option value="1" <?php if ($row["status"]==1 || $newItem==1) {echo "selected";}?>  > Active
<option value="0" <?php if ($row["status"]==0 &&  $newItem!=1) {echo "selected";} ?>> Inactive
</select>

	
	</td>
    </tr> 

	<tr>
	<td>&nbsp;</td>
	<td style="padding-left:175px; height: 20px; margin-bottom:0px; " >
	<input type="submit" name="submit" class="formbox" value="submit">
	</form>
	</td>
	</tr>
								
  </table> 
