<?php declare(strict_types = 1);

namespace Drupal\monitoring_server;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a remote_user entity type.
 */
interface RemoteUserInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
