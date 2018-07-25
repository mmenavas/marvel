<?php

namespace Drupal\marvel\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'marvel.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'marvel_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('marvel.settings');
    $form['gateway'] = [
      '#type' => 'url',
      '#title' => $this->t('Service Endpoint'),
      '#description' => $this->t('The URL for the Marvel API.'),
      '#maxlength' => 256,
      '#size' => 64,
      '#default_value' => $config->get('gateway'),
    ];
    $form['public_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Public Key'),
      '#description' => $this->t('The public key from https://developer.marvel.com'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('public_key'),
    ];
    $form['private_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Private Key'),
      '#description' => $this->t('The private key from https://developer.marvel.com'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('private_key'),
    ];
    return parent::buildForm($form, $form_state);
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
    parent::submitForm($form, $form_state);

    $this->config('marvel.settings')
      ->set('gateway', $form_state->getValue('gateway'))
      ->set('public_key', $form_state->getValue('public_key'))
      ->set('private_key', $form_state->getValue('private_key'))
      ->save();
  }

}
