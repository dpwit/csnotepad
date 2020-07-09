<h2>Testimonials</h2>
<img alt="separator" src="images/separatorSmall.png">

<?php

$testimonials = Model::g('Testimonial',array('url'=>$_SERVER['REQUEST_URI']));
//var_dump($testimonials->uid);
if(!$testimonials)
	$testimonials = Model::g('Testimonial',array(),array('order_explicit'=>true,'order'=>'rand()'));
;
?>
<br>
<br>
<p>
	<em>"<?=$testimonials->comment1?>"</em>
</p>
<h4 style="text-align: right;"><?=$testimonials->citation1?></h4>
<br>
<p>
	<em>"<?=$testimonials->comment2?>"</em>
</p>
<h4 style="text-align: right;"><?=$testimonials->citation2?></h4>