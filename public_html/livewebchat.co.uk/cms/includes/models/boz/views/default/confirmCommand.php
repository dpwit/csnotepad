<h2><?=ucwords($command)?></h2>
<p>Are you sure you want to <?=strtoupper($command)?>?</p>
<form method='post'>
	<input type='submit' name='confirm' value='Yes' class='coolButton'/>
	<input type='button' value='No' class='coolButton' onClick='javascript:history.go(-1)'/>
</form>
