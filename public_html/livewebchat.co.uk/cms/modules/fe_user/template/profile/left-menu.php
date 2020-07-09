<?
/**
* @package Elite_Promo
*/

	$user = Model::loadModel('User')->getLoggedInUser();
?>
<h3><?=$user->getLabel()?></h3>

<div id="list">
<ul>
<li><a class="item" href="/release/edit?release=NEW">Add New Release</a></li>
	<li><a class="item" href="http://www.elitepromo.dj/dashboard.html">Dashboard</a></li>
	<li><a class="item" href="http://www.elitepromo.dj/profile.html">Profile</a></li>
	<li><a class="item" href="http://www.elitepromo.dj/topup.html">Top Up</a></li>
</ul>
</div>
<br/>
<h3>Credits</h3>
<div><?php //	$credits = Component::get('AccountInfo',$user); echo $credits->doHTML()?></div>
<div><?=$user->getCredits(); ?> </div>
<?php 
?>
