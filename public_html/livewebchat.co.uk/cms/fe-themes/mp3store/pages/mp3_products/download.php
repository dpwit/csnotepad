<?
	$track = Model::loadModel('MP3')->get(array_pop($trailing));
	$track->checkDownload($full,$trailing);
	if(session_id()) session_write_close();
	error_log(json_encode($trailing));
	$type = array_shift($trailing);
	$quality = array_shift($trailing);
	error_log($quality);
	$track->download($quality);
	exit();
