<?php
declare(strict_types = 1);

namespace Drupal\monitoring_server\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the performance type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "performance_type",
 *   label = @Translation("performance type"),
 *   label_collection = @Translation("performance types"),
 *   label_singular = @Translation("performance type"),
 *   label_plural = @Translation("performances types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count performances type",
 *     plural = "@count performances types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\monitoring_server\Form\PerformanceTypeForm",
 *       "edit" = "Drupal\monitoring_server\Form\PerformanceTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\monitoring_server\PerformanceTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer performance types",
 *   bundle_of = "performance",
 *   config_prefix = "performance_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/performance_types/add",
 *     "edit-form" = "/admin/structure/performance_types/manage/{performance_type}",
 *     "delete-form" = "/admin/structure/performance_types/manage/{performance_type}/delete",
 *     "collection" = "/admin/structure/performance_types",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *     "description",
 *   },
 * )
 */
final class PerformanceType extends ConfigEntityBundleBase {

  /**
   * The machine name of this performance type.
   */
  protected string $id;

  /**
   * The human-readable name of the performance type.
   */
  protected string $label;

  /**
   * Petite description
   *
   * @var string
   */
  protected $description;

}
