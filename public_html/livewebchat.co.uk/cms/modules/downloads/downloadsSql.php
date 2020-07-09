<?php 

$sql_list = "SELECT * FROM downloads ORDER BY uid DESC ";

$sql_newItem  = "INSERT INTO downloads ( isFile,fileVar, description, title, category, status,restricted) VALUES ( '$isFile','$fileVar','$description', '$title', '$category', '$status' ,'$restricted')";

$sql_edit = "UPDATE downloads SET fileVar ='$fileVar', isFile ='$isFile',   title ='$title', category ='$category',  description ='$description', status ='$status' , restricted='$restricted' WHERE uid= '$cms_uid' ";

$sql_delete= "DELETE FROM downloads WHERE uid= '$cms_uid'";

?>


