<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
<base href="http://www.csnotepad.co.uk/" />
	<title><?php if ( is_404() ) : ?><?php _e('Page not found', 'simplr') ?> &lt; <?php bloginfo('name') ?><?php elseif ( is_home() ) : ?><?php bloginfo('name') ?> &gt; <?php bloginfo('description') ?><?php elseif ( is_category() ) : ?><?php echo single_cat_title(); ?> &lt; <?php bloginfo('name') ?><?php elseif ( is_date() ) : ?><?php _e('Blog archives', 'simplr') ?> &lt; <?php bloginfo('name') ?><?php elseif ( is_search() ) : ?><?php _e('Search results', 'simplr') ?> &lt; <?php bloginfo('name') ?><?php else : ?><?php the_title() ?> &lt; <?php bloginfo('name') ?><?php endif ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<link rel="stylesheet" type="text/css" href="/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="/css/cs_notepad.css" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php bloginfo('name') ?> RSS feed" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php bloginfo('name') ?> comments RSS feed" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />

<?php wp_head() // Do not remove; helps plugins work ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2882596-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>

	<div id="wrapper">
		<div id="topBar" >
			<div id="logoBox">
				<a href="/"><img src="images/logo.png" alt="CSNotepad" /></a>
			</div>
			<div id="topBarRightBox">
				<div id="menuBox">
										<ul id="menu">
				<li class="home selected"><a href="" title="Home">Home</a></li>

				<li class="about unselected"><a href="/about" title="About">About</a></li>
				<li class="shop unselected"><a href="/our-services" title="Our Services">Our Services</a></li>
				<li class="offers unselected"><a href="/offers" title="Offers">Offers</a></li>
				<li class="blog unselected"><a href="/blog" title="Blog">Blog</a></li>
				<li class="faq unselected"><a href="/faq" title="FAQ">FAQ</a></li>
				<li class="contact unselected"><a href="contact" title="Contact">Contact</a></li>

			</ul>
							<ul id="shoppingInfo"><li><a href='/shop/view-cart.html'>Cart</a></li></ul>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
		<div id="contentTop">

			
		</div>

					<div id="contentMiddle">
 <div id="mainSection">
				
				<div id="mainSection2ColLeft">
