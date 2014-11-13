<?php

/**
 * Display Home Slogan.
 *
 * Function that enable/disable the home slogan1 and home slogan2.
 */

function wcbc_homebar_init() {

	register_sidebar( array(
		'name' => 'Homepage Info Bar',
		'id'   => 'homebar',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title' => '<div style="display: none;">',
		'after_title' => '</div>'
	));
}

add_action( 'widgets_init', 'wcbc_homebar_init' );


if ( ! function_exists( 'attitude_featured_post_slider' ) ) :
/**
 * display featured post slider
 *
 * @uses set_transient and delete_transient
 */
function attitude_featured_post_slider() {	
	global $post;
		
	global $attitude_theme_options_settings;
   $options = $attitude_theme_options_settings;
	
	$attitude_featured_post_slider = '';
	if( ( !$attitude_featured_post_slider = get_transient( 'attitude_featured_post_slider' ) ) && !empty( $options[ 'featured_post_slider' ] ) ) {

		if( 'wide-layout' == $options[ 'site_layout' ] ) {
			$slider_size = 'slider-wide';
		}
		else {
			$slider_size = 'slider-narrow';
		}
		
		$attitude_featured_post_slider .= '
		<section class="featured-slider"><div class="slider-cycle">';
			$get_featured_posts = new WP_Query( array(
				'posts_per_page' 			=> $options[ 'slider_quantity' ],
				'post_type'					=> array( 'post', 'page' ),
				'post__in'		 			=> $options[ 'featured_post_slider' ],
				'orderby' 		 			=> 'post__in',
				'ignore_sticky_posts' 	=> 1 						// ignore sticky posts
			));
			$i=0; while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
				$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
				$excerpt = get_the_excerpt();
				if ( 1 == $i ) { $classes = "slides displayblock"; } else { $classes = "slides displaynone"; }
				$attitude_featured_post_slider .= '
				<div class="'.$classes.'">';
						if( has_post_thumbnail() ) {
	
							$attitude_featured_post_slider .= '<figure><a href="' . get_permalink() . '" title="'.the_title('','',false).'">';
	
							$attitude_featured_post_slider .= get_the_post_thumbnail( $post->ID, $slider_size, array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'</a></figure>';
						}
						if( $title_attribute != '' || $excerpt !='' ) {
						$attitude_featured_post_slider .= '
							<article class="featured-text">';
							if( $title_attribute !='' ) {
									$attitude_featured_post_slider .= '<div class="featured-title"><a href="' . get_permalink() . '" title="'.the_title('','',false).'">'. get_the_title() . '</a></div><!-- .featured-title -->';
							}
							if( $excerpt !='' ) {								
								$attitude_featured_post_slider .= '<div class="featured-content">'.$excerpt.'</div><!-- .featured-content -->';
							}
						$attitude_featured_post_slider .= '
							</article><!-- .featured-text -->';
						}
				$attitude_featured_post_slider .= '
				</div><!-- .slides -->';
			endwhile; wp_reset_query();
		$attitude_featured_post_slider .= '</div>				
		<nav id="controllers" class="clearfix">
		</nav><!-- #controllers --></section><!-- .featured-slider -->';
			
	set_transient( 'attitude_featured_post_slider', $attitude_featured_post_slider, 86940 );
	}
	echo $attitude_featured_post_slider;
?>	
	<section class="wcbc-homebar clearfix">
	<?php dynamic_sidebar('homebar'); ?>
	</section>
<?php
}
endif;



?>
