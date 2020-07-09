<?php
/**
* @package BozBoz_CMS
*/

header('Content-disposition: attachment; filename='.$file);
readfile($file);
?>