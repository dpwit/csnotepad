				<div class="thinBorder eventsList box" id="artistsList">
					<h2>Information</h2>
					<ul>
<?
$infoPageFactory = Model::loadModel('infoPages');
$where = array();
$where['status'] = 1;
$infoPages = $infoPageFactory->getAll($where,array('order'=>'sorting asc'));
$isthislast=count($infoPages);
foreach($infoPages as $infoPage){
	
		$url = $infoPage->getURL();
		
		$urlPrefix = '';
									
		$class = BreadCrumb::selected($url)? ' on' : '';
		$nameTitle = $infoPage->title;
		$nameTitle = substr_words(32,$nameTitle);
?>
						<li class="<?=$class?>">
							<h3><a href="<?=$infoPage->getURL()?>"><?=$nameTitle?></a></h3>
						</li>
							<?
						}
						?>
					</ul>
				</div>
		 
