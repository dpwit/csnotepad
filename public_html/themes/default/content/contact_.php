<script type="text/javascript">
$(document).ready(function(){
//	$(".form_row-captcha").hide();
});
$('#columnDouble').click(function() {
//	alert("WORKING");
//	$('.form_row-captcha').slideDown('slow', function() {
//	});
});
</script>

<?
$contact = Model::loadModel('Contact')->createNew();
$contact->targetEmail = 'don@don-benjamin.co.uk';
$contact->getForm();
if($_POST) { 
	try {
		$contact->save($contact,$_POST);
?>
	<h3 class="headerText">Message Sent</h3>

<p>Thank you for your message - we will get back to you as soon as possible.Your message has been sent</p>
<?
	} catch(Exception $e){
	}
}
if(!$contact->exists()){
?>
<form method='post'>

<div id='contactContent'>
<h2 class="headerText">Send Us A Message</h2>
<?
$contact->getForm();

/* 
$suppressLabel = array('favourite_labels');
var_dump($fields);
foreach($contact->form->inputs as $field){
echo $field['label']."<br/>";
}
$sections = array(
'Edit Release' => array('name','artist','label_uid','release_date','expiry_date','upc','status'),
'Artwork' => array('cover_image'),
'Select Genres' => array('genres'),
);
*/

foreach($contact->form->inputs as $key => $field){
	if($key=='uid') continue;
	if($key=='name') continue;
	if($key=='surname') continue;
	if($key=='phone') continue;
?>
	<? if ($field['errors']) { ?><div class='error'><?=$field['errors']?></div><? } ?>
	<div class='form_row form_row-<?=$key?> clearfix'>
		<div class='form_label'><?=$field['label']?></div>
		<div class='form_input'><?=$field['html']?></div>
	</div>
<?
}

?>
<div class='form_footer clearfix'>
	<input type='submit' class="buttonSubmit" value='Send'/>
</div>
</div>
</form>
<? } ?>
