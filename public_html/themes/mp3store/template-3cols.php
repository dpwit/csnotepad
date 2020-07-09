<?
	include($context->findTemplate('structure/header'));
?>
			<div id="leftSide">
				
				<div id="feature">
					<?$this->renderComponent('col2')?>
				</div>
				
				<div class="col">
				
					<div class="noBorder box" id="news">
						<h2 class="blue">News</h2>
						<ul>
							<li>
								<a href="#"><img src="images/placeholder_small.png" alt="Foama: New Signing"/></a>
								<h3>Foamo: New Signing</h3>
								<p>At the age of 22, Foamo aka Kye Gibbon has already...</p>
								<a href="" class="more">More</a>
							</li>
						</ul>
						<a class="footer" href="archive.php">News Archive</a>
					</div>
					
				</div>
				
				<div class="col">
				
					<div class="thickBorder box" id="featuredShop">
						<h2>Featured from the Shop</h2>
						<ul>
							<li>
								<img src="images/placeholder.png" alt="JGB - The Guild Master" />
								<h3>JFB<br />
								The Guild Master</h3>
								<p>From the classic garage anthem Rip Groove, to his hug...</p>
								<div class="left buylisten"><a href="#" class="listen">Listen</a> <a href="#" class="buy">Buy</a></div>
							</li>
						</ul>
					</div>
					
					<div class="thinBorder box" id="latestMerch">
						<div class="overflow">
							<h2 class="smaller blue">Latest Merchandise</h2>
							<a href=""><img src="images/merch.jpg" alt="Shirt" /></a>
							<h3>2009-10 Adults Home Shirt - Short sleeved<br />
							£9.99</h3>
							<a href="" class="more">More</a>
						</div>
					</div>
					
				</div>
			
			</div>
			
			<div id="rightSide">
			
				<div class="last col">
			
					<div class="thickBorder box" id="top10">
						<?$this->renderComponent('col3')?>
					</div>
					
				</div>
					
			</div>

<!--
			<div id="columnCol1" class="column">
				<?$this->renderComponent('col1Header')?>
				<?$this->renderComponent('col1')?>
			</div>
			
			<? $this->renderComponent('doubleColHeader',array('skipWrap'=>true))?>
				<div id="columnCol2" class="column">
					<?$this->renderComponent('col2')?>
	            </div>
	
	            <div id="columnCol3" class="column">
					<?$this->renderComponent('col3')?>
				</div>
-->
<?
	include($context->findTemplate('structure/footer'));
?>
