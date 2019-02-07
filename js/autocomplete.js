/**
 * @file
 * Override Drupal's default autocomplete functionality.
 */

(function ($, Drupal) {

  Drupal.behaviors.marvel = {
    attach: function (context, settings) {

      $("#marvel-search__character-name").once('marvel_search_autocomplete').on("autocompleteselect", function (event, ui) {
        $("#marvel-search__character-id").val(ui.item.value);
        ui.item.value = ui.item.label;
      });

      $(".marvel-widget__character-name", context).once('marvel_formatter_autocomplete').on("autocompleteselect", function (event, ui) {
        var delta = $(this).data('delta');
        var parent_class = ".marvel-widget--" + delta;
        $(parent_class + " .marvel-widget__character-id", context).val(ui.item.value);
        ui.item.value = ui.item.label;
      });

      $(".marvel-widget__character-name", context).once('marvel_character_name_change').on("input", function () {
        var delta = $(this).data('delta');
        var parent_class = ".marvel-widget--" + delta;
        $(parent_class + " .marvel-widget__character-id", context).val('');
      });

    }
  };

})(jQuery, Drupal);
