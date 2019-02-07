<?php

/**
 * @file
 * Contains \Drupal\marvel\Plugin\Field\FieldFormatter\MarvelFormatter.
 */

namespace Drupal\marvel\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldDefinitionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\marvel\MarvelSearchInterface;

/**
 * Plugin implementation of the 'memory_game_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "memory_game_formatter",
 *   label = @Translation("Memory Game"),
 *   field_types = {
 *     "marvel"
 *   }
 * )
 */
class MemoryGameFormatter extends MarvelFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $characters = [];

    foreach ($items as $delta => $item) {
      $characters[] = $this->marvelSearch->findById($item->character_id);
    }

    $elements = [
      '#markup' => "<div id='marvel-memory-game'>"
    ];
    $elements['#attached']['drupalSettings']['marvel'] = $characters;
    $elements['#attached']['library'][] = 'marvel/marvel';

    return $elements;
  }

}
