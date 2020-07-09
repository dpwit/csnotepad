<div class='two-cols'>
<div class='left col'>
<h2>Fuga Has Created The <?=$item->getEnglishName(false)?> <?=$item->getLabel()?></h2>
<p>This <?=$item->getEnglishName(false)?> has been created for the following items.</p>
<?
foreach($listings as $func){
	$results = $item->$func();
	if(!$results) continue;
?>
	<p><?=count($results)?> <?=$results[0]->getEnglishName(true)?>:</p>
<ul>
<?
	foreach($results as $release){
?>
	<li><a href='<?=$release->urlFor('editItem')?>'><?=$release->getLabel()?></a></li>
<?
	}
?>
</ul>
<? } ?>
</div>
<div class='right col'>
<div class='action'>
<p>If you expected a new <?=$item->getEnglishName(false)?> to be created click <a href='<?=$item->urlFor('editItem')?>'>here to fill out the rest of their details.</a></p>
</div>
<div class='action'>
<p>If not possibly you expected one of the existing <?=$item->getEnglishName(true)?>, if so select that <?=$item->getEnglishName(false)?> below and all the tracks/releases will be transferred into their name.</p>
<p>Similar <?=$item->getEnglishName(false)?>:</p>
<ul>
<?
	$q = $item->getLike($item->getLabel(),array('limit'=>10,'for_fetch'=>1,'restrict'=>array('uid !='=>$item->getId())));

	$found=array();
	while($alt = $q->fetch()){
		$found[" ".$alt->getId()] = $alt->getLabel();
	}
	$q = $item->getAll(array('uid !='=>$item->getId()),array('order'=>$item->getLabelField(),'for_fetch'=>1));
	while($alt = $q->fetch()){
		$possible[" ".$alt->getId()] = $alt->getLabel();
		$alt->__destroy();
	}

	class SimilarSorter {
		var $distances = array();
		function __construct($comparison){
			$this->comparison = $comparison;
		}
		function dist($a){
			if(!@$this->distances[$a]){
				$this->distances[$a] = levenshtein(metaphone($this->comparison),metaphone($a));
			}
			return $this->distances[$a];
		}
		function compare($string1,$string2){
			$a = $this->dist($string1);
			$b = $this->dist($string2);
			if($a==$b) return 0;
			else return ($a<$b)?-1:1;
		}
	}

	$sorted = $possible;
	uasort($sorted,array(new SimilarSorter($item->getLabel()),'compare'));
	$sorted = array_slice(array_merge($found,$sorted),0,20);
	foreach($sorted as $id=>$label){
		$id = trim($id);
?>
		<li><a href='<?=$this->urlFor('remap'.$item->getEnglishName(false),array('from'=>$item->getId(),'to'=>$id))?>'><?=$label?></a></li>
<?
	}
?>
</ul>
<p>All Other Artists:</p>
<ul>
<?

	foreach($possible as $id=>$label){
		$id = trim($id);
?>
	<li><a href='<?=$this->urlFor('remap'.$item->getEnglishName(false),array('from'=>$item->getId(),'to'=>$id))?>'><?=$label?></a></li>
<?
	}
?>
</ul>


</div>
</div>
</div>
