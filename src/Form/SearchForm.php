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
    $form['super_hero_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Super hero's name"),
      '#description' => $this->t("Type the first few letters of your super hero's name and name suggestions will be shown"),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
      '#autocomplete_route_name' => 'marvel.autocomplete',
    ];
    // This field is used to store the super hero id
    // so the name field can always show the name after
    // autocomplete select.
    $form['super_hero_id'] = [
      '#type' => 'hidden',
      '#default_value' => '',
      '#attributes' => [
        'id' => 'marvel__super-hero-id',
      ],
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

    $id = $form_state->getValue('super_hero_id');

    $form_state->setRedirect(
      'marvel.show_super_hero',
      [
        'id' => $id,
      ]
    );

  }

}
