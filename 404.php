<?php get_header();
	/** 
	 * attitude_before_main_container hook
	 */
	do_action( 'attitude_before_main_container' );
   /**
    * attitude_before_primary
    */
   do_action( 'attitude_before_primary' );
?>
<div class="container">

<div id="primary" class="no-margin-left">
<div id="content">
<div class="notfound">

<header class="entry-header">
<h2 class="entry-title">Klaxon!</h2>
</header>

<p>It's possible an errant swan ate the page you were looking for.  Perhaps a wayward packet got wedged sideways in the gut of the <a href="http://en.wikipedia.org/wiki/Series_of_tubes" target="_blank">internet tubes</a>, obstructing your page's racing line.  More likely yet, a novice router, thinking it heard a commotion elsewhere, raised the alarm for no real cause at all.</p>

<p>Luckily, there is still a chance you can find what you're looking for.  Use the links above to browse Wolfson College Boat Club information and news to your heart's content.  And if this error was caused by a problem with our page, please <a href="mailto:webmaster@wolfsonrowing.org" target="_blank">let us know</a> so we can fix it.</p>

<p>Or, if you are of the venerable <a href="http://en.wikipedia.org/wiki/Honey_badger" target="_blank">honey badger</a> people, carry on.  We can only honour your noble indifference.</p>

</div><!-- .notfound --> 
</div><!-- #content -->
</div><!-- #primary -->

<?php
   /**
    * attitude_after_primary
    */
   do_action( 'attitude_after_primary' );
?>

<div id="secondary">
	<?php get_sidebar( 'right' ); ?>
</div><!-- #secondary -->

</div>
<?php
	/** 
	 * attitude_after_main_container hook
	 */
	do_action( 'attitude_after_main_container' );

get_footer(); ?>

