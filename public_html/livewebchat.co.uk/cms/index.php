<?php include 'requiredConnections.php' ;
/**
* @package BozBoz_CMS
*/

 $rootpath=" " ;
 if(@$pageFile){
	 include($pageFile);
 } else {
	 if(!@$pageType)
		 $pageType=cms_call_hook('get_default_page_type',false);
	 if(!@$pageAction=$_REQUEST['action'])
		 $pageAction=cms_call_hook('get_default_action','overview');
	if(!@$pageType){
		$user = Model::loadModel('User')->getLoggedInUser();
		$defUrl = $user->UserGroup()->defaultUrl;
		$defUrl = cms_apply_filter('cms_landing_page',$defUrl);
		if($defUrl){
			redirectTo($defUrl);
		}
		if($defUrl){
			die('<head><meta HTTP-EQUIV="refresh" content="1;url=http'.(@$_SERVER['HTTPS']?'s':'').'://'.$_SERVER['HTTP_HOST'].$defUrl.'"></head>');
		}
	}
	require(dirname(__FILE__).'/overview.php');
 } /* else $pageFile */
 include("footer.php"); 
?>  

</body>
</html>
