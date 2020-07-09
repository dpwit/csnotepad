</div>
<div id="mainSection2ColRight">
	<div id="sideBarBoxTop"></div>
	<div id="sideBarBoxMiddle">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : // Begin Widgets for Sidebar 1; displays widgets or default contents below ?>
			<?php global $wpdb, $r; $r = new WP_Query("showposts=5"); if ($r->have_posts()) : // Custom recent posts for Simplr ?>
				<h2><?php _e('Recent Posts', 'simplr') ?></h2>
				<img src="images/separatorSmall.png" alt="separator">
					<br />
					<br />
						<?php while ($r->have_posts()) : $r->the_post(); ?>
							<p>
								<span class="entry-title"><a href="<?php the_permalink() ?>" title="Continue reading <?php get_the_title(); the_title(); ?>" rel="bookmark"><?php get_the_title(); the_title(); ?></a></span>
								<span class="entry-date"><?php the_time('d/m/Y'); ?></span>
							</p>
						<?php endwhile; ?>
					
		<?php endif; ?>

		<?php global $wpdb, $comments, $comment; // Custom recent comments for Simplr
		$comments = $wpdb->get_results("SELECT comment_author, comment_author_url, comment_ID, comment_post_ID, SUBSTRING(comment_content,1,65) AS comment_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 5"); ?>
		<?php endif; // End Widgets ?>
		
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : // Begin Widgets for Sidebar 2; displays widgets or default contents below ?>
			<h2><label for="s"><?php _e('Search', 'simplr') ?></label></h2>
			<img src="images/separatorSmall.png" alt="separator"><br />
			<br />

			<form id="searchform" method="get" action="<?php bloginfo('home') ?>">
				<div>
					<input id="s" name="s" type="text" value="<?php the_search_query() ?>" size="15" />
					<input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find', 'simplr') ?>" />
				</div>
			</form>
			<br />

			<h2><?php _e('Archives', 'simplr') ?></h2>
			
			<img src="images/separatorSmall.png" alt="separator">
			<br /><br />

			<?php get_calendar(); ?><br />

				<ul style="height: 14em; overflow: auto">
					<?php wp_get_archives('type=monthly&show_post_count=1') ?>
				</ul>
		<?php endif; // End Widgets ?>
		<div class="clear"></div>
	</div>
	<div id="sideBarBoxBottom"></div>	

</div>