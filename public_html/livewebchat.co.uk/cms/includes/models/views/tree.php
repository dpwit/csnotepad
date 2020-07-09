<style>
	.uninitialised .list {
		display: none;
	}
</style>
<?
function drawTree($item){
	$type = $item->getTableName(false);
?>
<div class='<?=$type?> container uninitialised' id='<?=$type?>-<?=$item->getID()?>'><div class='<?=$type?>-name name'><?=$item->getLabel()?></div>
<div class='<?=$type?>-actions actions'><?
	$actions = $item->getCmsActions();
	foreach($actions as $link=>$label){ ?>
		<a class='overviewAction overviewAction-<?=strtolower(str_replace(" ","_",$label))?>' href='<?=$link?>'><span class='actionText'><?=$label?></span></a>  
	<? } ?>
</div>
<? 
		if($item->hasChildren()) { 
			$childModel = $item->getChildModel();
?>
	<span style='display: none' class='childtype'><?=trim($childModel->getEnglishName(false))?></span>
<div class='<?=$type?>-list list'>
<?	foreach($item->children() as $child)
		drawTree($child);
?>
	</div>	<!--<?=$type?>-list list -->
<?
	}	
?>
<div style='clear: both'></div>
</div>		<!--<?=$type?> container -->
<?
}
class RootModel extends Model {
	function __construct($childModel){
		$this->childModel = $childModel;
	}
	function getChildModel(){
		return $this->childModel;
	}
	function hasChildren(){
		return true;
	}
	function children(){
		return $this->childModel->getAll();
	}
	function getTableName(){
		return "treeroot";
	}
	function getCmsActions(){
		return array();
	}
}
foreach($model->getAll() as $model){
	drawTree($model);
}
?>
<script>
	$(function(){
		var splitAssoc = function(cookie){
			var ca = cookie ? cookie.split('/') : [];
			var cm = {};
			for(var a = 0 ; a<ca.length ; a++){
				cm[ca[a]] = true;
			}
			return cm;
		};
		var Cookie = {
			cookies: splitAssoc($.cookie('category-tree')),
			setCookie: function(id,val){
				Cookie.cookies[id]=val;
				var assembled=[];
				for(k in Cookie.cookies){
					if(Cookie.cookies[k]) assembled.push(k);
				};
				$.cookie('category-tree',assembled.join('/'));
			},
			toggle : function(id){
				return Cookie.isOpen(id)?Cookie.close(id):Cookie.open(id);
			},
			open: function(id) {
				Cookie.setCookie(id,true);
				var type = id.replace(/-.*/,'');
				$('#'+id+' .'+type+'-list').slideDown();
				$('#toggle-'+id).text("Hide");
				$('#toggle-'+id).addClass('toggle-open');
				$('#toggle-'+id).removeClass('toggle-hide');
			},
			close: function(id) {
				Cookie.setCookie(id,false);
				var type = id.replace(/-.*/,'');
				$('#'+id+' .'+type+'-list').slideUp();
				$('#toggle-'+id).text("Show");
				$('#toggle-'+id).addClass('toggle-hide');
				$('#toggle-'+id).removeClass('toggle-open');
			},
			isOpen: function(id) {
				return Cookie.cookies[id];
			},
			copy: function(id){
				$('.paste-link').show();
				Cookie.copied = id;
			},
			paste: function(id){
				document.location.href="despatch.php?model=Item&cms_uid="+Cookie.copied.replace(/.*-/,'')+"&action=copy&parent_uid="+id.replace(/.*-/,'');
			}

		}

		$('.container').each(function(){
			el = $(this);
			name = el.children('.name');
			childType = el.children('.list').children('.childtype');
			list = el.children('.list');
			var open = Cookie.isOpen(el.attr('id'));
			if(!open) list.hide();
			$("<a href='#' class='list-toggle toggle-"+(open?"open":"hide")+"' id='toggle-"+el.attr('id')+"' >"+(open?"Hide":"Show")+"</a>").insertBefore(list);
			toggleTree =function(){
				var el = $(this); 
				Cookie.toggle(el.closest('.container').attr('id')); return false;
			};
			el.children('.list-toggle').click(toggleTree);
			name.click(toggleTree);
		});
		$('<div class="new-actions"></div>').appendTo('.list');
		$('<div class="new-actions"></div>').prependTo('.list');
		$('<div class="new-link"></div>').appendTo('.new-actions');
//		$('<div class="duplicate-link paste-link overviewAction"><a class="duplicate-action overviewAction overviewAction-paste" href="#"><span class="actionText">Paste</span></a></div>').appendTo('.package-list .new-actions');
		$('.new-link').each(function(){
			var el = $(this);
			var parent = el.closest('.container');
			var parentId = el.closest('.container').attr('id');
			var label = parent.children('.name').text();
			if(parentId) parentId="&parent_uid="+parentId.replace(/.*-/,'');
			else parentId='';
			var container = el.closest('.list');
			var type=parent.children('.childtype').text();

			$("<a href='newItem.php?pageType=categories"+parentId+"&model="+type+"' class='overviewAction overviewAction-new'><span class='actionText'>New "+type+(label?" in "+label:"")+"</span></a>").appendTo(el);
		});
		$('.paste-link').hide();
		$('.duplicate-action').click(function(){
			var pasteTo = $(this).closest('.container').attr('id');
			Cookie.paste(pasteTo);
			return false;
		});
		$('<a class="overviewAction overviewAction-copy copy-link" href="#"><span class="actionText">Copy</span></a>').appendTo($('.item-actions'));
		$('.overviewAction-copy').click(function(){
			Cookie.copy($(this).closest('.container').attr('id'));
			return false;
		});
		$('.overviewAction').each(function(){
			var link = $(this);
			link.attr('title',link.find('span').text());
		});
		$('<div style="clear:both"></div>').appendTo('.list');
		$('<div style="clear:both"></div>').appendTo('.new-actions');
		$('.uninitialised').removeClass('uninitialised');
	});
</script>
