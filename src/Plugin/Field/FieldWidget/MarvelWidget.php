<?php

/**
 * @file
 * Contains \Drupal\marvel\Plugin\Field\FieldWidget\MarvelWidget.
 */

namespace Drupal\marvel\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'Marvel' widget.
 *
 * @FieldWidget(
 *   id = "marvel_widget",
 *   label = @Translation("Marvel"),
 *   field_types = {
 *     "marvel"
 *   }
 * )
 */
class MarvelWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $item = $items[$delta];

    // TODO: Find out why values are not being saved when using a fieldset to contain the element fields.

    $element['marvel'] = [
      '#type' => 'details',
      '#title' => 'Character',
      '#open' => TRUE,
//      '#tree' => FALSE,
      '#attributes' => [
        'class' => ["marvel-widget", "marvel-widget--" . $delta],
      ],
    ];

    $element['marvel']['character_name'] = [
//    $element['character_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Character name"),
      '#description' => $this->t("Type the first few letters of your character's name and suggestions will be shown"),
      '#weight' => 0,
      '#autocomplete_route_name' => 'marvel.autocomplete',
      '#default_value' => isset($item->character_name) ? $item->character_name : '',
      '#attributes' => [
        'class' => ["marvel-widget__character-name"],
        'data-delta' => $delta,
      ],
    ];

    $element['marvel']['character_id'] = [
//    $element['character_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Character Id"),
      '#weight' => 1,
      '#default_value' => isset($item->character_id) ? $item->character_id : '',
      '#attributes' => [
        'class' => ["marvel-widget__character-id"],
        'readonly' => TRUE,
      ],
    ];

    // TODO: Move up to form level.
    $element['#attached']['library'][] = 'marvel/autocomplete';

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    if (!empty($values['marvel'])) {
      foreach ($values['marvel'] as $key => $value) {
        $values[$key] = $value;
      }
      unset($values['marvel']);
    }
    return $values;
  }
}
