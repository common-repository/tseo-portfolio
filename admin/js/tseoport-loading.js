/** Popup windows Save */
jQuery(document).ready(function($) {
    $('#tseoport-loading-overlay').hide();

    $('#submit').on('click', function() {
      $('#tseoport-loading-overlay').show();
    });

    $(document).ajaxStop(function() {
      $('#tseoport-loading-overlay').hide();
    });
});