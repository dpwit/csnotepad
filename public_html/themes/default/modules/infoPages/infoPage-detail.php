<div id="infoPage">
<?
$infoPageFactory = Model::loadModel('infoPages');
$where = array('urlTitle'=>basename($_SERVER['REQUEST_URI']));
$where['status'] = 1;
$infoPage = $infoPageFactory->getFirst($where);
?>
		<h3><?=$infoPage->title?></h3>
		<?=$infoPage->text?>
</div>