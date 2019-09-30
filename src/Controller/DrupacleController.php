<?php

namespace Drupal\drupacle\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\drupacle\Entity\DrupacleConnectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityManagerInterface;

/**
 * Class DrupacleController.
 */
class DrupacleController extends ControllerBase {
  /**
   * The entity manager service.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * Construct.
   */
  public function __construct(EntityManagerInterface $entity_manager) {
    $this->entityManager = $entity_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
    $container->get('entity.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function drupalConnectionCallback(DrupacleConnectionInterface $drupacle_connection) : array {
    $connectionId = $drupacle_connection->get('id');
    $db_username = $drupacle_connection->get('username');
    $db_password = $drupacle_connection->get('password');
    $getHost = $drupacle_connection->getHostWithPortAndService();

    $oracleDB = oci_connect($db_username, $db_password, $getHost);
    if ($oracleDB) {
      $response[$connectionId] = $oracleDB;
    }
    else {
      $error = oci_error();
      $response[$connectionId] = $error['message'];
    }
    return $response;
  }

}
