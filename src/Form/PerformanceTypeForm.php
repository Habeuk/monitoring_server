<?php
declare(strict_types = 1);

namespace Drupal\monitoring_server\Form;

use Drupal\Core\Entity\BundleEntityFormBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\monitoring_server\Entity\PerformanceType;

/**
 * Form handler for performance type forms.
 */
final class PerformanceTypeForm extends BundleEntityFormBase {

  /**
   *
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {
    $form = parent::form($form, $form_state);

    if ($this->operation === 'edit') {
      $form['#title'] = $this->t('Edit %label performance type', [
        '%label' => $this->entity->label()
      ]);
    }

    $form['label'] = [
      '#title' => $this->t('Label'),
      '#type' => 'textfield',
      '#default_value' => $this->entity->label(),
      '#description' => $this->t('The human-readable name of this performance type.'),
      '#required' => TRUE
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
      '#machine_name' => [
        'exists' => [
          PerformanceType::class,
          'load'
        ],
        'source' => [
          'label'
        ]
      ],
      '#description' => $this->t('A unique machine-readable name for this performance type. It must only contain lowercase letters, numbers, and underscores.')
    ];

    $form['description'] = [
      '#title' => $this->t('Description'),
      '#type' => 'textarea',
      '#default_value' => $this->entity->get('description')
    ];

    return $this->protectBundleIdElement($form);
  }

  /**
   *
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state): array {
    $actions = parent::actions($form, $form_state);
    $actions['submit']['#value'] = $this->t('Save performance type');
    $actions['delete']['#value'] = $this->t('Delete performance type');
    return $actions;
  }

  /**
   *
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $result = parent::save($form, $form_state);

    $message_args = [
      '%label' => $this->entity->label()
    ];
    $this->messenger()->addStatus(match ($result) {
        SAVED_NEW => $this->t('The performance type %label has been added.', $message_args),
        SAVED_UPDATED => $this->t('The performance type %label has been updated.', $message_args)
    });
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));

    return $result;
  }

}
