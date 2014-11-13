<?php

function remove_attitude_footer_line() {
   remove_action( 'attitude_footer', 'attitude_footer_info', 30 );
}
add_action( 'init', 'remove_attitude_footer_line' );

function wcbc_footer_info() {         
   $output = '<div class="copyright">'.__( 'Copyright &copy;', 'attitude' ).' '.'[the-year] [site-link]'.'</div><!-- .copyright -->';
   echo do_shortcode( $output );
}

add_action( 'attitude_footer', 'wcbc_footer_info', 30 );
