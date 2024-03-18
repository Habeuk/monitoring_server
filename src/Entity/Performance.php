<?php
declare(strict_types = 1);

namespace Drupal\monitoring_server\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\monitoring_server\PerformanceInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the performance entity class.
 *
 * @ContentEntityType(
 *   id = "performance",
 *   label = @Translation("performance"),
 *   label_collection = @Translation("performances"),
 *   label_singular = @Translation("performance"),
 *   label_plural = @Translation("performances"),
 *   label_count = @PluralTranslation(
 *     singular = "@count performances",
 *     plural = "@count performances",
 *   ),
 *   bundle_label = @Translation("performance type"),
 *   handlers = {
 *     "list_builder" = "Drupal\monitoring_server\PerformanceListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\monitoring_server\Form\PerformanceForm",
 *       "edit" = "Drupal\monitoring_server\Form\PerformanceForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "performance",
 *   admin_permission = "administer performance types",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "bundle",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/performance",
 *     "add-form" = "/performance/add/{performance_type}",
 *     "add-page" = "/performance/add",
 *     "canonical" = "/performance/{performance}",
 *     "edit-form" = "/performance/{performance}/edit",
 *     "delete-form" = "/performance/{performance}/delete",
 *     "delete-multiple-form" = "/admin/content/performance/delete-multiple",
 *   },
 *   bundle_entity_type = "performance_type",
 *   field_ui_base_route = "entity.performance_type.edit_form",
 * )
 */
