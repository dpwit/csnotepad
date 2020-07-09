<div class="form_main">
<div id="contentRegister">
<h2 class="headerText">Create a user</h2>
<form method='post'>
<div class="form_label">User Name</div>  <div class="form_input"><input type='text' name='user-NEW-userid'/></div>
<div class="form_label">Choose Password</div>  <div class="form_input"><input type='password' name='user-NEW-password'/></div>
<div class="form_label">Choose Password</div>  <div class="form_input"><input type='password' name='user-NEW-passwordconfirm'/></div>
<div class="form_label">Email</div>  <div class="form_input"><input type='text' name='user-NEW-email'/></div>
 <div class="form_footer">
<input type='submit' value='Register' name='register'/>
<input type='hidden' name='no-redirect' value='true'/>
<?=@$hidden?></div>
</form>
<?
	//include(__MODELS_BASE__.'/boz/views/default/form.php');
?>
</div> <!-- end register -->
<div id="contentLogin">
<h2 class="headerText">Or login</h2>
<form method='post'>
<div class="form_label">User Name</div> <div class="form_input"><input type='text' name='un'/></div>
<div class="form_label">Password</div>  <div class="form_input"><input type='password' name='pw'/></div>
 <div class="form_footer">
<input type='submit' value='Login' name='login'/>
<input type='hidden' name='no-redirect' value='true'/>
<?=@$hidden?></div>
</form>
</div> <!-- end login -->

</div> <!-- end form_main -->
