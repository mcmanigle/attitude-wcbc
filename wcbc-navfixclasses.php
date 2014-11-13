<?php

function wcbc_special_nav_classes( $classes = array(), $menu_item = false )
{
	global $wp_query;
	
	$post_name = get_post(get_post_meta( $menu_item->post_name, '_menu_item_object_id', true))->post_name;
	
	if ( $post_name == 'news' && is_category('news') )
		$classes[] = 'current-menu-item';

	else if ( $post_name == 'news' && is_singular() && in_category('news') )
		$classes[] = 'current-menu-ancestor';
	
	if ( $post_name == 'racing' && is_category('racing') )
		$classes[] = 'current-menu-item';

	else if ( $post_name == 'racing' && is_singular() && in_category('racing') )
		$classes[] = 'current-menu-ancestor';
	
	if ( $post_name == 'about-the-club' && is_category('reflections') )
		$classes[] = 'current-menu-ancestor';

	else if ( $post_name == 'about-the-club' && is_singular() && in_category('reflections') )
		$classes[] = 'current-menu-ancestor';
	
	if ( $post_name == 'about-the-club' && is_category('committee') )
		$classes[] = 'current-menu-ancestor';

	else if ( $post_name == 'about-the-club' && is_singular() && in_category('committee') )
		$classes[] = 'current-menu-ancestor';
		
	if ( $post_name == 'committee' && is_category('committee') )
		$classes[] = 'current-menu-item';

	else if ( $post_name == 'committee' && is_singular() && in_category('committee') )
		$classes[] = 'current-menu-ancestor';
	
    return $classes;
}
add_filter( 'nav_menu_css_class', 'wcbc_special_nav_classes', 10, 2 );

?>