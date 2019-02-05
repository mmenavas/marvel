<?php

/**
 * @file
 * Contains \Drupal\marvel\Plugin\Field\FieldFormatter\MarvelFormatter.
 */

namespace Drupal\marvel\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'marvel_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "marvel_formatter",
 *   label = @Translation("Marvel formatter"),
 *   field_types = {
 *     "marvel"
 *   }
 * )
 */
class MarvelFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $elements[$delta] = array(
        '#theme' => 'marvel_super_hero',
        '#id' => $item->character_name,
        '#name' => $item->character_id,
      );
    }

    return $elements;
  }

}
