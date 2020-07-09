				<div id="artistDesc">
					<img alt="<?=$artist->name?>" title="<?=$artist->name?>" class="logo" src="<?=$artist->image('home',array('default'=>'png','defaultFileName'=>@$defaultFileName)) ?>" width="240" />
					<p><?=paragraphs($artist->bio)?></p>
				</div>
