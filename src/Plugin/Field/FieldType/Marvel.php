<?php

/**
 * @file
 * Contains \Drupal\marvel\Plugin\Field\FieldType\Marvel.
 */

namespace Drupal\marvel\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;


/**
 * Plugin implementation of the 'marvel' field type.
 *
 * @FieldType(
 *   id = "marvel",
 *   label = @Translation("Marvel"),
 *   description = @Translation("A compound fields to store marvel metadata."),
 *   default_widget = "marvel_widget",
 *   default_formatter = "marvel_formatter"
 * )
 */
class Marvel extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'character_id' => array(
          'type' => 'int',
          'size' => 'medium'
        ),
        'character_name' => array(
          'type' => 'varchar',
          'length' => 255,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // This is called very early by the user entity roles field. Prevent
    // early t() calls by using the TranslatableMarkup.
    $properties['character_id'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Character Id'))
      ->setRequired(TRUE);

    $properties['character_name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Character Name'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $character_name = $this->get('character_name')->getValue();
    $character_id = $this->get('character_id')->getValue();
    return !$character_name || !$character_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setValue($values, $notify = TRUE) {
    if (!empty($values['marvel'])) {
      foreach ($values['marvel'] as $key => $value) {
        $values[$key] = $value;
      }
      unset($values['marvel']);
    }
    parent::setValue($values, $notify);
  }

}
