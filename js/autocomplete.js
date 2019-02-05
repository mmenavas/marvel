/**
 * @file
 * Override Drupal's default autocomplete functionality.
 */

(function ($, Drupal) {

  Drupal.behaviors.marvelous = {
    attach: function (context, settings) {

      $(".marvel-widget__character-name", context).once('marvelous_autocomplete').on("autocompleteselect", function (event, ui) {
        var delta = $(this).data('delta');
        var parent_class = ".marvel-widget--" + delta;
        $(parent_class + " .marvel-widget__character-id", context).val(ui.item.value);
        ui.item.value = ui.item.label;
      });

      $(".marvel-widget__character-name", context).once('marvelous_character_name_change').on("input", function () {
        var delta = $(this).data('delta');
        var parent_class = ".marvel-widget--" + delta;
        $(parent_class + " .marvel-widget__character-id", context).val('');
      });

    }
  };

  // $("#edit-super-hero-name").on("autocompleteselect", function (event, ui) {
  //   $("#marvel__super-hero-id").val(ui.item.value);
  //   ui.item.value = ui.item.label;
  // });


})(jQuery, Drupal);
