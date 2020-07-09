		  $(function(){
		  	$(".toprounded").corner("top 10px cc:#B5B5B5");
		  	$(".bottomrounded").corner("bottom 10px cc:#B5B5B5");
			$("a.item").corner();
		  	$(".menuitem").corner("top 8px");
		  	$(".formHeading").corner("5px");
		  	$(".panel a").corner("5px");  	
		  	$(".outlinehighlight a").corner();  	
		  	$(".letter a").corner("5px");  
		  	$(".number a").corner("5px");  
		  	$(".showall a").corner("5px");  
		  	$(".elitedj").corner("5px");  
		  	$(".buttonblock").corner("3px");  
		  	$(".buttoninline").corner("5px");  
		  	$(".actionText").corner("5px"); 
			$(".markedtext").corner("5px"); 
			$(".feedbackdetails").corner("5px"); 
		  	$(".mm-selector-list").corner("5px");  
		  	$(".tab").corner("5px");
		  	$(".featuredcontrol-left").corner("5px");
		  	$(".featuredcontrol-right").corner("5px");
			if($.fn.scrollable)
			  	$('div.scroll-container').scrollable({ size:4 });
			if($.fn.tabs)
				$('div.tab-wrapper').tabs("div.panes > div");
			
		  	$('th.tblartist a').mouseover(function() {
		  	  $('.artist-az').addClass('buttoninline-over');
		  	});
		  	$('th.tblartist a').mouseout(function() {
		  	  $('.artist-az').removeClass('buttoninline-over');
		  	});

		  	$('th.tbllabel a').mouseover(function() {
			  	  $('.label-az').addClass('buttoninline-over');
			});
			$('th.tbllabel a').mouseout(function() {
			  	  $('.label-az').removeClass('buttoninline-over');
			});
	
			$('body').live('ajaxFrame',function(){
				$(".review-form").corner("bottom 5px");  
  				Cufon('h2');
				Cufon('h3');
				Cufon.replace('h2', { fontFamily: 'Typ1451-Bold' });
				Cufon.replace('h3', { fontFamily: 'Typ1451-Bold' });
			});
		  	
		  });

  		Cufon('h2');
		Cufon('h3');
		Cufon.replace('h2', { fontFamily: 'Typ1451-Bold' });
		Cufon.replace('h3', { fontFamily: 'Typ1451-Bold' });

