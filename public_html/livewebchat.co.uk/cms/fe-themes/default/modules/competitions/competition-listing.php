				<div id="newsDesc">
<?
$currentLabel = MultiLabelContext::getLabel();
$where = $currentLabel? array('label_uid' => $currentLabel) : array();
$competitionFactory = Model::loadModel('competitions');
$competitions = $competitionFactory->getAll($where,array('limit'=>1,'order'=>'cdate desc'));
foreach($competitions as $competition){
?>
					<h3><?=$competition->title?></h3>
					<p><?=$competition->shorttext?></p>
					<p><?=paragraphs($competition->content)?></p>
					<div class="bookmark">
						<span>Bookmark:</span> 
						<a href="http://www.facebook.com/sharer.php?u="><img src="images/social_fb.gif" alt="Bookmark with Facebook"></a> 
						<a href="http://del.icio.us/post?url="><img src="images/social_del.gif" alt="Bookmark with Delicious"></a>
						<a href="http://digg.com/submit?url="><img src="images/social_digg.gif" alt="Bookmark with Digg"></a> 
						<a href="http://reddit.com/submit?url="><img src="images/social_red.gif" alt="Bookmark with Reddit"></a> 
						<a href="http://www.stumbleupon.com/submit?url="><img src="images/social_su.gif" alt="Bookmark with StumbleUpon"></a>
					</div>
<?php 
}
?>
</div>
</div>
<?php
	$defaultFileName = 'default-skint';
	if($competition->label_uid==2) $defaultFileName = 'default-loaded';
?>
<div class='last col'>
<div id="newsFeaturedImage">
<img class="newsarticleimg" src='<?=$competition->image('photo',array('default'=>'png','defaultFileName'=>$defaultFileName))?>'/>
<?php
if (!$_GET) { 
?>
<form method="post" action="/competition-process.php" class="CompetitionEntry">
<h3>Enter the Competition:</h3>
	<input type="hidden" name="competition_uid" value="<?=$competition->uid?>">
	
	<?php $errors = $_SESSION['competition_errors'] ? $_SESSION['competition_errors'] : array() ?>
	
	<span class="error"><?=$errors['fullName']?></span>
	<label>Name*:</label> <input type="text" name="fullName" value="<?=$_SESSION['competition_answers']['fullName']?>">
	<span class="error"><?=$errors['emailAddress']?></span>
	<label>Email Address*:</label> <input type="text" name="emailAddress" value="<?=$_SESSION['competition_answers']['emailAddress']?>"><br/>
	<label>Phone Number:</label> <input type="text" name="phoneNumber" value="<?=$_SESSION['competition_answers']['phoneNumber']?>"><br/>
	<span class="error"><?=$errors['answer']?></span>
	<label>Answer*:</label> <input type="text" name="answer" value="<?=$_SESSION['competition_answers']['answer']?>">
	<span>* - Required Field</span>
	<input type="submit" value="Enter" class="coolButton">
	<?php unset($_SESSION['competition_errors']); ?>
</form>
<?php } else if ($_SERVER['QUERY_STRING'] == 'thanks') { ?>
<p class="thanks">Thanks! Your competition entry has been saved.</p>
<?php } ?>
</div>
</div>
