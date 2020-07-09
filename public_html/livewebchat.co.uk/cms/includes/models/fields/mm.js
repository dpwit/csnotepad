$(function(){

	var dialog;
	var removeFun = function(){$(this).closest('li').remove(); return false;};
	var setFCKVals = function(inEl){
		//TODO: Better test for fckeditor
		if(inEl.find('iframe').is('iframe'))
		inEl.find('input').each(function(){
			var el = $(this);
			var v = el.val();
			var fck = FCKeditorAPI.GetInstance(el.attr('name'));
			if(fck) v = fck.GetHTML();
			el.val(v);
		});
	};
	var moveUpFun = function(){
		var myItem = $(this).closest('li');
		var prev = myItem.prev('li');
		if(prev.is('.mm-example') || !prev.is('li')) return false;
		setFCKVals(myItem);
		myItem.remove();
		prev.before(myItem);
		initItem(myItem);
		return false;
	};
	var moveDownFun = function(){
		var myItem = $(this).closest('li');
		var prev = myItem.next('li');
		if(!prev.is('li')) return false;
		setFCKVals(myItem);
		myItem.remove();
		prev.after(myItem);
		initItem(myItem);
		return false;
	};
	var initItem = function(index,el){
		var item = $(el);
		item.removeClass('new-item');
	};
	$('a.mm-remove-link').die('click').live('click',removeFun);
	$('a.mm-move-up-link').die('click').live('click',moveUpFun);
	$('a.mm-move-down-link').die('click').live('click',moveDownFun);
	var initBoxy = function(){
		$('.mm-tree .item-title').toggle(function(){
			$(this).closest('.item').find('.children').slideDown();
		}, function(){
			$(this).closest('.item').find('.children').slideUp();
		});
		$('.mm-tree a').click(function(){
			var parts = this.id.split("-");
			var id = parts[1];
			var name = parts[2];

			var html = lastMM.find('.mm-example').html();
			oldHtml=false;
			while(html!=oldHtml){
				oldHtml=html;
				html=html.replace("###TEMPLATE_ID###",id);
				html=html.replace("###TEMPLATE_NAME###",$(this).text());
			}
			lastMM.find('.mm-items').append($("<li class='new-item'>"+html+"</li>"));
			$('.new-item').each(initItem);
		});
	}
	var init = function(){
		$('.mm-items li').each(initItem);
//		$('.mm-selector').append("<div class='mm-add-link'><a href='#'>Add Item</a></div>");
		$('.mm-add-link a').click(function(){
			dialog = Boxy.load('/cms/includes/models/fields/mmselect.php?rel='+$(this).closest('.mm-selector').attr('rel'),{modal:true, closable:true,title: "Select",afterShow:initBoxy,draggable: true,y:100,unloadOnHide:true});
			lastMM=$(this).closest('.mm-selector');
			return false;
		});
		initBoxy();
	};
	init();
});
