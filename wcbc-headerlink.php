<?php

add_action( 'wp_footer', 'wcbc_headerlink', 15 );

function wcbc_headerlink() {
?>

  <script>
  (function($) {
  $(document).ready(function() {
    $('.header-image').wrap($('<a></a>').attr('href','/'));
  });
  })( jQuery );
  </script>

<?php
}
?>
