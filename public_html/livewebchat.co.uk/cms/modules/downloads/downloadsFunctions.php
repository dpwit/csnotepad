<?php

	function readFiles($folder) {

		$baseDir = BASEPATH.$folder;
		//NetDebug::trace("opening directory".SERVER_ROOT.$folder);
			//echo $baseDir;
		$files = array();
		
		if ($dir = opendir($baseDir)) {
			while ($file = readdir($dir)) {
				if ($file != "." && $file != "..") {
					if (!is_dir($baseDir . "/" . $file)) {
						$files[] = $file;
					}
				}
			}
			
			closedir($dir);
			
		}else 
		{
		echo "could not open directory";
		}
		
		sort($files);	
		return $files;	
	}
	
	function listFiles ($folder,$currentSelection) {
	
	
	
	$fileArray = readFiles ($folder);
	$arrayLength =  count($fileArray)-1;

	//echo $arrayLength;
	
	//echo $fileArray[0];	echo $fileArray[1];?>
    <option value="None" <?php if ($currentSelection==$fileArray[$i]) {echo "selected";}?> >No File
	<?php for ($i = 0; $i <= $arrayLength ; $i++) {?>
   
	<option value="<?php echo $fileArray[$i]; ?>" <?php if ($currentSelection==$fileArray[$i]) {echo "selected";}?> ><?php echo $fileArray[$i]; ?>
	
	<?php
		
	}
}


	
?>


