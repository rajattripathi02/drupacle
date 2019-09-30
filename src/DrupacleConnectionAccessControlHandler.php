<?php

namespace Drupal\drupacle;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the DrupacleConnection entity.
 *
 * @see \Drupal\drupacle\Entity\DrupacleConnection.
 */
class DrupacleConnectionAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\drupacle\Entity\DrupacleConnectionInterface $entity */
    switch ($operation) {
      case 'update':
      case 'clone':
        return AccessResult::allowedIfHasPermission($account, 'edit drupacle connections');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete drupacle connections');

      default:
        return parent::checkAccess($entity, $operation, $account);
    }
  }

}
