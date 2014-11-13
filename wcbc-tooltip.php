<?php

add_action( 'wp_footer', 'wcbc_tooltip', 15 );

function wcbc_tooltip() {
?>
  <script>
(function($) {
  $(document).ready(function() {
    $(".gce-event-a").each(function(index) {
      $(this).click(function() {
        var divid = '#' + this.id + 'd';
		$(divid).toggle();
		return false;
      });
    });
  });
})(jQuery);
  </script>

<?php
}
?>
