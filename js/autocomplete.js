/**
 * @file
 * Override Drupal's default autocomplete functionality.
 */

(function ($, once, Drupal) {

  Drupal.behaviors.marvel = {
    attach: function (context, settings) {

      $(once("marvel_search_autocomplete", "#marvel-search__character-name", context)).each(function () {
        $(this).on("autocompleteselect", function (event, ui) {
          $("#marvel-search__character-id").val(ui.item.value);
          ui.item.value = ui.item.label;
        })
      });

      $(once("marvel_formatter_autocomplete", ".marvel-widget__character-name", context)).each(function () {
        $(this).on("autocompleteselect", function (event, ui) {
          var delta = $(this).data('delta');
          var parent_class = ".marvel-widget--" + delta;
          $(parent_class + " .marvel-widget__character-id", context).val(ui.item.value);
          ui.item.value = ui.item.label;
        })
      });

      $(once("marvel_character_name_change", ".marvel-widget__character-name", context)).each(function () {
        $(this).on("input", function () {
          var delta = $(this).data('delta');
          var parent_class = ".marvel-widget--" + delta;
          $(parent_class + " .marvel-widget__character-id", context).val('');
        })
      });

    }
  };

})(jQuery, once, Drupal);
