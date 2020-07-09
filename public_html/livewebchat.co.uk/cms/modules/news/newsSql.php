<?php 
/**
* @package BozBoz_CMS
*/


$sql_list = "SELECT * FROM news ORDER BY uid DESC ";

$sql_newItem  = "INSERT INTO news ( title, shorttext,  content, image, keywords, status ) VALUES ('$title','$shorttext', '$content', '$image', '$keywords', '$status' )";

$sql_edit = "UPDATE news SET title ='$title', shorttext ='$shorttext', content ='$content',status ='$status', image='$image', keywords='$keywords' WHERE uid= '$cms_uid' ";

$sql_delete ="DELETE FROM news WHERE uid= '$cms_uid'";

?>