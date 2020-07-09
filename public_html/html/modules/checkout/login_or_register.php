
<div id="shop">

<div class="form_main">
<div id="contentRegister">
<?
	$submitLabel = 'Register';
	$sections = array(''=>array('userid','password','passwordconfirm','email'));
	include(__MODELS_BASE__.'/boz/views/default/form.php');
?>
</div> <!-- end register -->
<div id="contentLogin">
<?
	if($reason = @$_GET['failure_reason']){

?>
	<div class='error'>
<?	switch($reason){ 
	case 'not_matched': default:
?>
	<p>Your login details have not been recognised.  Please try again.</p>
<? 	} ?>
		
	</div>
<?
	}
?>
<form method='post'>
<div class="form_label">User Name</div> <div class="form_input"><input type='text' name='un'/></div>
<div class="form_label">Password</div>  <div class="form_input"><input type='password' name='pw'/></div>
 <div class="form_footer">
<input type='submit' value='Login' class='coolButton' style="margin: 0" name='login'/>
<input type='hidden' name='no-redirect' value='true'/>
<?=$hidden?></div>
</form>
<div class="form_footer"><a href='/forgot-password.html'>Forgot Password?</a></div>
</div> <!-- end login -->

<div style="clear: both">

</div> <!-- end form_main -->

</div>
</div>