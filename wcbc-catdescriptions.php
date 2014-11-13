<?php

// Remove filters that prevent full HTML in category descriptions
$filters = array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description');
foreach ( $filters as $filter ) {
    remove_filter($filter, 'wp_filter_kses');
}


function wcbc_category_description() {

if( is_category() ):
?>
<header class="entry-header">
<h2 class="wcbc-category-title entry-title"><?php single_cat_title(); ?></h2>
</header>

<?php if( !is_paged() && category_description() ): ?>

<div class="wcbc-category-description">
<?php echo category_description(); ?>
<p>Below, you'll find all of our related website posts.  Be sure to check back; we're adding more all the time!</p>
</div>

<?php endif; endif;
}

add_action( 'attitude_before_loop_content', 'wcbc_category_description', 15 );
?>
