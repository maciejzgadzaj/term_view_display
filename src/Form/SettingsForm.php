<?php

namespace Drupal\term_view_display\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Views;

/**
 * Configure example settings for this site.
 */
class SettingsForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'term_view_display_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'term_view_display.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('term_view_display.settings');

    $options = [];
    foreach (Views::getAllViews() as $view_id => $view) {
      $options[$view_id] = $view->label();
    }

    $form['term_view'] = array(
      '#type' => 'select',
      '#title' => $this->t('Term view'),
      '#description' => $this->t('View used to list content tagged with a taxonomy term'),
      '#options' => $options,
      '#default_value' => $config->get('term_view'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('term_view_display.settings')
      ->set('term_view', $form_state->getValue('term_view'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