final class Performance extends ContentEntityBase implements PerformanceInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   *
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage): void {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  /**
   *
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['label'] = BaseFieldDefinition::create('string')->setLabel(t('Label'))->setRequired(TRUE)->setSetting('max_length', 255)->setDisplayOptions('form', [
      'type' => 'string_textfield',
      'weight' => -5
    ])->setDisplayConfigurable('form', TRUE)->setDisplayOptions('view', [
      'label' => 'hidden',
      'type' => 'string',
      'weight' => -5
    ])->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')->setLabel(t('Status'))->setDefaultValue(TRUE)->setSetting('on_label', 'Enabled')->setDisplayOptions('form', [
      'type' => 'boolean_checkbox',
      'settings' => [
        'display_label' => FALSE
      ],
      'weight' => 0
    ])->setDisplayConfigurable('form', TRUE)->setDisplayOptions('view', [
      'type' => 'boolean',
      'label' => 'above',
      'weight' => 0,
      'settings' => [
        'format' => 'enabled-disabled'
      ]
    ])->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('text_long')->setLabel(t('Description'))->setDisplayOptions('form', [
      'type' => 'text_textarea',
      'weight' => 10
    ])->setDisplayConfigurable('form', TRUE)->setDisplayOptions('view', [
      'type' => 'text_default',
      'label' => 'above',
      'weight' => 10
    ])->setDisplayConfigurable('view', TRUE);

    $fields['data_json'] = BaseFieldDefinition::create('text_long')->setLabel(t('Datas json'))->setDisplayOptions('form', [
      'type' => 'text_textarea',
      'weight' => 10
    ])->setDisplayConfigurable('form', TRUE)->setDisplayOptions('view', [
      'type' => 'text_default',
      'label' => 'above',
      'weight' => 10
    ])->setDisplayConfigurable('view', TRUE);

    $fields['nombre_execution'] = BaseFieldDefinition::create('integer')->setLabel(" nombre execution ")->setSettings([
      'min' => 0
    ])->setDisplayOptions('view', [
      'label' => 'above',
      'type' => 'string',
      'weight' => 10
    ])->setDisplayOptions('form', [
      'type' => 'number'
    ])->setDisplayConfigurable('form', TRUE)->setDisplayConfigurable('view', TRUE)->setRequired(TRUE);

    $fields['duree_execution'] = BaseFieldDefinition::create('float')->setLabel(" Durée d'execution (ms) ")->setDisplayOptions('view', [
      'label' => 'above',
      'type' => 'string',
      'weight' => 10
    ])->setDisplayOptions('form', [
      'type' => 'number'
    ])->setDisplayConfigurable('form', TRUE)->setDisplayConfigurable('view', TRUE)->setRequired(TRUE);

    $fields['ram'] = BaseFieldDefinition::create('float')->setLabel(" Ram consommé (MB) ")->setDisplayOptions('view', [
      'label' => 'above',
      'type' => 'string',
      'weight' => 10
    ])->setDisplayOptions('form', [
      'type' => 'number'
    ])->setDisplayConfigurable('form', TRUE)->setDisplayConfigurable('view', TRUE)->setRequired(TRUE);

    $fields['route_name'] = BaseFieldDefinition::create('string')->setLabel(t('Route name'))->setRequired(TRUE)->setSetting('max_length', 255)->setDisplayOptions('form', [
      'type' => 'string_textfield',
      'weight' => 10
    ])->setDisplayConfigurable('form', TRUE)->setDisplayOptions('view', [
      'label' => 'hidden',
      'type' => 'string',
      'weight' => 10
    ])->setDisplayConfigurable('view', TRUE);

    $fields['uri'] = BaseFieldDefinition::create('text_long')->setLabel(t('Uri'))->setDisplayOptions('form', [
      'type' => 'text_textarea',
      'weight' => 10
    ])->setDisplayConfigurable('form', TRUE)->setDisplayOptions('view', [
      'type' => 'text_default',
      'label' => 'above',
      'weight' => 10
    ])->setDisplayConfigurable('view', TRUE);

    $fields['host'] = BaseFieldDefinition::create('entity_reference')->setLabel(t('Host'))->setSetting('target_type', 'host')->setDisplayOptions('form', [
      'type' => 'entity_reference_autocomplete',
      'settings' => [
        'match_operator' => 'CONTAINS',
        'size' => 60,
        'placeholder' => ''
      ],
      'weight' => 10
    ])->setDisplayConfigurable('form', TRUE)->setDisplayOptions('view', [
      'label' => 'above',
      'weight' => 15
    ])->setDisplayConfigurable('view', TRUE)->setRequired(TRUE);
    $fields['remote_uid'] = BaseFieldDefinition::create('entity_reference')->setLabel(t('Remote uid'))->setSetting('target_type', 'remote_user')->setDisplayOptions('form', [
      'type' => 'entity_reference_autocomplete',
      'settings' => [
        'match_operator' => 'CONTAINS',
        'size' => 60,
        'placeholder' => ''
      ],
      'weight' => 10
    ])->setDisplayConfigurable('form', TRUE)->setDisplayOptions('view', [
      'label' => 'above',
      'weight' => 15
    ])->setDisplayConfigurable('view', TRUE)->setRequired(TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')->setLabel(t('Author'))->setSetting('target_type', 'user')->setDefaultValueCallback(self::class . '::getDefaultEntityOwner')->setDisplayOptions('form', [
      'type' => 'entity_reference_autocomplete',
      'settings' => [
        'match_operator' => 'CONTAINS',
        'size' => 60,
        'placeholder' => ''
      ],
      'weight' => 15
    ])->setDisplayConfigurable('form', TRUE)->setDisplayOptions('view', [
      'label' => 'above',
      'type' => 'author',
      'weight' => 15
    ])->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')->setLabel(t('Authored on'))->setDescription(t('The time that the performance was created.'))->setDisplayOptions('view', [
      'label' => 'above',
      'type' => 'timestamp',
      'weight' => 20
    ])->setDisplayConfigurable('form', TRUE)->setDisplayOptions('form', [
      'type' => 'datetime_timestamp',
      'weight' => 20
    ])->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')->setLabel(t('Changed'))->setDescription(t('The time that the performance was last edited.'));

    return $fields;
  }

}
