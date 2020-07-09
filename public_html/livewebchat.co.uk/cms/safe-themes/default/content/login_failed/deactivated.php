<?
	$user = Model::loadModel('User')->getFirst(array('userid'=>$_GET['user']),array('show_deleted'=>1));
?>
<div id="errorBox">
<h3 class="headerText">Login Failed</h3>
<p>This user name is not active, would you like to <a href='/user/reactivate/<?=$user->getId()?>'>request reactivation?</a></p>
</div>