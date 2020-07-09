			<?php 
			
			// image upload will check if there is an image to upload
			$uploadpath =  BASEPATH."/images/$pageType/originals/";							
			include("scripts/image_upload.php"); 
			//echo $origVideo.'is the original video';
			//$dest will be populated by image upload script if there was a valid POST file with the $image var	
			if ($dest=="undefined")  {
			echo "No image was included"; 
			$image = $origimage;
			
			if ($origthumb) {
			
			$image = $origthumb;
			
			}
				
			
			} else {
				
			echo "Resizing Images\n";
			//echo BASEPATH;     
			$image = $fileName;
		//	echo $image.'is the image\n';
			
			
				if (!$_POST['video'] && !$_POST['$origVideo'] ) 
				{
				include("scripts/thumbnail_generator.php");
				//echo 'No video was included'; 
	
				/*
				Function createthumb($name,$filename,$new_w,$new_h)
				creates a resized image
				variables:
				$name		Original filename
				$filename	Filename of the resized image
				$new_w		width of resized image
				$new_h		height of resized image
				*/	
								
				$origPath =BASEPATH."images/$pageType/originals/";
				$thumbpath =BASEPATH."images/".$pageType."/thumbs/";
				$finalpath =BASEPATH."images/".$pageType."/";
				$name = $image;
				$thumbName = $image;
				
				//maxThumbSize and maxImageSize - these must be posted in via the form
				$thumbMaxSize=$maxThumbSize;
				$imageMaxSize=$maxImageSize;
				createthumb($origPath.$name,$thumbpath.$thumbName,$thumbMaxSize,$thumbMaxSize);
				createthumb($origPath.$name,$finalpath.$thumbName,$imageMaxSize,$imageMaxSize);
				
				}else {
				
				//it is a video
				echo 'video was included . thumbfolder is'.$thumbFolder ; 
				
				include("scripts/thumbnail_generator.php"); 
				if ($origVideo) {$video = $origVideo;}
				$origPath =BASEPATH."images/originals/";
				$thumbpath =BASEPATH."images/".$thumbFolder."/thumbs/";
				$finalpath =BASEPATH."images/".$thumbFolder."/";
				$name = $image;
				$thumbName = $image;
								
				
				//maxThumbSize and maxImageSize - these must be posted in via the form
				$thumbMaxSize=$maxThumbSize;
				$imageMaxSize=$maxImageSize;
				createthumb($origPath.$name,$thumbpath.$thumbName,$thumbMaxSize,$thumbMaxSize);
				createthumb($origPath.$name,$finalpath.$thumbName,$imageMaxSize,$imageMaxSize);
			
				} 
			// end image upload 
			}
			?>
