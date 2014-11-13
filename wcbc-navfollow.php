<?php

add_action( 'wp_footer', 'wcbc_navfollow', 15 );

function wcbc_navfollow() {
?>
  <script>
(function($) {
$(window).load(function() {
	
    var $sidebar   = $(".widget_advanced_menu"); 

    if( $sidebar.length == 0 ) return;

    var $reference = $sidebar.prev();
    var offset     = $reference.offset().top + $reference.outerHeight(true);
    var fixedTopPx = 40;

    $(window).scroll(function() {
    	var scrollTop = $(this).scrollTop();
        if ( scrollTop > offset - fixedTopPx && $(window).width() >= 1078 ) {
		$sidebar.css({ position: 'fixed', top: fixedTopPx });
        } else {
		$sidebar.css({ position: '', top: ''});
        }
    });
}); })(jQuery);

</script>
<?php } ?>
