<?php

namespace Drupal\drupacle;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\drupacle\Entity\DrupacleConnection;
use Drupal\drupacle\Entity\DrupacleConnectionInterface;

/**
 * Provides dynamic permissions of the drupacle module.
 *
 * @see drupacle.permissions.yml
 */
class DrupacleConnectionPermissions {

  use StringTranslationTrait;

  /**
   * Get Database Connection permissions.
   *
   * @return array
   *   Permissions array.
   */
  public function permissions() {
    $permissions = [];
    foreach (DrupacleConnection::loadMultiple() as $connection) {
      $permissions += $this->buildPermissions($connection);
    }
    return $permissions;
  }

  /**
   * Builds a standard list of permissions for a Database Connection.
   *
   * @param \Drupal\drupacle\Entity\DrupacleConnectionInterface $connection
   *   The Database Connection.
   *
   * @return array
   *   An array of permission names and descriptions.
   */
  protected function buildPermissions(DrupacleConnectionInterface $connection) {
    $args = ['%connection' => $connection->label()];
    return $args;
  }

}
