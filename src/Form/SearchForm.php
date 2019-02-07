<?php

namespace Drupal\marvel\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SearchForm.
 */
class SearchForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'marvel_search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['character_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Character's name"),
      '#description' => $this->t("Type the first few letters of your character's name and name suggestions will be shown"),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
      '#autocomplete_route_name' => 'marvel.autocomplete',
      '#attributes' => [
        'id' => 'marvel-search__character-name',
      ],
    ];
    // This field is used to store the character id
    // so the name field can always show the name after
    // autocomplete select.
    $form['character_id'] = [
      '#type' => 'hidden',
      '#default_value' => '',
      '#attributes' => [
        'id' => 'marvel-search__character-id',
      ],
    ];
    $form['credit'] = [
      '#type' => 'markup',
      '#markup' => '<p><strong>' . $this->t('Note') . ':</strong> ' .
        $this->t("The content displayed by this app is provided by ") .
        '<a href="http://marvel.com" target="_blank" title="'. $this->t("Open Marvel's website") .
        '">http://marvel.com</a>.</p>',
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search'),
      // Prevent op from showing up in the query string.
      '#name' => '',
    ];
    $form['#attached']['library'][] = 'marvel/autocomplete';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $id = $form_state->getValue('character_id');

    $form_state->setRedirect(
      'marvel.show_character',
      [
        'id' => $id,
      ]
    );

  }

}
