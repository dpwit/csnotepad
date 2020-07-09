<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
<div id="topBar" >
			<!--<div id="logoBox">
				<a href="/" title="Live Web Chat" ><img src="images/logo.png" alt="Live Web Chat by CSnotepad" title="Live Web Chat by CSnotepad" /></a>
			</div>-->
			<div id="topBarRightBox">
			
			<div id="menubox">
			<div class="phonenumbernewleft">
		<!--<span style="padding-right:25px; top:0px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 01273 741113</span>-->
		<span style="padding-right:25px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 01273 741113</span>
		<!--<h1>Personalised Business Telephone Answering Services</h1>-->
	</div>
			<ul id="menu">
			<li class="home selected">
			<a href="http://www.livewebchat.co.uk/home.php" title="Home">Home</a>
			</li>
			<li class="Our Services unselected">
			<a href="http://www.livewebchat.co.uk/our-services.php" title="Our Services">Our Services</a>
			</li>
			<li class="FAQ unselected">
			<a href="http://www.livewebchat.co.uk/faq.php" title="FAQ">FAQ</a>
			</li>
			<li class="Contact unselected">
			<a href="http://www.livewebchat.co.uk/contact.php" title="Contact">Contact</a>
			</li>
			</ul>
				
			<div class="phonenumbernew">
		<span style="padding-right:25px; top:0px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 01273 741113</span>
		<!--<span style="padding-right:25px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 0333 200 0504</span>-->
		<!--<h1>Personalised Business Telephone Answering Services</h1>-->
	</div>		
	
			<div class="clear"></div>

		</div>
		
		</div>
		<div class="clear"></div>
		</div>
		<div id="contentTop">
			
		</div>
<div class="newheadercontact">


				<!--<a href="/" title="Live Web Chat" ><img src="images/logo.png" alt="Live Web Chat by CSnotepad" title="Live Web Chat by CSnotepad" /></a>-->
			

	<div class="phonenumber">
	<a href="/" title="Live Web Chat" ><img src="/images/logo_clear.png" width="236" height="120" alt="Live Web Chat by CSnotepad" title="Live Web Chat by CSnotepad" /></a>
		<!--<span><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 01273 741400</span>-->
		<ul class="homepoints">
			<span>
	
   <ul style="list-style-type: none; display: inline-block;">
      <li><!--<a href="/our-services/order-taking" title="E-Commerce order processing">-->Pro-active chat     </a></li>
      <li><!--<a href="/our-services/order-taking" title="Support ticket logging">-->Mobile friendly     </a></li>
   </ul>

   <ul style="list-style-type: none; display: inline-block; margin: 0 20px;">
      <li>Appointment booking     </li>
      <li><!--<a href="/our-services/order-taking" title="Order fulfilment">-->Easy to Install     </a></li>
   </ul>
   
   <ul style="list-style-type: none; display: inline-block; margin: 0 20px;">
      <li>Checkout assistance     </li>
      <li><!--<a href="/our-services/telephone-answering-brighton" title="Message taking">-->UK office based     </li>
   </ul>
</span>
		</ul>
		
		<!--<h1>Personalised Business Telephone Answering Services</h1>-->
	</div>
	
	<div class="semiFootertop">
				<a href="/support-contact.php" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="bt-support" style="margin-right: 20px">Arrange a call back</button>
					</a>
				<!--<a href="/howitworks.php" <!--rel="fancybox-support" class="fancybox.iframe"-->
						<!--<button type="submit" name="submit" value="submit" class="bt-support" style="margin-right: 20px">How it works</button>
					</a>-->
				<a href="/signup-contact.php" rel="fancybox-signup" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="bt-support">Download prices</button>
					</a>
				</div>
	
	<!--<div class="subheader">
	<!--<h2>Whatever the size of your company we're here to answer your telephone calls when you can't, whether you receive hundreds of calls a month or not, you can expect a bespoke service tailored precisely to your businesses needs.</h2>
	<span>01273 741 400</span>-->
	
	
		
	<!--</div>-->
	<br>
<div id="contentMiddle">
<div id="breadcrumb"><h3><b>You are here: </b>
<a class='breadcrumb' title="Home" href="http://www.livewebchat.co.uk/home.php">Home</a>  &gt; <a class="breadcrumb" title="Blog" href="http://www.livewebchat.co.uk/blog">Blog</a></h3></div>
<div id="breadcrumb-search-fields" style="display:none;">
	<input type='hidden' name='from' value='/contact'/>
</div>
<br>
<div id="contentMiddleServices">
<h1><font color ="423062">Live</font><font color ="AB2C26">Web</font><font color ="423062">Chat</font><font color ="423062"> - Blog</font></h1>
</div>
	<div id="header">
		<div id="masthead">
			<div id="branding" role="banner">
				<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
				<<?php echo $heading_tag; ?> id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				</<?php echo $heading_tag; ?>>
				<div id="site-description"><?php bloginfo( 'description' ); ?></div>

				<?php
					// Check if this is a post or page, if it has a thumbnail, and if it's a big one
					if ( is_singular() &&
							has_post_thumbnail( $post->ID ) &&
							( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) ) &&
							$image[1] >= HEADER_IMAGE_WIDTH ) :
						// Houston, we have a new header image!
						echo get_the_post_thumbnail( $post->ID, 'post-thumbnail' );
					else : ?>
						<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
					<?php endif; ?>
			</div><!-- #branding -->

			<div id="access" role="navigation">
			  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a></div>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
			</div><!-- #access -->
		</div><!-- #masthead -->
	</div><!-- #header -->
	

	<div id="main">
	