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
 * Plugin implementation of the 'marvel_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "marvel_formatter",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "marvel"
 *   }
 * )
 */
class MarvelFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * MarvelSearch service.
   *
   * @var \Drupal\marvel\MarvelSearchInterface
   */
  protected $marvelSearch;

  /**
   * Constructs a FormatterBase object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\marvel\MarvelSearchInterface
   *   MarvelSearch service.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, MarvelSearchInterface $marvel_search) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->marvelSearch = $marvel_search;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('marvel.marvel_search')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $character = $this->marvelSearch->findById($item->character_id);
      $elements[] = [
        '#theme' => 'marvel_character',
        '#id' => $character['id'],
        '#name' => $character['name'],
        '#description' => $character['description'],
        '#image' => $character['image'],
      ];
    }

    return $elements;
  }

}
