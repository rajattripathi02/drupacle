<?php

namespace Drupal\drupacle;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Component\Render\FormattableMarkup;

/**
 * Provides a listing of Oracle Database connection entities.
 */
class DrupacleConnectionListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Connection');
    $header['db_name'] = $this->t('DB name');
    $header['host'] = $this->t('Host');
    $header['username'] = $this->t('Username');
    $header['port'] = $this->t('Port');
    $header['db_service_name'] = $this->t('Service Name');
    $header['connection_check'] = $this->t('Connection Status');
    $header['short_code'] = $this->t('Short Code');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\drupacle\Entity\DrupacleConnectionInterface $entity */
    $row['label'] = $entity->label();
    $row['db_name'] = $entity->get('db_name');
    $row['host'] = $entity->get('host');
    $row['username'] = $entity->get('username');
    $row['port'] = $entity->get('port');
    $row['db_service_name'] = $entity->get('db_service_name');
    $row['connection_check'] = $this->testOracleConnection($entity);
    $row['short_code'] = new FormattableMarkup('Call this namespace in your file and use below short code - <br /><b><i>use Drupal\drupacle\Controller\DrupacleController;</i></b><textarea onclick="this.select();document.execCommand(\'copy\');setTimeout(function(){ alert(\'Copied to clipboard\'); }, 200);" cols="55" rows="4" readonly="readonly">@shortCode1 &#13;&#10;@shortCode2 &#13;&#10;@shortCode3&#13;&#10;@shortCode4 </textarea>', [
      '@shortCode1' => '$entity_storage = \Drupal::entityTypeManager()->entityManager->getStorage("drupacle_connection");',
      '@shortCode2' => '$entity = $entity_storage->load("' . $entity->label() . '");',
      '@shortCode3' => '$connObj = \Drupal::service("drupacle.connection_service")->drupalConnectionCallback($entity);',
      '@shortCode4' => '$Sql = oci_parse($connObj["' . $entity->label() . '"], "YOUR QUERY");',
    ]
    );
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultOperations(EntityInterface $entity) {
    $operations = parent::getDefaultOperations($entity);
    return $operations;
  }

  /**
   * {@inheritdoc}
   */
  public function testOracleConnection(EntityInterface $entity) {
    if (!extension_loaded('oci8')) {
      return "oci8 extension not found";
    }
    else {
      $oracleOciDbInfo = [
        "db_host" => $entity->get('host'),
        "db_port" => $entity->get('port'),
        "db_user" => $entity->get('username'),
        "db_pass" => $entity->get('password'),
        "db_name" => $entity->get('db_name'),
        "db_service_name" => $entity->get('db_service_name'),
      ];
      $oracleDB = oci_connect($oracleOciDbInfo['db_user'], $oracleOciDbInfo['db_pass'], $oracleOciDbInfo['db_host'] . ':' . $oracleOciDbInfo['db_port'] . '/' . $oracleOciDbInfo['db_service_name']);
      if ($oracleDB) {
        return "success";
      }
      else {
        $error = oci_error();
        return "failed ~ " . $error['message'];
      }

    }
  }

}
