<?
if(!defined('__PATH_CONVERT__')) define('__PATH_CONVERT__','convert');
/**
* @package Model_System
*/

class BaseResizer {
	function passthru($cmd,&$return=null){
		passthru($cmd,$return);
		if($return){
			var_dump(get_class($this));
		}
	}
	function isJpeg($fileName){
		return preg_match("/\.jpe?g$/i",$fileName);
	}
}
class ImageResizer extends BaseResizer{
	function resize($obj,$size,$field,$fileName,$newFile){
		$skey = ($size=='') ? 'full' : $size;
		$width = $field->param($skey."Width");
		$height = $field->param($skey."Height");
		$quality = $field->param('jpegQuality');
		$extraArgs = ($quality && $this->isJpeg($newFile)) ? ' -quality '.$quality : '';
		switch($size) {
			case 'thumb':
				if(!$height) $height=$width;
				$this->passthru($cmd = __PATH_CONVERT__." -resize ".$width."x$height^ -gravity center -extent $width"."x$height $extraArgs \"$fileName\" \"$newFile\" 2>&1",$return);
				if($return) die($cmd);
				break;
			default:
				$this->passthru($cmd = __PATH_CONVERT__." -resize ".$width."x$height $extraArgs \"$fileName\" \"$newFile\" 2>&1");
		}
	}
}
class ImageResizerCropSquare extends BaseResizer{
	function resize($obj,$size,$field,$fileName,$newFile){
		$skey = ($size=='') ? 'full' : $size;
		$width = $field->param($skey."Width");
		$height = $field->param($skey."Height");
		if(!$width) $width=$height;
		if(!$height) $height=$width;
		$quality = $field->param('jpegQuality','69');
		$extraArgs = ($quality && $this->isJpeg($newFile)) ? ' -quality '.$quality : '';
		switch($skey) {
//			case 'thumb':
			default:
				$this->passthru($cmd = __PATH_CONVERT__." -resize ".($width*2)."x -resize 'x".($height*2)."<' -resize 50% -gravity center -extent $width"."x$height $extraArgs \"$fileName\" \"$newFile\" 2>&1",$output);
				error_log("Command: $cmd");
				error_log("Output : $output");
//				passthru($cmd = __PATH_CONVERT__." -thumbnail ".$width."x$height^ -gravity center -extent $width"."x$height $extraArgs \"$fileName\" \"$newFile\" 2>&1");
				break;
//			default:
//				passthru($cmd = __PATH_CONVERT__." -resize ".$width."x$height $extraArgs \"$fileName\" \"$newFile\" 2>&1");
		}
	}
}
class ImageResizerFitInBounds extends baseResizer {
	function resize($obj,$size,$field,$fileName,$newFile){
		$skey = ($size=='') ? 'full' : $size;
		$width = $field->param($skey."Width");
		$height = $field->param($skey."Height");
		$quality = $field->param('jpegQuality','69');
		$extraArgs = ($quality && $this->isJpeg($newFile)) ? ' -quality '.$quality : '';
		switch($size) {
			case 'thumb':
			default:
				$this->passthru($cmd = __PATH_CONVERT__." -resize ".$width."x$height -gravity center $extraArgs \"$fileName\" \"$newFile\" 2>&1",$return);
				if($return) die($cmd);
				break;
		}
	}
}
class ImageResizerFitAndPad extends baseResizer {
	function resize($obj,$size,$field,$fileName,$newFile){
		$skey = ($size=='') ? 'full' : $size;
		$width = $field->param($skey."Width");
		$height = $field->param($skey."Height");
		$fill = $field->param($skey."Background",'white');
		if(!$width) $width = $height;
		if(!$height) $height = $width;
		$quality = $field->param('jpegQuality','69');
		$extraArgs = ($quality && $this->isJpeg($newFile)) ? ' -quality '.$quality : '';
		switch($size) {
			default:
			//ImageMagick 6.3.2+
			//$this->passthru($cmd = __PATH_CONVERT__." -resize ".$width."x$height -background \"$fill\" -extent {$width}x{$height} -gravity center $extraArgs \"$fileName\" \"$newFile\" 2>&1",$return);
			//Old ImageMagick
			$this->passthru($cmd = __PATH_CONVERT__." -define jpeg:size=".($width*2)."x".($height*2)." \"$fileName\" -thumbnail '{$width}x{$height}>' -bordercolor \"$fill\"  -border 50 -gravity center  -crop {$width}x{$height}+0+0 +repage \"$newFile\"",$return);
			if($return) die($cmd);
			break;
		}
	}
}
