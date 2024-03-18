<?php declare(strict_types = 1);

namespace Drupal\monitoring_server;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a host entity type.
 */
interface HostInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
