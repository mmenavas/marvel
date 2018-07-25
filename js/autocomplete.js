/**
 * @file
 * Override Drupal's default autocomplete functionality.
 */

(function ($, Drupal) {

  $("#edit-super-hero-name").on("autocompleteselect", function (event, ui) {
    $("#marvel__super-hero-id").val(ui.item.value);
    ui.item.value = ui.item.label;

  });

})(jQuery, Drupal);
