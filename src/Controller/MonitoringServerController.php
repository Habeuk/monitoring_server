<?php
declare(strict_types = 1);

namespace Drupal\monitoring_server\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Returns responses for monitoring_server routes.
 */
final class MonitoringServerController extends ControllerBase {

  /**
   * The controller constructor.
   */
  public function __construct(private readonly EntityTypeManagerInterface $entityTypeManager) {
  }

  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self($container->get('entity_type.manager'));
  }

  /**
   * On ferra la sauvegarde a ce niveau car on a besoin d'un comportement
   * specifique.
   */
  public function __invoke(): array {
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!')
    ];

    return $build;
  }

}
