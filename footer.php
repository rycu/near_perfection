<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Near_Perfection
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

		<div id="mediaBar">

			<!-- <div id="twitterBox" class="triBucket">
				<h3 id="twitterTitle" class="footerTitle">twitter</h3>
				<a class="twitter-timeline" href="https://twitter.com/cuttermay" data-widget-id="XXX">Tweets by @cuttermay</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div> -->


			<div id="searchBox" class="triBucket">
				<form role="search" method="get" class="search-form" action="/">
					<label>
						<h3>Search <? bloginfo( 'name' ); ?></h3>
						<span class="screen-reader-text">Search for:</span>
						<input type="search" placeholder="Search …" name="s">
					</label>
				</form>
			</div>

			<div id="contactBox" class="triBucket">
				<h3>Contact Us</h3>
				<?php get_template_part( 'quickContact' ); ?>
			</div>

			<!-- <div id="recentBox" class="triBucket">
				<h3 id="recentTitle" class="footerTitle">Recent Installations</h3>
				<ul>
				
				<?php
				
				$args = array( 'posts_per_page' => '6', 'category' => get_cat_ID('Portfolio') );
				$myposts = get_posts( $args );
				foreach ( $myposts as $post ) : setup_postdata( $post ); 	
				?>
					<li>
							<p><?php echo get_the_date(); ?></p>
							<h6><?php echo get_the_title(); ?></h6>
							<a href="<?php the_permalink(); ?>">View</a> 					
						
					</li>	
				<?php endforeach; 
				wp_reset_postdata();?>
				
				</ul>
				</nav>
			</div> -->

		</div>

		<div id="bottomLine">
			
			

			<div id="socnet-footer" class="triBucket">
				<ul>
					<li><a class="fa-facebook" href="https://www.facebook.com/XXX" aria-label="XXX's facebook page" target="_blank"></a></li>
					<li><a class="fa-twitter" href="https://twitter.com/XXX" aria-label="XXX's twitter page" target="_blank"></a></li>
				</ul>
			</div>

			<nav id="footer-navigation" class="triBucket">
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu' ) ); ?>
			</nav>

			<div id="site-info" class="triBucket">
				<ul>
							<li>&copy; <?= date('Y') ?> <? bloginfo( 'name' ); ?></li>
							<li><a href="https://cuttermay.com">A Cutter May Site</a></li>
				</ul>
			</div><!-- .site-info -->
			
		</div>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
