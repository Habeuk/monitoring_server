<?php declare(strict_types = 1);

namespace Drupal\monitoring_server;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of performance type entities.
 *
 * @see \Drupal\monitoring_server\Entity\PerformanceType
 */
final class PerformanceTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render(): array {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No performance types available. <a href=":link">Add performance type</a>.',
      [':link' => Url::fromRoute('entity.performance_type.add_form')->toString()],
    );

    return $build;
  }

}
